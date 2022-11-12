<template>
    <TheNotification v-if="message" :payload="{message, type}"></TheNotification>
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

        const message = computed(() => store.getters['notification/message']);
        const type = computed(() => store.getters['notification/type']);

        return {
            message, type,
        }
    }
}
</script>

<style scoped>

</style>
