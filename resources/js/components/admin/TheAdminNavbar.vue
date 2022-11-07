<template>
    <ul>
        <li><router-link to="/dashboard">Dashboard</router-link></li>
        <li><router-link to="/admin">Admin</router-link></li>
        <li><router-link :to="{name: 'tournament.index'}">Tournament</router-link></li>
        <li><router-link :to="{name: 'admin.pages'}">Pages</router-link></li>
        <li><router-link :to="{name: 'admin.settings'}">Site Settings</router-link></li>
        <li><a @click.prevent="logout" href="#">Logout</a></li>
    </ul>
</template>

<script>
import { useStore } from 'vuex';

export default {
    name: "TheAdminNavbar",
    setup() {
        const store = useStore();

        const logout = () => {
            store.dispatch('auth/logout');
        };

        return {
            logout
        }
    }
}
</script>
