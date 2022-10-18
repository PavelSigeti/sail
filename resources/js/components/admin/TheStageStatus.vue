<template>
    <button @click="startStage" v-if="status === 'active'">Начать этап</button>
    <button @click="finishGroupStage" v-if="status === 'group'">Завершить групповой этап</button>
</template>

<script>
import { ref } from 'vue';
import axios from "axios";

export default {
    name: "TheStageStatus",
    emits: ['update'],
    props: ['status', 'id'],
    setup(props, { emit }) {
        const status = ref(props.status);
        const id = props.id;

        const startStage = async () => {
            try {
                const response = await axios.post(`/api/admin/stage/${id}/start`);
                status.value = response.data.status;
                emit('update', status.value);
            } catch (e) {
                console.log(e.message);
            }
        };

        const finishGroupStage = async () => {
            try {
                const response = await axios.post(`/api/admin/stage/${id}/finish-group`);
                status.value = response.data.status;
                emit('update', status.value);
            } catch (e) {
                console.log(e.message);
            }
        };

        const finishFleetStage = async () => {
            try {
                const response = await axios.post(`/api/admin/stage/${id}/finish-fleet`);
            } catch (e) {

            }
        };

        return {
            status, startStage, finishGroupStage,
            id
        }
    }
}
</script>

<style scoped>

</style>
