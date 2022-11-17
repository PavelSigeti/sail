<template>
    <ul class="menu">
        <li class="menu-item"><router-link to="/dashboard"><i class="ri-function-line"></i><span>Главная</span></router-link></li>
        <li class="menu-item"><router-link :to="{name: 'user.stages'}"><i class="ri-sailboat-line"></i><span>Регаты</span></router-link></li>
        <li class="menu-item"><router-link to="/dashboard"><i class="ri-trophy-line"></i><span>Результаты регат</span></router-link></li>
        <li class="menu-item"><router-link to="/dashboard"><i class="ri-team-line"></i><span>Команды</span></router-link></li>
        <li class="menu-item"><router-link to="/dashboard"><i class="ri-file-line"></i><span>Регламент</span></router-link></li>
        <li class="menu-item"><router-link to="/dashboard"><i class="ri-information-line"></i><span>О проекте</span></router-link></li>
    </ul>
    <TheAdminNavbar v-if="admin" />

</template>

<script>
import { useStore } from 'vuex';
import '@/utils/remixicon/remixicon.css';
import TheAdminNavbar from '@/components/admin/TheAdminNavbar.vue';

export default {
    name: "TheNavbar",
    components: {
        TheAdminNavbar,
    },
    setup() {
        const store = useStore();

        const admin = store.getters['auth/user'].role === 'admin';

        return {
             admin,
        }
    }
}
</script>
