<template>
  <h1>Login</h1>
    <Form @submit.prevent="login" :validation-schema="schema">
        <Field type="email" placeholder="Email" name="email" />
        <ErrorMessage name="email" />
        <Field type="password" placeholder="Password" name="password" />
        <ErrorMessage name="password" />
        <button>Войти</button>
    </Form>
</template>

<script>
import {ref} from 'vue';
import { useStore } from 'vuex';
import * as yup from "yup";
import { Form, Field, ErrorMessage } from 'vee-validate';

export default {
    name: "Login",
    components: {
      Form, Field, ErrorMessage,
    },
    setup() {
        const email = ref();
        const password = ref();

        const store = useStore();

        const login = (values) => {
            console.log(values);
            // store.dispatch('auth/login', {
            //     email: email.value,
            //     password: password.value,
            // });
        };

        const schema = yup.object({
            email: yup.string().required().email(),
            password: yup.string().required().min(8),
        });

        return {
            email, password,
            login, schema,
        }
    }
}
</script>

<style scoped>

</style>
