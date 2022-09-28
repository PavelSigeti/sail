<template>
    <the-navbar></the-navbar>
    <router-view></router-view>
</template>

<script>
import TheNavbar from "../components/TheNavbar.vue";

export default {
    name: "DashboardLayout",
    components: {
        TheNavbar,
    }
}
</script>

<style scoped>

</style>
