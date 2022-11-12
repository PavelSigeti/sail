<template>
    <header>
        <div class="container">
            <div class="row aic">
                <div class="col-6">
                    <img src="@/static/logo.svg" alt="vrisc logo" class="logo">
                </div>
                <div class="col-6 jcfe">
                    <div class="login-btn btn btn-border" @click="login = true; bodyOverflow(true)">Вход</div>
                    <div class="register-btn btn btn-default" @click="register = true; bodyOverflow(true)">Регистрация</div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <AppLoginForm v-if="login" @close="login = false; bodyOverflow(false)" @switchReg="changeModal"/>
        <keep-alive>
            <AppRegisterForm v-if="register" @close="register = false; bodyOverflow(false)" @switchReg="changeModal" />
        </keep-alive>
    </main>
</template>

<script>
import {ref} from 'vue';
import AppLoginForm from "../components/public/AppLoginForm.vue";
import AppRegisterForm from "../components/public/AppRegisterForm.vue";
import bodyOverflow from "../utils/bodyOverflow.js";

export default {
    name: "Home",
    components: {
        AppLoginForm, AppRegisterForm,
    },
    setup() {
        const login = ref(false);
        const register = ref(false);

        const changeModal = () => {
            login.value = !login.value;
            register.value = !register.value;
        };

        return {
            login, register, changeModal,
            bodyOverflow,
        }
    }
}
</script>

<style scoped>

</style>
