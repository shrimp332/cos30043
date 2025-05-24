<template>
    <form @submit.prevent="createPost">
        <input type="text" id="title" v-model="title">
        <textarea id="content" v-model="content"></textarea>
        <div class="w-100 text-center">
            <strong v-if="error" class="text-danger">{{ error }}</strong>
        </div>
        <button type="submit" class="btn btn-primary">Post</button>
    </form>
</template>

<script>

import API from "@/apiConfig.js"

export default {
    data() {
        return {
            loading: false,
            title: '',
            content: '',
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
        }
    }
}
</script>
