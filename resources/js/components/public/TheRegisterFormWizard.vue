<template>
    <form @submit="submit" class="home-form" autocomplete="off">
        <div class="reg-step" v-if="step === 0" @keyup.enter="submit">
            <div class="form-control">
                <Field name="email" v-slot="{ field, errors }">
                    <input
                        v-bind="field"
                        type="email"
                        :class="['form-input', {'invalid': !!errors.length} ]"
                        placeholder="E-mail"
                    />
                </Field>
                <ErrorMessage class="alert" name="email" />
            </div>
            <div class="form-control">
                <Field name="password" v-slot="{ field, errors }">
                    <input
                        v-bind="field"
                        type="password"
                        :class="['form-input', {'invalid': !!errors.length} ]"
                        placeholder="Пароль"
                    />
                </Field>
                <ErrorMessage class="alert" name="password" />
            </div>
            <div class="form-control">
                <Field name="password_confirmation" v-slot="{ field, errors }">
                    <input
                        v-bind="field"
                        type="password"
                        :class="['form-input', {'invalid': !!errors.length} ]"
                        placeholder="Пароль еще раз"
                    />
                </Field>
                <ErrorMessage class="alert" name="password_confirmation" />
            </div>
            <div class="form-info mb15">Отправляя форму, вы соглашаетесь на обработку &nbsp; <span class="underline link" @click="">персональных данных</span></div>
            <div class="btn btn-default btn-home" @click="submit">Продолжить (1 из 2)</div>
            <div class="form-info jcc">Есть аккаунта?&nbsp;<span class="underline link" @click="$emit('switchReg')">Войти</span></div>
        </div>
        <div class="reg-step" v-if="step===1">
            <div class="form-control">
                <Field name="surname" v-slot="{ field, errors }">
                    <input v-bind="field" type="text" :class="['form-input', {'invalid': !!errors.length} ]" placeholder="Фамилия"  />
                </Field>
                <ErrorMessage class="alert" name="surname" />
            </div>
            <div class="form-control">
                <Field name="name" v-slot="{ field, errors }">
                    <input v-bind="field" type="text" :class="['form-input', {'invalid': !!errors.length} ]" placeholder="Имя"  />
                </Field>
                <ErrorMessage class="alert" name="name" />
            </div>
            <div class="form-control">
                <Field name="nickname" v-slot="{ field, errors }">
                    <input v-bind="field" type="text" :class="['form-input', {'invalid': !!errors.length} ]" placeholder="Никнейм в игре"  />
                </Field>
                <ErrorMessage class="alert" name="nickname" />
            </div>
            <div class="form-control">
                <Field name="university_id" v-slot="{ field }">
                    <v-select
                        :options="universities"
                        placeholder="Выберите университет"
                        v-bind="field">
                    </v-select>
                    <ErrorMessage class="alert" name="university_id" />
                </Field>
            </div>
            <div class="form-info mb15">Если вашего университета нет, то пропусте это поле</div>
            <div class="form-info mb15">Отправляя форму, вы соглашаетесь на обработку &nbsp; <span class="underline link" @click="">персональных данных</span></div>
            <button class="btn btn-default btn-home">Зарегистрироваться</button>
            <div class="form-info jcc"><span class="underline link" @click="step=0">Вернуться назада (2 из 2)</span></div>
        </div>
    </form>
</template>

<script>
import { useForm, Field, ErrorMessage } from 'vee-validate';
import { ref, computed, onMounted } from 'vue';
import useUniversities from "../../composables/universities.js";
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
export default {
    name: "TheRegisterFormWizard",
    props: [
        'validationSchema',
    ],
    emits: [
      'submitForm', 'switchReg',
    ],
    components: {
        vSelect, Field, ErrorMessage,
    },
    setup(props, {emit}) {
        const step = ref(0);
        const {universities, getUniversities} = useUniversities();

        onMounted(async ()=>{
            getUniversities();
        });
        const currentSchema = computed(() => {
            return props.validationSchema[step.value];
        });

        const { values, handleSubmit } = useForm({
            validationSchema: currentSchema,
            keepValuesOnUnmount: true,
        });

        const submit = handleSubmit((values) => {
            if(step.value === 0) {
                step.value++;

                return;
            }

            emit('submitForm', values);
        });

        return {
            universities, submit, step,
        }
    }
}
</script>

<style scoped>

</style>
