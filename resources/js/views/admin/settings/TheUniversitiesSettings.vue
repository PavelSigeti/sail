<template>
    <form @submit.prevent="submit">
        <div class="form-control">
            <label for="name">Название университета</label>
            <input type="text" id="name" v-model="name">
        </div>
        <button>Создать</button>
    </form>

    <div class="universities-container" v-if="universities && universities.length > 0">
        <h3>Список университетов</h3>
        <div class="item-block" v-for="(item, idx) in universities" :key="item.id">
            <div class="item-block__content">
                {{item.name}} - {{item.users_count}} чел.
            </div>
            <div class="item-block__btn item-block__cancel-btn">
                <span @click="removeUniversity(item.id, idx)">Удалить</span>
            </div>
        </div>
    </div>
</template>

<script>
import {useStore} from "vuex";
import {onMounted, ref} from "vue";
import axios from 'axios';

export default {
    name: "TheUniversitiesSettings",

    setup() {
        const store = useStore();
        const name = ref();
        const universities = ref();

        const removeUniversity = async (id, idx) => {
            try {
                await axios.delete(`/api/admin/universities/${id}/delete`);
                universities.value.splice(idx, 1);
            } catch (e) {
                console.log(e.message);
                store.dispatch('notification/displayMessage', {
                    value: 'Ошибка при удалении университета!',
                    type: 'error',
                });
            }
        }

        const submit = async () => {
            try {
                const response = await axios.post('/api/admin/universities/store', {
                    name: name.value
                });
                const data = response.data;
                data.users_count = 0;
                universities.value.push(data);
            } catch (e) {
                console.log(e.message);
                store.dispatch('notification/displayMessage', {
                    value: 'Ошибка при добавлении университета!',
                    type: 'error',
                });
            }
        };

        onMounted(async () => {
            try {
                const response = await axios.get('/api/admin/universities');
                universities.value = response.data;
            } catch (e) {
                console.log(e.message);
            }
        });

        return {
            universities, submit, name,
            removeUniversity,
        };
    }
}
</script>

<style scoped>

</style>
