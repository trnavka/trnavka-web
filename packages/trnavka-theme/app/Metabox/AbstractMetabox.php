<?php

namespace App\Metabox;

use Exception;

class AbstractMetabox
{
    private string $postTypeId;
    private string $metaboxId;

    public function __construct(
        string $postTypeId,
        string $title,
        array  $args
    )
    {
        $this->postTypeId = $postTypeId;
        $this->metaboxId = static::id();

        add_action('init', fn() => register_post_type($postTypeId, $args));
        add_action('add_meta_boxes', fn() => add_meta_box(
            $this->metaboxId,
            $title,
            [$this, 'renderMetaBox'],
            $this->postTypeId,
            'advanced',
            'high'
        ));
        add_action('save_post', [$this, 'saveMetaBox']);
    }

    public static function id(): string
    {
        return str_replace('\\', '_', static::class);
    }

    public function saveMetaBox($postId)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!isset($_POST[$this->nonceId()]) || !wp_verify_nonce($_POST[$this->nonceId()], static::class)) {
            return;
        }

        if (!current_user_can('edit_post', $postId)) {
            return;
        }

        if (array_key_exists($this->metaboxId, $_POST)) {
            update_post_meta(
                $postId,
                $this->metaboxId,
                $_POST[$this->metaboxId]
            );
        }
    }

    private function nonceId(): string
    {
        return $this->metaboxId . '_nonce';
    }

    protected function fieldName(string $name): void
    {
        echo $this->fieldNameString($name);
    }

    protected function fieldNameString(string $name): string
    {
        return $this->metaboxId . '[' . $name . ']';
    }

    /**
     * @param array $meta
     * @return void
     * @throws Exception
     */
    protected function renderForm(array $meta): void
    {
        throw new Exception('Method renderForm() must be implemented');
    }

    public function renderMetaBox($post): void
    {
        $meta = get_post_meta($post->ID, $this->metaboxId, true); ?>

        <input type="hidden" name="<?php echo $this->nonceId(); ?>" value="<?php echo wp_create_nonce(static::class); ?>">

        <style>
            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                display: block;
                margin-bottom: 5px;
            }
        </style>

        <?php

        $this->renderForm(is_array($meta) ? $meta : []);
    }
}
