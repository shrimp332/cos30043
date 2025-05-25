<template>
    <div class="container mt-4">
        <div class="row">
            <form class="col-12 col-md-6 mb-5" @submit.prevent="createPost">
                <label class="form-label" for="title">Title:</label>
                <input class="form-control" type="text" id="title" v-model="title">
                <label class="form-label" for="content">Content:</label>
                <textarea @keydown="handleTab" class="form-control" id="content" v-model="content"></textarea>
                <div class="w-100 text-center">
                    <strong v-if="error" class="text-danger">{{ error }}</strong>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Post</button>
            </form>
            <div class="col-12 col-md-6">
                <h4>Preview:</h4>
                <div class="mx-4 mt-4" v-html="compiledContent"></div>
            </div>
        </div>
    </div>
</template>

<script>

import API from "@/apiConfig.js"
import { marked } from 'marked';
import hljs from 'highlight.js';
import 'highlight.js/styles/tokyo-night-dark.css';
import { ref, watch, nextTick } from 'vue'

export default {
    data() {
        return {
            loading: false,
            title: '',
            content: '',
            compiledContent: '',
            error: ''
        }
    },
    methods: {
        async createPost() {
            try {
                this.loading = true
                const response = await fetch(API.createPost, {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        title: this.title,
                        content: this.content,
                        username: 'shrimp332'
                    })
                })
                if (response.status == 404) {
                    this.error = `Failed to create account. Error: ${response.status}`
                    return
                }

                const data = await response.json();

                if (data.success) {
                    this.$router.push('/app');
                } else {
                    this.error = data.error;
                }
            } catch (error) {
                console.error(error)
                this.error = 'An error occurred. Try again.';
            }
        },
        handleTab(event) {
            if (event.key === 'Tab') {
                event.preventDefault()

                const textarea = event.target
                const start = textarea.selectionStart
                const end = textarea.selectionEnd

                // Insert tab character at cursor position
                this.content =
                    this.content.substring(0, start) +
                    '\t' +
                    this.content.substring(end)

                // Move cursor after inserted tab
                this.$nextTick(() => {
                    textarea.selectionStart = textarea.selectionEnd = start + 1
                })
            }
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
}
</script>
