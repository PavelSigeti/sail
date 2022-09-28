<template>
    <h1>Just edit tournament</h1>

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
        <button :disabled="loading">Редактировать</button>
    </form>
</template>

<script>
import {onMounted, ref} from 'vue';
import axios from "axios";
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';

export default {
    name: "tournament.edit",
    setup() {
        const route = useRoute();
        const store = useStore();

        const title = ref();
        const yacht = ref();
        const description = ref();
        const loading = ref(false);

        const id = route.params.id;

        onMounted(async () => {
            try {
                const data = await axios.get(`/api/admin/tournament/${id}`);
                title.value = data.data.title;
                yacht.value = data.data.yacht;
                description.value = data.data.description;
            } catch (e) {
                console.log(e.message);
            }
        });

        const submit = async () => {
            loading.value = true;
            try {
                const data = await axios.patch(`/api/admin/tournament/${id}/update`, {
                    title: title.value,
                    yacht: yacht.value,
                    description: description.value,
                });
                store.dispatch('notification/displayMessage', {
                    value: 'Серия успешно обнавлена',
                    type: 'primary',
                });
                console.log(data);
            } catch (e) {
                console.log(e.message);
                store.dispatch('notification/displayMessage', {
                    value: 'Ошибка при обновлении серии',
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
