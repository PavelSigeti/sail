<template>
    <div class="result-tables">
        <div
            class="result-table__container"
            v-for="(status, key) in results" :key="key"
        >

            <div v-for="(group, _, idx)  in status" :key="_">
                <h3>{{statusTitle[key]}} #{{idx+1}}</h3>
                <table class="result-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Имя</th>
                            <th v-for="i in Object.keys(group[0]).length - 1">
                                #{{i}}
                            </th>
                            <th>Итог</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, idx) in group">
                            <td>{{idx+1}}</td>
                            <td>{{user[0].name}} {{user[0].surname}} {{user[0].nickname}}</td>
                            <td v-for="race in user">{{(race.drop) ?  (race.place === group.length + 1 )? `(dnf, ${race.place})` : `(${race.place})` : race.place ?? user.sum}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import {onMounted, ref} from 'vue';

export default {
    name: "AppResultTable",
    props: ['id'],
    setup(props,) {
        const results = ref();
        const statusTitle = {
            'default': 'Гонка',
            'group': 'Группа',
            'fleet': 'Флот',
        };

        onMounted(async () => {
            const response = await axios.get(`/api/stage/${props.id}`);
            results.value = response.data;
            console.log('results', results.value);
        });

        return {
            results, statusTitle,
        }
    }
}
</script>

<style scoped>

</style>
