<template>
    <the-navbar></the-navbar>
  <router-view></router-view>
</template>

<script>
import TheNavbar from "../components/TheNavbar.vue";
export default {
    name: "AuthLayout",
    components: {
        TheNavbar,
    },
    setup() {

    }
}
</script>

<style scoped>

</style>
