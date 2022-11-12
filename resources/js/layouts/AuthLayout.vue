<template>
    <TheNotification @click="close" v-if="message">{{message}}</TheNotification>
    <div class="container-fluid container-1890">
        <div class="row">
            <div class="col-xl-2">
                <AppUser />
                <the-navbar></the-navbar>
            </div>
            <div class="col-xl-10">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import TheNavbar from "../components/TheNavbar.vue";
import AppUser from '../components/ui/AppUser.vue';
import TheNotification from "../components/ui/TheNotification.vue";
import {useStore} from "vuex";
import {computed} from "vue";

export default {
    name: "AuthLayout",
    components: {
        TheNavbar, TheNotification, AppUser,
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
