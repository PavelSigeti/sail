<template>
    <component :is="layout + '-layout'" v-if="layout" />
</template>

<script>
import {useRoute} from "vue-router";
import {computed, onBeforeMount} from "vue";
import ClearLayout from "./layouts/ClearLayout.vue";
import DashboardLayout from "./layouts/DashboardLayout.vue";
import HomePageLayout from "./layouts/HomePageLayout.vue";
import AuthLayout from "./layouts/AuthLayout.vue";
import AdminLayout from "./layouts/AdminLayout.vue";

export default {
    name: "App",
    components: {
        ClearLayout, DashboardLayout, HomePageLayout,
        AuthLayout, AdminLayout
    },
    setup() {
        const route = useRoute();

        onBeforeMount(() => {

        });

        return {
            layout: computed(() => route.meta.layout),
        }
    }
}
</script>
