<template>
    <table v-if="users" class="result-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Яхтсмен</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(user, i) in users" :key="i">
                <td>{{i+1}}</td>
                <td>{{user.name}}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "AppUsersTables",
    props: {
        users: {
            type: Array,
            default: null,
        }
    }
}
</script>

<style scoped>

</style>
