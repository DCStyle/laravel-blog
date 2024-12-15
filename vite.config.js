import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';

function getFiles(dir, ext) {
    let files = [];
    const items = fs.readdirSync(dir, { withFileTypes: true });

    for (const item of items) {
        if (item.isDirectory()) {
            files = [...files, ...getFiles(path.join(dir, item.name), ext)];
        } else if (item.name.endsWith(ext)) {
            files.push(path.join(dir, item.name));
        }
    }

    return files;
}

export default defineConfig({
    plugins: [
        laravel({
            input: [
                ...getFiles('resources/css', '.css'),
                ...getFiles('resources/js', '.js')
            ],
            refresh: true,
        }),
    ],
});
