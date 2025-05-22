<template>
    <h1>About</h1>
    <p>
        This <router-link to="/app">app</router-link> is a user-generated news site. It allows for users to created
        articles, these could be blogging or a tutorial, that are uploaded into mariadb on mercury. Content is inserted
        and retrieved from the database through a backend on mercury written in PHP. Every page on this site is routed
        through Vue router, so there are no full page loads. User authentication is handled through the backend php
        service and state, such as session_id and username are stored in vuex. The user generated articles are entered
        in markdown, which then html is generated based upon it.
    </p>

    <h2>Welcome {{ firstname }} {{ lastname }}</h2>
    <label for="firstname">First Name:</label>
    <input id="firstname" v-model="firstname" type="text" />
    <label for="lastname">Last Name:</label>
    <input id="lastname" v-model="lastname" type="text" />

    <fieldset>
        <input id="ocean" type="radio" name="image" value="lizard" v-model="image" checked>
        <label for="ocean">Lizard</label>
        <input id="mountain" type="radio" name="image" value="elephant" v-model="image">
        <label for="mountain">Elephant</label>
    </fieldset>

    <img src="/lizard.jpg" alt="lizard" width="500" v-if="image == 'lizard'">
    <img src="/elephant.jpg" alt="lizard" width="500" v-if="image == 'elephant'">

</template>

<script>
export default {
    data() {
        return {
            firstname: "",
            lastname: "",
            image: "lizard",
        }
    },
}
</script>

<style scoped></style>
