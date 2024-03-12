import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
// import eslintPlugin from 'vite-plugin-eslint'

export default defineConfig({
    build: {
        chunkSizeWarningLimit: 700,
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',

                //css
                // 'resources/js/asset/css/prism-okaidia.min.css',
                'resources/js/asset/css/dataTables.bootstrap5.min.css',
                'resources/js/asset/css/bootstrap-switch.min.css',

                //js
                'resources/js/asset/js/app.init.js',
                'resources/js/asset/js/app.min.js',
                'resources/js/asset/js/custom.js',
                'resources/js/asset/js/sidebarmenu.js',
                'resources/js/asset/js/simplebar.min.js',
                // 'resources/js/asset/js/prism.js',
            ],
            refresh: true,
        }),
        // eslintPlugin(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
})
