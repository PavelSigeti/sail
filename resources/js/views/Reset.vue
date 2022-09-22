<template>
    <h1>Reset</h1>
    <p v-if="msg">{{msg}}</p>
    <form @submit.prevent="reset">
        <input type="email" placeholder="Email" v-model="email">
        <button>Отправить</button>
    </form>
</template>

<script>
import axios from "axios";
import { ref } from 'vue';

export default {
    name: "Reset",
    setup() {
        const email = ref();
        const msg = ref('');

        const reset = async () => {
            try {
                await axios.get('/sanctum/csrf-cookie');
                await axios.post('/forgot-password', {
                    email: email.value,
                });
                msg.value = 'Проверьте свою почту!';
            } catch (e) {
                console.log(e.message);
            }
        };

        return {
            email,
            reset,
            msg,
        };
    }
}
</script>

<style scoped>

</style>
