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
            <label for="university_id">Университет</label>
            <select name="university_id" id="university_id">
                <option value="null" selected>Без университета</option>
                <option value="{{university.id}}" v-for="university in universities" :key="university.id">{{university.name}}</option>
            </select>
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
import {onMounted, ref} from 'vue';
import axios from "axios";
import {useStore} from 'vuex';

export default {
    name: "Register",
    setup() {
        const name = ref();
        const surname = ref();
        const nickname = ref();
        const email = ref();
        const university_id = ref();
        const password = ref();
        const password_confirmation = ref();

        const store = useStore();

        const universities = ref();

        const register = async () => {
            try {
                await axios.get('/sanctum/csrf-cookie');
                await axios.post('/register',{
                    name: name.value,
                    email: email.value,
                    surname: surname.value,
                    nickname: nickname.value,
                    password: password.value,
                    password_confirmation: password_confirmation.value,
                    university_id: +university_id.value,
                });
                store.dispatch('auth/login', {
                    email: email.value,
                    password: password.value,
                });
            } catch (e) {
                console.log(e.message);
            }
        };

        onMounted(async () => {
            try {
                const response = await axios.get('/api/universities');
                universities.value = response.data;
            } catch (e) {
                console.log(e.message);
            }
        });

        return {
            name, email, password, password_confirmation,
            register, university_id, universities,
            surname, nickname,
        };
    }

}
</script>

<style scoped>

</style>
