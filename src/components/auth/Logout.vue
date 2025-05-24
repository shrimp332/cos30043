<template>
    <span>Logging out</span>
</template>
<script>
import API from '@/apiConfig.js'

export default {
    mounted() {
        this.handleLogout();
    },
    methods: {
        handleLogout() {
            fetch(API.logout, {
                method: 'POST',
                credentials: 'include',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    username: this.$store.state.username
                })
            }).then(res => res.json()
            ).then(data => {
                if (data.success) {
                    this.$store.commit('logout', 0)
                    this.$router.push('/login')
                }
            }
            )
        }
    }
}

</script>
