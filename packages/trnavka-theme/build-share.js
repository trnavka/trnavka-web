import fs from 'fs';

const file = JSON.parse(fs.readFileSync('public/manifest.json', 'utf8'))['app/themes/theme/public/share.js'] ?? null;

if (file === null) {
    throw new Error('File not found during build-share.js.');
}

fs.copyFileSync(file.replace('/app/themes/theme/', ''), 'public/share.js');
