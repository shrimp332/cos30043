<template>
    <h1 class="mx-3 mt-4">{{ title }}</h1>
    <span class="mx-4">Authored By <strong>{{ owner }}</strong></span><br>
    <span class="mx-4">{{ createdAt }}</span><br>
    <span class="mx-4">Likes: {{ likes }}</span><br>
    <button class="btn btn-warning mx-4 mt-3" @click="deletePost" v-if="isOwner">Delete Post</button>
    <div class="mx-4 mt-4" v-html="compiledContent"></div>

    <div v-if="logged_in">
        <button @click="postLike" class="mx-4 my-2 btn btn-outline-danger">Like</button>
    </div>

    <h4 class="mx-3 mt-2">Comments</h4>
    <div class="mx-4" v-for="c in comments">
        <strong>{{ c.username }}:</strong>
        <span class="ms-1">{{ c.content }}</span>
    </div>
    <form class="mt-3 mx-4" v-if="logged_in" @submit.prevent="postComment">
        <div class="input-group">
            <input type="text" class="form-control" v-model="comment">
            <button :disabled="loading" class="btn btn-primary btn-primary-outline">
                <span v-if="!loading">Comment</span>
                <span v-if="loading" class="spinner-border spinner-border-sm"></span>
                <span class="ms-2" v-if="loading">Loading..</span>
            </button>
        </div>
    </form>
    <div class="mt-5"></div>
</template>

<script>

import API from '@/apiConfig.js'
import { marked } from 'marked';
import hljs from 'highlight.js';
import 'highlight.js/styles/tokyo-night-dark.css';

import { ref, watch, nextTick } from 'vue'

marked.setOptions({
    highlight(code, lang) {
        if (lang && hljs.getLanguage(lang)) {
            return hljs.highlight(code, { language: lang }).value
        }
        return hljs.highlightAuto(code).value
    }
})

export default {
    data() {
        return {
            title: '',
            content: '',
            createdAt: '',
            owner: '',
            comments: [],
            compiledContent: '',
            comment: '',
            error: '',
            loading: false,
            liked: false,
            likes: 0,
            isOwner: false,
        }
    },
    mounted() {
        this.fetchPost()
        this.fetchComments()
    },
    methods: {
        fetchPost() {
            fetch(`${API.getPost}?post_id=${this.$route.params.id}`, {
                method: 'GET',
            }).then(res => res.json()
            ).then(data => {
                if (data.success) {
                    this.title = data.title
                    this.content = data.content
                    this.owner = data.owner
                    this.likes = data.likes
                    this.isOwner = this.owner == this.$store.state.username

                    const date = new Date(data.timestamp);

                    const yy = String(date.getFullYear()).slice(2);
                    const mm = String(date.getMonth() + 1).padStart(2, '0');
                    const dd = String(date.getDate()).padStart(2, '0');

                    this.createdAt = `${yy}/${mm}/${dd}`;
                }
            }
            )
        },
        fetchComments() {
            fetch(`${API.getComments}?post_id=${this.$route.params.id}`, {
                method: 'GET',
            }).then(res => res.json()
            ).then(data => {
                if (data.success) {
                    this.comments = data.comments
                }
            }
            )
        },
        postComment() {
            this.loading = true
            fetch(API.createComment, {
                method: 'POST',
                credentials: 'include',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    post_id: this.$route.params.id,
                    content: this.comment
                })
            }).then(res => res.json()
            ).then(data => {
                if (!data.success) {
                    this.error = data.error
                }
                this.loading = false

                this.comment = ''
                this.fetchComments();
            })
        },
        postLike() {
            fetch(API.createLike, {
                method: 'POST',
                credentials: 'include',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    post_id: this.$route.params.id,
                })
            }).then(res => res.json()
            ).then(data => {
                if (!data.success) {
                    this.error = data.error
                }
                this.fetchPost()
            })
        },
        deletePost() {
            fetch(API.deletePost, {
                method: 'DELETE',
                credentials: 'include',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    post_id: this.$route.params.id,
                })
            }).then(res => res.json()
            ).then(data => {
                if (!data.success) {
                    this.error = data.error
                }
                this.$router.push('/app')
            })
        }
    },
    watch: {
        content: {
            immediate: true,
            async handler(newContent) {
                this.compiledContent = marked(newContent)
                await nextTick()
                hljs.highlightAll()
            }
        }
    },
    computed: {
        logged_in() {
            return this.$store.state.logged_in
        }
    }
}
</script>
