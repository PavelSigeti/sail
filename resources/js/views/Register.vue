<template>
    <h1>Register</h1>
    <form @submit.prevent="register">
        <div class="form-control">
            <label for="name">Имя</label>
            <input type="text" id="name" placeholder="Имя" v-model="name">
        </div>
        <div class="form-control">
            <label for="name">Фамилия</label>
            <input type="text" id="surname" placeholder="Фамилия" v-model="surname">
        </div>
        <div class="form-control">
            <label for="name">Никнейм в игре</label>
            <input type="text" id="nickname" placeholder="Никнейм в игре" v-model="nickname">
        </div>
        <div class="form-control">
            <label for="email">E-mail</label>
            <input type="email" id="email" placeholder="E-mail" v-model="email">
        </div>
        <div class="form-control">
            <label for="password">Пароль</label>
            <input type="password" id="password" placeholder="Password" v-model="password">
        </div>
        <div class="form-control">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input type="password" id="password_confirmation" placeholder="Password" v-model="password_confirmation">
        </div>
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
                router.push({name: 'Dashboard',});
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
