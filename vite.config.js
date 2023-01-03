import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

import postcssImport from 'postcss-import';
import postcssImportExtGlob from 'postcss-import-ext-glob';
import postcssNested from 'postcss-nested';
import postcssCustomSelectors from 'postcss-custom-selectors';
import postcssCustomMedia from 'postcss-custom-media';
import postcssAdvancedVariables from 'postcss-advanced-variables';
import postcssSortMediaQueries from 'postcss-sort-media-queries';
import postcssPresetEnv from 'postcss-preset-env';
import autoprefixer from 'autoprefixer';

import path from 'path';
import { Glob } from 'glob';
import { partytownVite } from '@builder.io/partytown/utils';

var scriptFiles = new Glob('resources/scripts/**/*.+(t|j)s', { sync: true }).found;

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
            ...scriptFiles
        ]),
        partytownVite({
            dest: path.join(__dirname, 'public/vendor', 'partytown'),
        }),
    ],
    css: {
        devSourcemap: true,
        postcss: {
            plugins: [
                postcssImport,
                postcssImportExtGlob,
                postcssAdvancedVariables,
                postcssNested,
                postcssCustomSelectors,
                postcssCustomMedia,
                postcssSortMediaQueries,
                postcssPresetEnv({
                    browsers: '> 1% and last 10 versions',
                    enableClientSidePolyfills: false
                })
            ],
        }
    },
});