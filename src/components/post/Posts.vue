<template>
    <div class="mx-4 mt-3 mb-3">
        <div class="row">
            <div class="col-12 col-md-6">
                <router-link class="btn btn-primary col-12 col-md-6 mb-2" to="/create-post">Create Post</router-link>
            </div>
            <div class="col-12 col-md-6">
                <button v-if="page > 1" @click="page--; fetchPosts()" class="btn btn-secondary me-3">Previous
                    Page</button>
                <button @click="page++; fetchPosts()" class="btn btn-secondary">Next Page</button>
            </div>
        </div>
    </div>
    <div v-for="post in posts">
        <div class="card" style="border-radius: 0;">
            <h5 class="card-header d-flex"><span>{{ post.username }}</span><span style="margin-left:auto;">{{
                getDate(post.created_at) }}</span></h5>
            <div class="card-body">
                <h5 class="card-title">{{ post.title }}</h5>
                <p class="card-text">{{ post.content.slice(0, 15) }}...</p>
                <router-link :to="post.id" class="btn btn-primary">View Article</router-link>
            </div>
        </div>
    </div>
</template>
<script>

import API from '@/apiConfig.js'

export default {
    data() {
        return {
            posts: [],
            page: 1
        }
    },
    mounted() {
        this.fetchPosts()
    },
    methods: {
        fetchPosts() {
            fetch(`${API.getPosts}?page=${this.page}`, {
                method: 'GET',
            }).then(res => res.json()
            ).then(data => {
                if (data.success) {
                    if (data.posts.length >= 1) {
                        this.posts = data.posts
                    } else if (this.page > 1) {
                        this.page--
                    }
                }
            }
            )
        },
        getDate(raw) {
            const date = new Date(raw);

            const yy = String(date.getFullYear()).slice(2);
            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const dd = String(date.getDate()).padStart(2, '0');

            return `${yy}/${mm}/${dd}`;
        }
    }
}
</script>
