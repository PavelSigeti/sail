<template>
  <div class="container">
      <div class="col-12">
          <h1>Создать страницу</h1>
      </div>
      <div class="col-12">
          <form @submit.prevent="submit">
            <div class="form-control">
                <label for="title">Заголовок</label>
                <input type="text" name="title" v-model="title" id="title">
            </div>
            <AppEditor />
            <button>Создать</button>
          </form>
      </div>
  </div>
</template>

<script>
import {ref} from 'vue';
import AppEditor from "@/components/admin/AppEditor.vue";

export default {
    name: "create",
    components: {
        AppEditor,
    },
    setup() {
        const title = ref();

        const submit = async () => {
            try {

                // await axios.post('/api/admin/store', {
                //     title: title.name,
                //     content:
                // });
            } catch (e) {

            }
        }

        return {
            submit, title,
        }
    }
}
</script>

<style scoped>

</style>
