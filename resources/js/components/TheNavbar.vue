<template>
    <ul>
        <li><router-link to="/">Home</router-link></li>
        <li><router-link to="/login">Login</router-link></li>
        <li><router-link to="/dashboard">Dashboard</router-link></li>
        <li v-if="!auth"><router-link to="/registration">Registration</router-link></li>
        <li v-if="auth"><a @click.prevent="logout" href="#">Logout</a></li>
    </ul>
</template>

<script>
import { useStore } from 'vuex';
import {computed} from "vue";

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
