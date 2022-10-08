<template>
    <table v-if="users">
        <thead>
            <tr>
                <td>#</td>
                <td>Яхтсмен</td>
                <td></td>
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
