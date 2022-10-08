<template>
    <form @submit.prevent="submit">
        <div class="form-control">
            <label for="title">Название серии</label>
            <input type="text" id="title" v-model="title">
        </div>
        <div class="form-control">
            <label for="yacht">Тип лодки</label>
            <input type="text" id="yacht" v-model="yacht">
        </div>
        <div class="form-control">
            <label for="description">Описание</label>
            <textarea id="description" cols="30" rows="10" v-model="description"></textarea>
        </div>
        <button :disabled="loading">Создать</button>
    </form>

    <h2>Список серий</h2>
    <div class="block-container">
        <router-link v-for="tournament in tournaments" :key="tournament.id" :to="{name: 'tournament.edit', params: {id: tournament.id}}">
            <div class="tournament-item">
                {{tournament.title}} - {{tournament.yacht}}
            </div>
        </router-link>
    </div>
</template>

<script>
import {onMounted, ref} from 'vue';
import axios from "axios";
import { useStore } from 'vuex';

export default {
    name: "tournament.index",
    setup() {
        const title = ref('');
        const yacht = ref('');
        const description = ref('');

        const tournaments = ref();

        const store = useStore();

        const loading = ref(false);

        onMounted( async() => {
            try {
                const data = await axios.get('/api/admin/tournament');
                tournaments.value = data.data;
            } catch (e) {
                console.log(e.message);
            }
        });

        const submit = async () => {
            loading.value = true;
            try {
                const data = await axios.post('/api/admin/tournament/store', {
                    title: title.value,
                    yacht: yacht.value,
                    description: description.value,
                });
                store.dispatch('notification/displayMessage', {
                    value: 'Серия успешно создана',
                    type: 'primary',
                });
                const id = data.data.id;
                tournaments.value.unshift({
                    id,
                    title: title.value,
                    yacht: yacht.value,
                });
                title.value = '';
                yacht.value = '';
                description.value = '';
            } catch (e) {
                store.dispatch('notification/displayMessage', {
                    value: 'Ошибка создания серии',
                    type: 'error',
                });
            }
            loading.value = false;
        };

        return {
            submit, title, yacht,
            description, loading, tournaments,
        }
    }
}
</script>

<style scoped>

</style>
