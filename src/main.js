import { createApp } from 'vue'
import '@/style.css'
import App from '@/App.vue'

import { createStore } from 'vuex'

import { createWebHistory, createRouter } from 'vue-router'

import Home from '@/components/Home.vue'
import News from '@/components/News.vue'
import About from '@/components/About.vue'
import Login from '@/components/auth/Login.vue'
import Logout from '@/components/auth/Logout.vue'
import CreateAccount from '@/components/auth/CreateAccount.vue'
import CreatePost from '@/components/post/CreatePost.vue'
import Post from '@/components/Post.vue'

const routes = [
    { path: '/', component: Home },
    { path: '/news', component: News },
    { path: '/about', component: About },
    { path: '/login', component: Login },
    { path: '/logout', component: Logout},
    { path: '/create-account', component: CreateAccount },
    { path: '/create-post', component: CreatePost },
    { path: '/post/:id', component: Post }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})


const store = createStore({
    state() {
        return {
            logged_in: false,
            username: '',
        }
    },
    mutations: {
        setUsername(state, u) {
            state.username = u
            state.logged_in = true
        },
        logout(state, _) {
            state.username = ''
            state.logged_in = false
        },

    }
})

import API from "@/apiConfig.js"

fetch(API.username, {
    method: 'GET',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
}).then(res => res.json()
).then(data => {
    if (data.success) {
        store.commit('setUsername', data.username)
    }
}
)

createApp(App).use(store).use(router).mount('#app')
