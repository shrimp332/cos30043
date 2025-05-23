import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'

// https://vite.dev/config/
export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'src'),
            'api': "http://localhost:5000", // PHP API TODO: CHANGE THE MERCURY WHEN DEPLOYING
        }
    },
})
