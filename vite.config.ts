import { defineConfig, loadEnv } from 'vite';
import { fileURLToPath, URL } from 'node:url';
import vue from '@vitejs/plugin-vue';
import vuetify from 'vite-plugin-vuetify';

export default ({ mode }) => {
    const config = {
        plugins: [
            vue(),
            vuetify({
                autoImport: true,
            }),
        ],
        resolve: {
            alias: {
                '@': fileURLToPath(new URL('./src', import.meta.url))
            },
            extensions: [
                '.js',
                '.json',
                '.jsx',
                '.mjs',
                '.ts',
                '.tsx',
                '.vue',
            ],
        },
        base: undefined,
        publicDir: 'assets',
        server: {
            host: 'localhost',
            port: 5175,
            strictPort: true
        },
        build: {
            outDir: 'public'
        }
    };

    process.env = {...process.env, ...loadEnv(mode, process.cwd())};
    const SKIP_BASE_PATH = process.env.VITE_SKIP_BASE_BATH;
    if (SKIP_BASE_PATH === undefined || SKIP_BASE_PATH === 'false')
        config.base = '/bato-maj-dlc/';

    return defineConfig(config);
};