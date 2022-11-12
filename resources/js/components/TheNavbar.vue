<template>
    <ul class="menu">
        <li class="menu-item"><router-link to="/dashboard"><i class="ri-function-line"></i><span>Главная</span></router-link></li>
        <li class="menu-item"><router-link to="/dashboard"><i class="ri-sailboat-line"></i><span>Регаты</span></router-link></li>
        <li class="menu-item"><router-link to="/dashboard"><i class="ri-trophy-line"></i><span>Результаты регат</span></router-link></li>
        <li class="menu-item"><router-link to="/dashboard"><i class="ri-team-line"></i><span>Команды</span></router-link></li>
        <li class="menu-item"><router-link to="/dashboard"><i class="ri-file-line"></i><span>Регламент</span></router-link></li>
        <li class="menu-item"><router-link to="/dashboard"><i class="ri-information-line"></i><span>О проекте</span></router-link></li>
        <li class="menu-item"><router-link to="/settings">Settings</router-link></li>
        <li v-if="auth" class="menu-item menu-item__exit"><a @click.prevent="logout" href="#">Logout</a></li>
    </ul>
</template>

<script>
import { useStore } from 'vuex';
import {computed} from "vue";
import '@/utils/remixicon/remixicon.css';

export default {
    name: "TheNavbar",
    setup() {
        const store = useStore();

        const auth = computed(() => store.getters['auth/isAuthenticated']);

        const logout = () => {
            store.dispatch('auth/logout');
        };

        return {
            logout, auth,
        }
    }
}
</script>
