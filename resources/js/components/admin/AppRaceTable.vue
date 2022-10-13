<template>
    <div class="race-table">
        <h2>Гонка</h2>
        <button @click="addRace">Добавить гонку</button>
        <div class="race-table__header">
            <div class="race-table__row">
                <div class="race-table__item race-table__name">Яхтсмен</div>
                <div class="race-table__item race-table__result" v-for="i in raceAmount" :key="i">#{{i}}</div>
                <div class="race-table__item race-table__total">Итог</div>
            </div>
        </div>
        <div class="race-table__body">
            <div class="race-table__column">
                <div class="race-table__item race-table__name" v-for="user in usersData" :key="user.user_id">
                    {{user.name}}
                </div>
            </div>
            <div class="race-table__column" v-for="(race) in raceData" :key="race.race_id">
                <AppRaceColumn :raceId="race.race_id" @update="getTotal"/>
                <div class="race-table__item race-table__result">
                    <button @click="remove(race.race_id)">Удалить</button>
                </div>
            </div>
            <div class="race-table__column">
                <div class="race-table__item race-table__total" v-for="(total, key) in totalData" :key="key">
                    {{total}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {ref, onMounted, computed} from "vue";
import AppRaceColumn from "@/components/admin/AppRaceColumn.vue";
import axios from "axios";

export default {
    name: "AppRaceTable",
    props: ['stageId', 'status', 'groupId'],
    components: {
        AppRaceColumn,
    },
    setup(props) {
        const raceData = ref({});
        const usersData = ref({});
        const lastRaceId = ref();
        const totalData = ref();

        const raceAmount = computed( () => Object.keys(raceData.value).length ?? 0);

        const getTotal = async () => {
            try {
                const total = await axios.get(`/api/admin/stage/${props.stageId}/${props.groupId}/${props.status}/total`);
                totalData.value = total.data;
            } catch (e) {
                console.log(e.message);
            }
        };

        onMounted(async () => {
            try {
                const races = await axios.get(
                    `/api/admin/stage/${props.stageId}/races/${props.status}/group/${props.groupId}`
                );
                raceData.value = races.data;

                lastRaceId.value = raceData.value[0].race_id;
                const users = await axios.get(`/api/admin/race/${lastRaceId.value}/users`);
                usersData.value = users.data;

                await getTotal();
            } catch (e) {
                console.log(e.message);
            }

        });

        const addRace = async () => {
            try {
                const response = await axios.post('/api/admin/race/create', {
                    stage_id: props.stageId,
                    group_id: props.groupId,
                    status: props.status,
                    lastRaceId: lastRaceId.value,
                });
                const race = response.data;
                raceData.value.push({
                    race_id: race.id,
                    group_id: race.group_id,
                    status: race.status,
                });
                console.log(raceData.value);
            } catch (e) {
                console.log(e.message);
            }
        };

        const remove = async (id) => {
            try {
                await axios.post(`/api/admin/race/${id}/remove`);
                raceData.value.splice(raceData.value.findIndex(item => item.race_id === id), 1);
            } catch (e) {
                console.log(e.message);
            }
        };

        return {
            raceData, raceAmount, usersData,
            addRace, remove, totalData,
            getTotal,
        }
    }
}
</script>

<style scoped>

</style>
