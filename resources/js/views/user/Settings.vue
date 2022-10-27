<template>
    <h2>Настройки</h2>

    <h3>Команда</h3>
    <TheTeamSettings />
</template>

<script>
import {onMounted, ref} from 'vue';
import axios from "axios";
import TheTeamSettings from "@/components/user/TheTeamSettings.vue";

export default {
    name: "Settings",
    components: {
        TheTeamSettings,
    },
    setup() {



        return {
        };
    }
}
</script>

<style scoped>

</style>
