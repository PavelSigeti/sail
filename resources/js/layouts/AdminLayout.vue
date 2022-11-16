<template>
    <TheNotification v-if="message" :payload="{message, type}"></TheNotification>
    <div class="container-fluid container-1890">
        <div class="row">
            <div class="col-xl-2 sidebar__container">
                <div class="sidebar">
                    <div class="sidebar-main">
                        <AppUser />
                        <the-navbar></the-navbar>
                    </div>
                    <div class="sidebar-bottom">
                        <div class="menu-item menu-item__exit" @click="logout"><a @click.prevent="logout" href="#"><img src="@/static/exit.svg" alt=""><span>Выйти</span></a></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-10">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import TheNavbar from "../components/TheNavbar.vue";
import TheNotification from "@/components/ui/TheNotification.vue";
import { useStore } from 'vuex';
import { computed } from 'vue';
import AppUser from '../components/ui/AppUser.vue';


export default {
    name: "AdminLayout",
    components: {
        TheNavbar, TheNotification, AppUser,
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

<style scoped lang="scss">
     :deep(){
            @import '../static/scss/admin.scss';
    }
</style>
