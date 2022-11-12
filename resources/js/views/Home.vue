<template>
    <header>
        <div class="container">
            <div class="row aic">
                <div class="col-6">
                    <img src="@/static/logo.svg" alt="vrisc logo" class="logo">
                </div>
                <div class="col-6 jcfe">
                    <div class="login-btn btn btn-border" @click="login = true">Вход</div>
                    <div class="register-btn btn btn-default" @click="register = true">Регистрация</div>
                </div>
            </div>
        </div>
    </header>
    <AppLoginForm v-if="login" @close="login = false" @switchReg="changeModal"/>
    <keep-alive>
        <AppRegisterForm v-if="register" @close="register = false" @switchReg="changeModal" />
    </keep-alive>
</template>

<script>
import {ref} from 'vue';
import AppLoginForm from "../components/public/AppLoginForm.vue";
import AppRegisterForm from "../components/public/AppRegisterForm.vue";

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
        }
    }
}
</script>

<style scoped>

</style>
