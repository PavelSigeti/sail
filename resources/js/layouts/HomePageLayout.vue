<template>
    <the-navbar></the-navbar>
    <router-view></router-view>
</template>

<script>
import TheNavbar from "../components/TheNavbar.vue";

export default {
    name: "HomePageLayout",
    components: {
        TheNavbar
    }
}
</script>

<style scoped>

</style>
