import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

import postcssScss from 'postcss-scss';

import postcssImport from 'postcss-import';
import postcssImportExtGlob from 'postcss-import-ext-glob';
import postcssImportUrl from 'postcss-import-url';
import postcssNested from 'postcss-nested';
import postcssCustomSelectors from 'postcss-custom-selectors';
import postcssCustomMedia from 'postcss-custom-media';
import postcssAdvancedVariables from 'postcss-advanced-variables';
import postcssSortMediaQueries from 'postcss-sort-media-queries';
import autoprefixer from 'autoprefixer';

import path from 'path';
import { partytownVite } from '@builder.io/partytown/utils';

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
            '/resources/scripts/app.js',
            '/resources/scripts/count.js',
            '/resources/scripts/prism.js',
            '/resources/scripts/pages/home.js',
            '/resources/scripts/pages/TMASigns.js',
        ]),
        partytownVite({
            dest: path.join(__dirname, 'public/vendor', 'partytown'),
        }),
    ],
    css: {
        devSourcemap: true,
        postcss: {
            parser: postcssScss,
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