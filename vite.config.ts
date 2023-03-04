import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// @ts-ignore
import postcssImport from 'postcss-import';
// @ts-ignore
import postcssImportExtGlob from 'postcss-import-ext-glob';
import postcssNesting from 'postcss-nesting';
import postcssCustomSelectors from 'postcss-custom-selectors';
import postcssCustomMedia from 'postcss-custom-media';
// @ts-ignore
import postcssAdvancedVariables from 'postcss-advanced-variables';
// @ts-ignore
import postcssSortMediaQueries from 'postcss-sort-media-queries';
import postcssPresetEnv from 'postcss-preset-env';

import { globSync } from 'glob';

const scriptFiles: string[] = globSync('resources/scripts/**/*.+(ts|js)');

export default defineConfig({
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost'
        },
    },
    plugins: [
        laravel({
            input: [
                '/resources/css/app.css',
                ...scriptFiles
            ],
            refresh: true,
        })
    ],
    css: {
        devSourcemap: true,
        preprocessorOptions: {
            "postcss": false
        },
        postcss: {
            plugins: [
                postcssImportExtGlob,
                postcssImport,
                // postcssAdvancedVariables,
                // postcssNesting,
                // postcssCustomSelectors,
                // postcssCustomMedia,
                postcssPresetEnv({
                    stage: 0,
                    enableClientSidePolyfills: false
                })
            ],
        }
    },
});