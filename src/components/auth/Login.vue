<template>
    <form class="border bg-light w-75 px-5 py-4 position-absolute top-50 start-50 translate-middle" id="form"
        @submit.prevent="login">
        <h1 class="text-center fs-2">Login</h1>
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" class="form-control" id="username" v-model="username">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" id="password" v-model="password">
        </div>
        <div class="w-100 text-center">
            <strong v-if="error" class="text-danger">{{ error }}</strong>
        </div>
        <button type="submit" class=" btn btn-primary" :disabled="loading">
            <span v-if="!loading">Login</span>
            <span v-if="loading" class="spinner-border spinner-border-sm"></span>
            <span class="ms-2" v-if="loading">Loading..</span>
        </button>
        <div class="mt-2">
            <router-link to="/create-account">Click here to create acount</router-link>
        </div>
    </form>
</template>

<script>
import API from "@/apiConfig.js"
export default {
    data() {
        return {
            loginEndpoint: API.login,
            error: "",
            username: "",
            password: "",
            loading: false
        }
    },
    methods: {
        async login() {
            try {
                this.loading = true
                const response = await fetch(this.loginEndpoint, {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        username: this.username,
                        password: this.password
                    })
                });
                this.loading = false

                if (!response.ok) {
                    this.error = `Failed to log in. Error: ${response.status}`
                    return
                }

                const data = await response.json();

                if (data.success) {
                    // Handle successful login
                    this.$router.push('/app');
                } else {
                    this.error = data.error;
                }
            } catch (error) {
                this.error = 'An error occurred. Please try again.';
            }
        }
    }
}
</script>
