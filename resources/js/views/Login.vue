<template>
  <h1>Login</h1>
    <form @submit.prevent="login">
        <input type="email" placeholder="Email" v-model="email">
        <input type="password" placeholder="Password" v-model="password">
        <button>Войти</button>
    </form>
</template>

<script>
import {ref} from 'vue';
import { useStore } from 'vuex';

export default {
    name: "Login",
    setup() {
        const email = ref();
        const password = ref();

        const store = useStore();

        const login = () => {
            store.dispatch('auth/login', {
                email: email.value,
                password: password.value,
            });
        };

        return {
            email, password,
            login,
        }
    }
}
</script>

<style scoped>

</style>
