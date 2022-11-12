<template>
    <div class="modal">
        <div class="modal-background" @click="$emit('close');"></div>
        <div class="modal-container">
            <AppLoader v-if="loading" />
            <h2>Вход</h2>
            <Form @submit="login" class="home-form" :validation-schema="validationSchema">
                <div class="form-control">
                    <Field name="email" v-slot="{ field, errors }">
                        <input v-bind="field" type="email" :class="['form-input', {'invalid': !!errors.length} ]" placeholder="E-mail"  />
                    </Field>
                    <ErrorMessage class="alert" name="email" />
                </div>
                <div class="form-control">
                    <Field name="password" v-slot="{ field, errors }">
                        <input v-bind="field" type="password" :class="['form-input', {'invalid': !!errors.length} ]" placeholder="Пароль"  />
                    </Field>
                    <ErrorMessage class="alert" name="password" />
                </div>


                <button class="btn btn-default btn-home">Войти</button>
                <div class="form-info jcc">Нет аккаунта?&nbsp;<span class="underline link" @click="$emit('switchReg');">Зарегистрироваться</span></div>
            </Form>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import {useStore} from "vuex";
import * as yup from "yup";
import { Field, Form, ErrorMessage } from 'vee-validate';
import AppLoader from "../ui/AppLoader.vue";

export default {
    name: "AppLoginForm",
    components: {
        Field, Form, ErrorMessage,
        AppLoader,
    },
    emits: [
      'close', 'switchReg',
    ],
    setup() {
        const store = useStore();

        const loading = ref(false);

        const validationSchema = yup.object({
            email: yup.string().required('Введите E-mail').email('Не корректный E-mail'),
            password: yup.string().required('Введите пароль').min(3, 'Пароль от 3 символов'),
        });

        const login = (values) => {
            loading.value = true;
            store.dispatch('auth/login', values);
            loading.value = false;
        };

        return {
            login, validationSchema, loading,
        }
    }
}
</script>

<style scoped>

</style>
