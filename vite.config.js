import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'

// https://vite.dev/config/
export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'src'),
        }
    },
    server: {
        proxy: {
            '/cos30043/s103056462/project/backend': {
                target: 'http://localhost:5000', // your backend
                changeOrigin: true,
                secure: false,
                rewrite: (path) => path.replace(/^\/api/, '') // optional: strip /api prefix
            }
        }
    },
    base: "/cos30043/s103056462/project"
})
