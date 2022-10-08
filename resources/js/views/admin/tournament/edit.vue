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

    <br><br>
    <AppStageCreate />

    <br><br>
    <router-link v-for="stage in stages" :key="stage.id" :to="{name: 'stage.edit', params: {id:stage.id}}">
        <div class="stage-item">
            {{stage.title}} - {{stage.race_start}}
        </div>
    </router-link>

</template>

<script>
import {onMounted, ref} from 'vue';
import axios from "axios";
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';
import AppStageCreate from "./AppStageCreate.vue";

export default {
    name: "tournament.edit",
    components: {
        AppStageCreate
    },
    setup() {
        const route = useRoute();
        const store = useStore();

        const title = ref();
        const yacht = ref();
        const description = ref();
        const loading = ref(false);

        const stages = ref();

        const id = route.params.id;

        onMounted(async () => {
            try {
                const tournament = await axios.get(`/api/admin/tournament/${id}`);
                title.value = tournament.data.title;
                yacht.value = tournament.data.yacht;
                description.value = tournament.data.description;

                const stageData = await axios.get(`/api/admin/stage/${id}`);
                stages.value = stageData.data;

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
            description, loading, stages
        }
    }
}
</script>

<style scoped>

</style>
