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
        <button type="submit" class="btn btn-primary">Login</button>
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
        }
    },
    methods: {
        async login() {
            try {
                const response = await fetch(this.loginEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        username: this.username,
                        password: this.password
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Handle successful login
                    this.$router.push('/app');
                } else {
                    this.error = data.message;
                }
            } catch (error) {
                this.error = 'An error occurred. Please try again.';
            }
        }
    }
}
</script>
