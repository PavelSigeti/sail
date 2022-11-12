<template>
    <div class="container">
        <div class="col-12">
            <h1>Создать страницу</h1>
        </div>
        <div class="col-12">
            <form @submit.prevent>
                <div class="form-control">
                    <label for="title">Заголовок</label>
                    <input type="text" name="title" v-model="title" id="title">
                </div>
                <div class="form-control">
                    <label for="slug">URI (Slug)</label>
                    <input type="text" name="slug" v-model="slug" id="slug">
                </div>
                <div class="form-control">
                    <label for="content">Содержание</label>
                    <AppEditor v-if="text" v-model:modelValue="text" id="content" />
                </div>
                <button @click.prevent="submit">Обнавить</button>
            </form>
        </div>
    </div>
</template>

<script>
import {onMounted, ref} from 'vue';
import AppEditor from "@/components/admin/AppEditor.vue";
import {useStore} from "vuex";
import {useRoute} from "vue-router";

export default {
    name: "page.edit",
    components: {
        AppEditor,
    },
    setup() {
        const store = useStore();
        const route = useRoute();

        const title = ref();
        const slug = ref();
        const text = ref('');
        const id = route.params.id;

        onMounted(async() => {
            try {
                const response = await axios.get(`/api/admin/page/${id}`);
                const data = response.data;
                title.value = data.title;
                slug.value = data.slug;
                text.value = data.text;
                console.log('text', text.value);
            } catch (e) {
                store.dispatch('notification/displayMessage', {
                    value: 'Ошибка при загрузке страницы',
                    type: 'error',
                });
            }
        });

        const submit = async () => {
            try {
                await axios.patch(`/api/admin/page/${id}/update`, {
                    title: title.value,
                    slug: slug.value,
                    text: text.value,
                });
                store.dispatch('notification/displayMessage', {
                    value: 'Страница обнавлена',
                    type: 'primary',
                });
            } catch (e) {
                store.dispatch('notification/displayMessage', {
                    value: 'Ошибка при создании страницы',
                    type: 'error',
                });
            }
        }

        return {
            submit, title, text,
            slug,
        }
    }
}
</script>

<style scoped>

</style>
