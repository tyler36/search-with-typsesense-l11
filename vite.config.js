import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import vue from "@vitejs/plugin-vue";

const port = 5173;
const origin = `${process.env.DDEV_PRIMARY_URL}:${port}`;

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    // The Vue plugin will re-write asset URLs, when referenced
                    // in Single File Components, to point to the Laravel web
                    // server. Setting this to `null` allows the Laravel plugin
                    // to instead re-write asset URLs to point to the Vite
                    // server instead.
                    base: null,

                    // The Vue plugin will parse absolute URLs and treat them
                    // as absolute paths to files on disk. Setting this to
                    // `false` will leave absolute URLs un-touched so they can
                    // reference assets in the public directory as expected.
                    includeAbsolute: false,
                },
            },
        }),
    ],

    // Adjust Vites dev server for DDEV: https://vitejs.dev/config/server-options.html
    server: {
        // The following line is require until the release of https://github.com/vitejs/vite/pull/19241
        cors: { origin: process.env.DDEV_PRIMARY_URL },
        // ----------------
        host: '0.0.0.0',
        port: port,
        origin: origin,
        strictPort: true
    },
});
