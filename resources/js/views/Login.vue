<template>
  <h1>Login</h1>
    <form @submit.prevent="login">
        <input type="email" placeholder="Email" v-model="email">
        <input type="password" placeholder="Password" v-model="password">
        <button>Войти</button>
    </form>
</template>

<script>
import { ref } from 'vue';
import axios from "axios";
import { useRouter } from 'vue-router';

export default {
    name: "Login",
    setup() {
        const email = ref();
        const password = ref();

        const router = useRouter();

        const login = async () => {
            try {
                await axios.get('/sanctum/csrf-cookie');
                const data = await axios.post('/login', {
                    email: email.value,
                    password: password.value,
                });
                localStorage.setItem('x_xsrf_token', data.config.headers['X-XSRF-TOKEN']);
                router.push('/dash');
            } catch(e) {
                console.log(e.message);
            }
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
