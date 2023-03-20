import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import { svelte } from '@sveltejs/vite-plugin-svelte';

const codespaceName = process.env['CODESPACE_NAME'];
const hmrPort = 3001;

const hmrRemoteHost = codespaceName ? `${codespaceName}-${hmrPort}.githubpreview.dev` : 'localhost';
const hmrRemotePort = codespaceName ? 443 : hmrPort;

export default defineConfig({

    server: {
        hmr: {
            host: hmrRemoteHost,
            port: hmrPort,
            clientPort: hmrRemotePort
        },
    },

    plugins: [
        laravel.default({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js'
            ],
            
            refresh: true,
        }),
        svelte({}),
    ],
});
