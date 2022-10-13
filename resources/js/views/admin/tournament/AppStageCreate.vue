<template>
    <form>
        <div class="form-control">
            <label for="register_start">Начало регистрации</label>
            <input type="datetime-local" id="register_start" v-model="register_start">
        </div>
        <div class="form-control">
            <label for="register_end">Конец регистрации</label>
            <input type="datetime-local" id="register_end" v-model="register_end">
        </div>
        <div class="form-control">
            <label for="race_start">Начало гонок</label>
            <input type="datetime-local" id="race_start" v-model="race_start">
        </div>
        <div class="form-control">
            <label for="title">Название</label>
            <input type="text" id="title" v-model="title">
        </div>
        <div class="form-control">
            <label for="title">Краткое описание</label>
            <textarea id="excerpt" v-model="excerpt"></textarea>
        </div>
        <div class="form-control">
            <label for="title">Описание</label>
            <textarea id="description" v-model="description"></textarea>
        </div>

        <button @click.prevent="submit">Создать</button>
    </form>
</template>

<script>
import {ref} from 'vue';
import axios from "axios";
import {useRoute} from 'vue-router';
import {useStore} from 'vuex';

export default {
    name: "AppStageCreate",
    emits: ['create'],
    setup(_, {emit}) {
        const route = useRoute();
        const store = useStore();

        const id = route.params.id;

        const register_start = ref('');
        const register_end = ref('');
        const race_start = ref('');
        const title = ref('');
        const excerpt = ref('');
        const description = ref('');

        const submit = async () => {
            try {
                const response = await axios.post('/api/admin/stage/store', {
                    tournament_id: id,
                    register_start: register_start.value,
                    register_end: register_end.value,
                    race_start: race_start.value,
                    title: title.value,
                    excerpt: excerpt.value,
                    description: description.value,
                });
                emit('create', response.data);
                store.dispatch('notification/displayMessage', {
                    value: 'Этап успешно создана',
                    type: 'primary',
                });
            } catch (e) {
                store.dispatch('notification/displayMessage', {
                    value: 'Ошибка при создании этапа',
                    type: 'error',
                });
            }
        };

        return {
            register_start, register_end, race_start,
            title, excerpt, description,
            submit,
        }
    }
}
</script>

<style scoped>

</style>
