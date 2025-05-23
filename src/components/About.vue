<template>
    <h1 class="pt-4 text-center">About</h1>
    <p class="ms-3 me-3 text-center">
        This <router-link to="/app">app</router-link> is a user-generated news site. It allows for users to created
        articles, these could be blogging or a tutorial, that are uploaded into mariadb on mercury. Content is inserted
        and retrieved from the database through a backend on mercury written in PHP. Every page on this site is routed
        through Vue router, so there are no full page loads. User authentication is handled through the backend php
        service and state, such as session_id and username are stored in vuex. The user generated articles are entered
        in markdown, which then html is generated based upon it.
    </p>

    <h2 class="pt-4 text-center">Welcome {{ firstname }} {{ lastname }}!</h2>
    <div style="margin-left: 10%;margin-right:10%;">
        <label class="form-label" for="firstname">First Name:</label>
        <input class="form-control" id="firstname" v-model="firstname" type="text" />
        <label class="form-label" for="lastname">Last Name:</label>
        <input class="form-control" id="lastname" v-model="lastname" type="text" />

        <div class="mt-4 mb-2 text-center">
            <div class="mt-5 w-50 d-inline">
                <input class="form-check-input" id="ocean" type="radio" name="image" value="lizard" v-model="image"
                    checked>
                <label class="ms-1 me-4 form-check-label" for="ocean">Lizard</label>
            </div>
            <div class="w-50 d-inline">
                <input class="form-check-input" id="mountain" type="radio" name="image" value="elephant"
                    v-model="image">
                <label class="ms-1 form-check-label" for="mountain">Elephant</label>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <img class="w-75" src="/lizard.jpg" alt="lizard" v-if="image == 'lizard'">
        <img class="w-75" src="/elephant.jpg" alt="lizard" v-if="image == 'elephant'">
    </div>

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
