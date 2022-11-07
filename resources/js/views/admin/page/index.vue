<template>
    <div class="container">
        <div class="col-12">
            <h2>Pages</h2>
        </div>
        <div class="col-12">
            <router-link :to="{name: 'admin.pages.create'}">Добавить страницу</router-link>
        </div>
        <div class="col-12">
            <div class="page-link" v-for="item in pages" :key="item.id">
                {{item.name}}
            </div>
        </div>
    </div>
</template>

<script>
import {onMounted, ref} from "vue";
import axios from "axios";

export default {
    name: "index",

    setup() {

        const pages = ref();

        onMounted(async ()=>{
            const response = await axios.get('/api/admin/pages');
            pages.value = response.data;
        });

        return {
            pages,
        }
    },
}
</script>

<style scoped>

</style>
