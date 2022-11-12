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
                <AppEditor v-model:modelValue="text" id="content" />
            </div>
            <button @click.prevent="submit">Создать</button>
          </form>
      </div>
  </div>
</template>

<script>
import {ref} from 'vue';
import AppEditor from "@/components/admin/AppEditor.vue";
import {useStore} from "vuex";
import {useRouter} from "vue-router";

export default {
    name: "page.create",
    components: {
        AppEditor,
    },
    setup() {
        const store = useStore();
        const router = useRouter();

        const title = ref();
        const slug = ref();
        const text = ref('');

        const submit = async () => {
            try {
                const response = await axios.post('/api/admin/page/store', {
                    title: title.value,
                    slug: slug.value,
                    text: text.value,
                });
                router.push(`/admin/page/${response.data}`);
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
