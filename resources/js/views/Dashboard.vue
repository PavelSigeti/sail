<template>
    <h1>Dash</h1>
    <pre>{{users}}</pre>
</template>

<script>
import {ref, onMounted} from 'vue';
import axios from "axios";

export default {
    name: "Dashboard",
    setup() {
        const users = ref({});

        onMounted(async () => {
            const {data} = await axios.get('/api/users');
            users.value = data;
        });

        return {
            users,
        }
    }
}
</script>

