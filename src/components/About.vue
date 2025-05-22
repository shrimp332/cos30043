<template>
    <h1>About</h1>
    <p>This <router-link to="/app">app</router-link> is a user-generated news site. It allows for users to created articles, these could be blogging or a tutorial, that are uploaded into mariadb on mercury. Content is inserted and retrieved from the database through a backend on mercury written in PHP. Every page on this site is routed through Vue router, so there are no full page loads. User authentication is handled through the backend php service and state, such as session_id and username are stored in vuex. The user generated articles are entered in markdown, which then html is generated based upon it.</p>

</template>

<style scoped>
</style>

