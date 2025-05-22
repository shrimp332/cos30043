import { createApp } from 'vue'
import './style.css'
import App from './App.vue'

import { createWebHistory, createRouter } from 'vue-router'

import Home from './components/Home.vue'
import News from './components/News.vue'
import About from './components/About.vue'

const routes = [
    { path: '/', component: Home},
    { path: '/news', component: News},
    { path: '/about', component: About},
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

createApp(App).use(router).mount('#app')
