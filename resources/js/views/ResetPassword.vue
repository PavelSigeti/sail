<template>
    <h1>Reset password</h1>
    <form @submit.prevent="resetPassword">
        <input type="email" placeholder="Email" v-model="email">
        <input type="password" placeholder="Password" v-model="password">
        <input type="password" placeholder="Password again" v-model="password_confirmation">
        <button>Отправить</button>
    </form>
</template>

<script>
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from "axios";

export default {
    name: "ResetPassword",
    setup() {
        const rote = useRoute();
        const router = useRouter();

        const email = ref();
        const password = ref();
        const password_confirmation = ref();
        const token = rote.params.token;

        email.value = rote.query.email;

        const resetPassword = async () => {
            try {
                await axios.get('/sanctum/csrf-cookie');
                const data = await axios.post('/reset-password', {
                    email: email.value,
                    token: token,
                    password: password.value,
                    password_confirmation: password_confirmation.value,
                });
                localStorage.setItem('x_xsrf_token', data.config.headers['X-XSRF-TOKEN']);
                router.push('/dash');
            } catch (e) {
                console.log(e.message);
            }
        }

        return {
            email, password, password_confirmation,
            resetPassword,
        }
    }
}
</script>

<style scoped>

</style>
