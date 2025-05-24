<template>
    <nav class="navbar bg-dark text-white">
        <router-link class="fs-5 text-reset" style="margin-left:1em; margin-right: 1em;" to="/">Home</router-link>
        <router-link class="fs-5 text-reset" style="margin-right: 1em;" to="/app">App</router-link>
        <router-link class="fs-5 text-reset" style="margin-right: 1em;" to="/news">News</router-link>
        <router-link class="fs-5 text-reset" style="margin-right: 1em; margin-left:auto;" to="/about">About</router-link>
        <router-link v-if="!logged_in" class="fs-5 text-reset" style="margin-right: 1em;" to="/login">Login</router-link>
        <router-link v-if="logged_in" class="fs-5 text-reset" style="margin-right: 1em;" to="/logout">Logout</router-link>
    </nav>
</template>

<script>
import { mapState } from 'vuex';

export default {
    computed: {
        logged_in() {
            return this.$store.state.logged_in
        }
    }
}
</script>

<style scoped></style>
