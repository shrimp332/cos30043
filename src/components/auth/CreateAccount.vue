<template>
    <form class="border bg-light w-75 px-5 py-4 position-absolute top-50 start-50 translate-middle" id="form"
        @submit.prevent="createAccount">
        <h1 class="text-center fs-2">Create Account</h1>
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" class="form-control" id="username" v-model="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" id="password" v-model="password" required>
        </div>
        <div class="mb-3">
            <label for="password2" class="form-label">Confirm Password:</label>
            <input type="password" class="form-control" id="password2" v-model="password2" required>
            <span v-if="!isPasswordSame()" class="text-danger">Passwords must match</span>
        </div>
        <div class="w-100 text-center">
            <strong v-if="error" class="text-danger">{{ error }}</strong>
        </div>
        <button type="submit" class=" btn btn-primary" :disabled="loading || !isPasswordSame()">
            <span v-if="!loading">Create</span>
            <span v-if="loading" class="spinner-border spinner-border-sm"></span>
            <span class="ms-2" v-if="loading">Loading..</span>
        </button>
        <div class="mt-2">
            <router-link to="/login">Click here to login</router-link>
        </div>
    </form>
</template>

<script>
import API from "@/apiConfig.js"

export default {
    data() {
        return {
            error: "",
            username: "",
            password: "",
            password2: "",
            loading: false
        }
    },
    methods: {
        async createAccount() {
            try {
                this.loading = true
                const response = await fetch(API.createAccount, {
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

                if (response.status == 404) {
                    this.error = `Failed to create account. Error: ${response.status}`
                    return
                }

                const data = await response.json();

                if (data.success) {
                    this.$router.push('/login');
                } else {
                    this.error = data.error;
                }
            } catch (error) {
                this.error = 'An error occurred. Try again.';
            }
        },
        isPasswordSame() {
            return this.password == this.password2;
        }
    }
}
</script>
