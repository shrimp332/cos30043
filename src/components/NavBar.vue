<template>
    <nav class="bg-dark text-white p-2">
        <router-link class="fs-5 text-reset ms-3 me-3" to="/">Home</router-link>
        <router-link class="fs-5 text-reset me-3" to="/app">App</router-link>
        <router-link class="fs-5 text-reset me-3" to="/news">News</router-link>
        <router-link class="fs-5 text-reset me-3" to="/about">About</router-link>
        <router-link v-if="!logged_in" class="fs-5 text-reset me-3" to="/login">Login</router-link>
        <router-link v-if="logged_in" class="fs-5 text-reset me-2" to="/logout">Logout</router-link>
    </nav>
</template>

<script>

export default {
    computed: {
        logged_in() {
            return this.$store.state.logged_in
        }
    }
}
</script>

<style scoped></style>
