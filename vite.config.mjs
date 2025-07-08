import { defineConfig } from 'vite';
import path from 'path';
import fs from 'fs/promises';
import { viteStaticCopy } from 'vite-plugin-static-copy';

export default defineConfig({
    root: 'resources',
    base: '/assets/',
    assetsInclude: ['**/*.png', '**/*.jpg', '**/*.svg', '**/*.gif', '**/*.woff', '**/*.woff2', '**/*.ttf', '**/*.eot'],
    build: {
        outDir: '../public/assets',
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: {
                'js/main.js': path.resolve('resources/js/main.js'),
                'css/main.css': path.resolve('resources/css/main.css'),
                'css/custom.css': path.resolve('resources/css/custom.css'),
                'css/admin.css': path.resolve('resources/css/admin.css'),
                'css/styles.scss': path.resolve('resources/scss/styles.scss'),
            },
            output: {
                assetFileNames: (assetInfo) => {
                    const ext = path.extname(assetInfo.name);
                    if (ext === '.css') return 'style-[hash][extname]';
                    return '[name]-[hash][extname]';
                },
                entryFileNames: '[name]-[hash].js',
                chunkFileNames: 'chunk-[name]-[hash].js',
            }
        }
    },
    plugins: [
        viteStaticCopy({
            targets: [
                {
                    src: 'img',
                    dest: ''
                }
            ]
        }),
        {
            name: 'move-manifest',
            closeBundle: async () => {
                const oldPath = path.resolve('public/assets/.vite/manifest.json');
                const newPath = path.resolve('public/assets/manifest.json');
                try {
                    await fs.rename(oldPath, newPath);
                } catch (e) {
                    console.warn('⚠️ Не удалось переместить manifest.json', e.message);
                }
            }
        }
    ],
    server: {
        host: true,
        port: 5173,
        strictPort: true
    },
    css: {
        preprocessorOptions: {
            scss: {
                silenceDeprecations: [
                    'import',
                    'mixed-decls',
                    'color-functions',
                    'global-builtin',
                ],
            },
        },
    },
});