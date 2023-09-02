import { defineConfig } from 'vite';
import { resolve, dirname } from 'node:path';
import { fileURLToPath } from 'url';
import VueI18nPlugin from '@intlify/unplugin-vue-i18n/vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import svgLoader from 'vite-svg-loader';
import { createSvgIconsPlugin } from 'vite-plugin-svg-icons';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        svgLoader(),
        createSvgIconsPlugin({
            iconDirs: [
                resolve(process.cwd(), 'resources/svg'),
            ],
            symbolId: 'icon-[name]',
        }),
        VueI18nPlugin({
            include: resolve(dirname(fileURLToPath(import.meta.url)), './resources/js/locales/**'),
        }),
    ],
});
