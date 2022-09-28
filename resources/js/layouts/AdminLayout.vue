<template>
    <TheNotification @click="close" v-if="message">{{message}}</TheNotification>
    <TheAdminNavbar />
    <router-view></router-view>
</template>

<script>
import TheAdminNavbar from "@/components/admin/TheAdminNavbar.vue";
import TheNotification from "@/components/ui/TheNotification.vue";
import { useStore } from 'vuex';
import { computed } from 'vue';

export default {
    name: "AdminLayout",
    components: {
        TheAdminNavbar, TheNotification
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
