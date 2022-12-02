import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

import postcssImport from 'postcss-import';
import postcssImportExtGlob from 'postcss-import-ext-glob';
import postcssImportUrl from 'postcss-import-url';
import postcssNested from 'postcss-nested';
import postcssCustomSelectors from 'postcss-custom-selectors';
import postcssCustomMedia from 'postcss-custom-media';
import postcssAdvancedVariables from 'postcss-advanced-variables';
import postcssSortMediaQueries from 'postcss-sort-media-queries';
import autoprefixer from 'autoprefixer';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        laravel([
            '/resources/css/app.css',
            '/resources/js/app.js',
            '/resources/js/prism.js',
            '/resources/js/pages/home.js',
            '/resources/js/pages/TMASigns.js',
        ]),
    ],
    css: {
        devSourcemap: true,
        postcss: {
            plugins: [
                postcssImport,
                postcssImportExtGlob,
                postcssImportUrl,
                postcssNested,
                postcssCustomSelectors,
                postcssCustomMedia,
                postcssAdvancedVariables,
                postcssSortMediaQueries,
                autoprefixer,
            ],
        }
    },
});