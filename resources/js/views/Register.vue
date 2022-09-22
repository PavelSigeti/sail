<template>
    <h1>Register</h1>
    <form @submit.prevent="register">
        <input type="name" placeholder="Name" v-model="name">
        <input type="email" placeholder="Email" v-model="email">
        <input type="password" placeholder="Password" v-model="password">
        <input type="password" placeholder="Password again" v-model="password_confirmation">
        <button>Зарегистрироваться</button>
    </form>
</template>

<script>
import { ref } from 'vue';
import axios from "axios";
import {useRouter} from "vue-router";

export default {
    name: "Register",
    setup() {
        const name = ref();
        const email = ref();
        const password = ref();
        const password_confirmation = ref();

        const router = useRouter();

        const register = async () => {
            try {
                await axios.get('/sanctum/csrf-cookie');
                const data = await axios.post('/register',{
                    name: name.value,
                    email: email.value,
                    password: password.value,
                    password_confirmation: password_confirmation.value,
                });
                localStorage.setItem('x_xsrf_token', data.config.headers['X-XSRF-TOKEN']);
                router.push('/dash');
            } catch (e) {
                console.log(e.message);
            }
        };

        return {
            name, email, password, password_confirmation,
            register,
        };
    }

}
</script>

<style scoped>

</style>
