<template>
    <TheNotification @click="close" v-if="message">{{message}}</TheNotification>
    <the-navbar></the-navbar>
    <router-view></router-view>
</template>

<script>
import TheNavbar from "../components/TheNavbar.vue";
import TheNotification from "../components/ui/TheNotification.vue";
import {useStore} from "vuex";
import {computed} from "vue";

export default {
    name: "AuthLayout",
    components: {
        TheNavbar, TheNotification,
    },
    setup() {
        const store = useStore();

        const close = () => {
            store.dispatch('notification/clearMessage');
        }
        const message = computed(() => store.getters['notification/message']);

        return {
            close, message
        }
    }
}
</script>

<style scoped>

</style>
