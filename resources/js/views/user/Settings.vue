<template>
    <AppHeader>Настройки аккаунта</AppHeader>
    <main>
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-lg-4">
                    <div class="dashboard-item">
                        <AppLoader v-if="loading" />
                        <h3>Данные пользователя</h3>
                        <div class="user-account__data">
                            <p>Имя: <span class="b500">{{user.name}}</span></p>
                            <p>Фамилия: <span class="b500">{{user.surname}}</span></p>
                            <p>E-mail: <span class="b500">{{user.email}}</span></p>
                        </div>
                        <form>
                            <div class="form-control">
                                <label for="nickname">Никнейм в игре</label>
                                <Field name="nickname" v-slot="{ field, errors }">
                                    <input v-bind="field" type="text" :class="['form-input', {'invalid': !!errors.length} ]" placeholder="Никнейм в игре"  />
                                </Field>
                                <ErrorMessage class="alert" name="nickname" />
                            </div>
                            <div class="form-control">
                                <label for="university_id">Ваш университет</label>
                                <Field name="university_id" v-slot="{ field }">
                                    <v-select
                                        :options="universities"
                                        placeholder="Выберите университет"
                                        v-bind="field">
                                    </v-select>
                                    <ErrorMessage class="alert" name="university_id" />
                                </Field>
                            </div>
                            <button class="btn btn-default btn-full-width">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import {onMounted, ref} from 'vue';
import {useStore} from 'vuex';
import { useForm, Field, ErrorMessage } from 'vee-validate';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import AppLoader from "@/components/ui/AppLoader.vue";
import AppHeader from "@/components/ui/AppHeader.vue";

export default {
    name: "Settings",
    components: {
        AppHeader, AppLoader, vSelect,
        Field, ErrorMessage,
    },
    setup() {
        const store = useStore();
        const user = store.getters['auth/user'];

        const loading = ref(false);

        const nickname = ref(user.nickname);

        onMounted(async () => {
            loading.value = true;
            try {
                const response = await axios.get('/user-settings');

                const universitiesResponse = await axios.get('/universities');

            } catch (e) {
                console.log(e.message);
            }
            loading.value = false;
        });

        return {
            loading, user, nickname,
        };
    }
}
</script>

<style scoped>

</style>
