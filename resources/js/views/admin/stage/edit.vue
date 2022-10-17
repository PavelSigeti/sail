<template>
    <h1>Stage edit {{$route.params.id}}</h1>

    <form @submit.prevent="submit">
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
            <label for="title">Название Этапа</label>
            <input type="text" id="title" v-model="title">
        </div>
        <div class="form-control">
            <label for="race_amount_drop">Кол-во выбрасов (до 18 челов)</label>
            <input type="text" id="race_amount_drop" v-model="race_amount_drop">
        </div>
        <div class="form-control">
            <label for="race_amount_drop">Кол-во выбрасов в группах (от 19 челов)</label>
            <input type="text" id="race_amount_group_drop" v-model="race_amount_group_drop">
        </div>
        <div class="form-control">
            <label for="race_amount_drop">Кол-во выбрасов во флотах (от 19 челов)</label>
            <input type="text" id="race_amount_fleet_drop" v-model="race_amount_fleet_drop">
        </div>
        <div class="form-control">
            <label for="title">Краткое описание</label>
            <textarea id="excerpt" v-model="excerpt"></textarea>
        </div>
        <div class="form-control">
            <label for="title">Описание</label>
            <textarea id="description" v-model="description"></textarea>
        </div>

        <button>Редактировать</button>
    </form>

    <AppUsersTables v-if="status === 'active' && users" :users="users"></AppUsersTables>

    <div class="stage-table" v-else v-for="(groups, raceStatus, idx) in statusGroup" :key="idx">
        <AppRaceTable v-for="groupId in groups"
                      :stageId="id"
                      :groupId="groupId"
                      :status="raceStatus"
                      :key="groupId"
                      ref="child"
        ></AppRaceTable>
    </div>

    <TheStageStatus v-if="status" :status="status" :id="id" @update="statusGroupFetch"/>

</template>

<script>
import {onMounted, ref} from 'vue';
import axios from "axios";
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';
import AppUsersTables from "@/components/ui/AppUsersTables.vue";
import AppRaceTable from "@/components/admin/AppRaceTable.vue";
import TheStageStatus from "@/components/admin/TheStageStatus.vue";

export default {
    name: "stage.edit",
    components: {
        AppUsersTables, AppRaceTable, TheStageStatus
    },
    setup() {
        const loading = ref(false);
        const route = useRoute();
        const store = useStore();

        const id = route.params.id;

        const register_start = ref('');
        const register_end = ref('');
        const race_start = ref('');
        const title = ref('');
        const excerpt = ref('');
        const description = ref('');
        const users = ref();
        const status = ref();
        const race_amount_drop = ref();
        const race_amount_group_drop = ref();
        const race_amount_fleet_drop = ref();

        const child = ref(null);

        const statusGroup = ref();

        const statusGroupFetch = async (payload) => {
            try {
                const statusGroupData = await axios.get(`/api/admin/stage/${id}/meta`);
                statusGroup.value = statusGroupData.data;
                status.value = payload;
            } catch (e) {
                console.log(e.message);
            }
        }

        onMounted( async() => {
            try {
                const data = await axios.get(`/api/admin/stage/${id}/edit`);
                title.value = data.data.title;
                register_start.value = data.data.register_start;
                register_end.value = data.data.register_end;
                race_start.value = data.data.race_start;
                excerpt.value = data.data.excerpt;
                description.value = data.data.description;
                users.value = data.data.users;
                race_amount_drop.value = data.data.race_amount_drop;
                race_amount_group_drop.value = data.data.race_amount_group_drop;
                race_amount_fleet_drop.value = data.data.race_amount_fleet_drop;
                await statusGroupFetch(data.data.status);
            } catch (e) {
                console.log(e.message);
            }
        });

        const submit = async () => {
            loading.value = true;
            try {
                await axios.patch(`/api/admin/stage/${id}/update`, {
                    title: title.value,
                    description: description.value,
                    register_start: register_start.value,
                    register_end: register_end.value,
                    race_start: race_start.value,
                    race_amount_drop: race_amount_drop.value,
                    race_amount_group_drop: race_amount_group_drop.value,
                    race_amount_fleet_drop: race_amount_fleet_drop.value,
                });
                for (let comp of child.value) {
                    comp.getTotal();
                }
                store.dispatch('notification/displayMessage', {
                    value: 'Этап успешно обнавлен',
                    type: 'primary',
                });
            } catch (e) {
                console.log(e.message);
                store.dispatch('notification/displayMessage', {
                    value: 'Ошибка при обновлении этапа',
                    type: 'error',
                });
            }
            loading.value = false;
        };


        return {
            register_start, register_end, race_start,
            title, excerpt, description,
            submit, users, status,
            id, statusGroup, child,
            race_amount_drop, race_amount_group_drop, race_amount_fleet_drop,
            statusGroupFetch
        }
    }
}
</script>

<style scoped>

</style>
