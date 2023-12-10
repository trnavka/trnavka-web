<?php

namespace App\Services;

use DateTimeImmutable;
use Exception;
use PDO;

class Legacy
{
    private ?PDO $legacyDb = null;

    public function lastestPosts()
    {
        $statement = $this->connection()->prepare('
            SELECT p.*, pm1.meta_value AS mv1, pm2.meta_value AS attachment_metadata, pm3.meta_value AS attachment_url FROM wp_posts AS p
                INNER JOIN wp_term_relationships tr ON p.ID = tr.object_id
                INNER JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                     LEFT JOIN
            wp_postmeta pm1 ON p.ID = pm1.post_id AND pm1.meta_key = \'_thumbnail_id\'
        LEFT JOIN
            wp_postmeta pm2 ON pm1.meta_value = pm2.post_id AND pm2.meta_key = \'_wp_attachment_metadata\'
        LEFT JOIN
            wp_postmeta pm3 ON pm1.meta_value = pm3.post_id AND pm3.meta_key = \'_wp_attached_file\'


             WHERE tt.term_id = 66 AND p.post_type = "post" AND p.post_status = "publish" ORDER BY post_date DESC LIMIT 6');
        $statement->execute();

        $legacyBaseUrl = env('HTML_HEADER_URL') . 'wp-content/uploads/';

        $contextOptions=array(
            "ssl"=>array(
                "allow_self_signed"=>true,
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $streamContext = stream_context_create($contextOptions);
        $legacyDir = wp_upload_dir()['basedir'] . '/legacy/';
        $fourHoursAgo = new DateTimeImmutable('4 hour ago');

        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $post) {
            $post['excerpt'] = wp_trim_words(strip_tags($post['post_content']));
            $attachment = unserialize($post['attachment_metadata']);
            $post['attchment'] = $attachment;
            $file = '';

            $download = false;
            $missingStored = false;
            $missingFilePath = $legacyDir . $post['ID'] . '.txt';

            try {
                if (is_array($attachment) && isset($attachment['sizes']['medium_large']['file'])) {
                    $file = $attachment['file'] ?? '';
                }

                if (empty($file)) {
                    $file = $post['attachment_url'];
                }

                if (empty($file)) {
                    $post['thumbnail_url'] = '';
                } else {
                    $filePath = $legacyDir . $file;

                    if (is_file($filePath)) {
                        $post['thumbnail_url'] = '/app/uploads/legacy/' . $file;
                    } elseif (is_file($missingFilePath)) {
                        $missingLastChecked = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', trim(file_get_contents($missingFilePath)));

                        if ($fourHoursAgo > $missingLastChecked) {
                            $download = true;
                        } else {
                            $missingStored = true;
                        }

                        $post['thumbnail_url'] = '';
                    } else {
                        $download = true;
                    }

                    if ($download) {
                        $fileContent = @file_get_contents($legacyBaseUrl . $file, false, $streamContext);

                        if (!empty($fileContent)) {
                            $this->saveFile($filePath, $fileContent);
                            $resizedFilePath = $this->resizeImage($filePath);
                            $this->saveFile($filePath, @file_get_contents($resizedFilePath));
                            unlink($resizedFilePath);

                            $post['thumbnail_url'] = '/app/uploads/legacy/' . $file;
                        } else {
                            $post['thumbnail_url'] = '';
                        }
                    }
                }
            } catch (Exception $e) {
                $missingStored = false;
                $post['thumbnail_url'] = '';
            }

            if (empty($post['thumbnail_url']) && !$missingStored) {
                $this->saveFile($missingFilePath, date('Y-m-d H:i:s'));
            }

            yield $post;
        }
    }

    private function saveFile($filePath, $content)
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $directory = pathinfo($filePath, PATHINFO_DIRNAME);

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($filePath, $content);
    }

    private function resizeImage($filePath) {
        $image_editor = wp_get_image_editor($filePath);

        if (!is_wp_error($image_editor)) {
            $image_editor->resize(750, null);

            $resizedFilePath = preg_replace('/\.[^.]+$/', '-750$0', $filePath);

            // Save the resized image
            $saved = $image_editor->save($resizedFilePath);

            if (!is_wp_error($saved)) {
                return $resizedFilePath;
            }
        }

        return '';
    }

    private function connection(): PDO
    {
        $legacyDatabaseUrl = parse_url(env('LEGACY_DATABASE_URL') ?? throw new Exception('Missing environment parameter "LEGACY_DATABASE_URL"'));

        $legacyDatabaseHost = $legacyDatabaseUrl['host'];
        $legacyDatabaseName = substr($legacyDatabaseUrl['path'], 1);
        $legacyDatabaseUser = $legacyDatabaseUrl['user'] ?? 'root';
        $legacyDatabasePass = $legacyDatabaseUrl['pass'] ?? '';
        $legacyDatabasePort = $legacyDatabaseUrl['port'] ?? 3306;

        return $this->legacyDb ?? new PDO('mysql:host=' . $legacyDatabaseHost . ';dbname=' . $legacyDatabaseName . ';port=' . $legacyDatabasePort . ';charset=utf8mb4',
            $legacyDatabaseUser,
            $legacyDatabasePass,
        );
    }
}
