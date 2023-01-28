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

import { Glob } from 'glob';

const scriptFiles: string[] = new Glob('resources/scripts/**/*.+(t|j)s', { sync: true }).found;

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
        ])
    ],
    css: {
        devSourcemap: true,
        postcss: {
            plugins: [
                postcssImport,
                postcssImportExtGlob,
                postcssAdvancedVariables,
                postcssNesting,
                postcssCustomSelectors,
                postcssCustomMedia,
                postcssSortMediaQueries,
                postcssPresetEnv({
                    browsers: '> 1% and last 10 versions',
                    enableClientSidePolyfills: false,
                })
            ],
        }
    },
});