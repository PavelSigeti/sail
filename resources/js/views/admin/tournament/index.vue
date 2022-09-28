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
</template>

<script>
import {ref} from 'vue';
import axios from "axios";
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

export default {
    name: "tournament.index",
    setup() {
        const title = ref('');
        const yacht = ref('');
        const description = ref('');

        const store = useStore();
        const router = useRouter();

        const loading = ref(false);

        const submit = async () => {
            loading.value = true;
            try {
                const data = await axios.post('/api/admin/tournament/store', {
                    title: title.value,
                    yacht: yacht.value,
                    description: description.value,
                });
                title.value = '';
                yacht.value = '';
                description.value = '';
                store.dispatch('notification/displayMessage', {
                    value: 'Серия успешно создана',
                    type: 'primary',
                });
                const id = data.data.id;
                console.log(data);
                router.push({name: 'tournament.edit', params: {id}});
            } catch (e) {
                console.log(e.message);
                store.dispatch('notification/displayMessage', {
                    value: 'Ошибка создания серии',
                    type: 'error',
                });
            }
            loading.value = false;
        };

        return {
            submit, title, yacht,
            description, loading
        }
    }
}
</script>

<style scoped>

</style>
