<template>
    <form class="invite-form" @submit.prevent="invite" >
        <div class="form-info">Вы можете приглосить пользователей, которые не состоят в команде</div>
        <div class="form-control" v-if="!selected">
            <label for="user"></label>
            <input type="text" id="user" v-model="user" @input="search">
        </div>
        <div class="user-item" v-else>
            <div class="user-item__content">
                <div class="user-item__nickname">
                    {{selected.nickname}}
                    <span class="user-item__id">#{{selected.id}}</span>
                </div>
                <div class="user-item__name">
                    {{selected.surname}} {{selected.name}}
                </div>
            </div>
            <div class="user-item__remove" @click="selected = null">
                <img src="@/static/trash.svg" alt="trash">
            </div>
        </div>
        <button>Пригласить пользователя</button>
        <div class="search-container" v-if="searchCandidates">
            <div class="search-candidate"
                 v-for="user in searchCandidates"
                 :key="user.id"
                 @click="selectUser(user)"
            >
                <div class="search-candidate__nickname">
                    {{user.nickname}}
                    <span class="search-candidate__id">#{{user.id}}</span>
                </div>
                <div class="search-candidate__name">
                    {{user.surname}} {{user.name}}
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import axios from "axios";
import {ref} from "vue";
import {useStore} from "vuex";


export default {
    name: "TheUserSearchForm",
    props: ['team_id',],
    emits: ['invite'],
    setup(props, {emit}) {
        const store = useStore();

        const user = ref();
        const searchCandidates = ref(null);
        const selected = ref(null);

        const search = async () => {
            if(user.value.length > 0) {
                const response = await axios.post('/api/user/search', {
                    user: user.value
                });
                if(response.data.length > 0) {
                    searchCandidates.value = response.data;
                } else {
                    searchCandidates.value = null;
                }
            } else {
                searchCandidates.value = null;
            }
        };

        const selectUser = (payload) => {
            user.value = '';
            searchCandidates.value = null;
            selected.value = payload;
        };

        const invite = async () => {
            try {
                if(selected.value) {
                    const response = await axios.post('/api/team-invite', {
                        team_id: props.team_id,
                        user_id: selected.value.id,
                    });
                    selected.value = null;
                    store.dispatch('notification/displayMessage', {
                        value: 'Прглашение отправлено',
                        type: 'primary',
                    });
                    emit('invite', response.data);
                }
                else {
                    store.dispatch('notification/displayMessage', {
                        value: 'Выберите пользователя',
                        type: 'error',
                    });
                }
            } catch (e) {
                console.log(e.response);
                store.dispatch('notification/displayMessage', {
                    value: e.response.data.message,
                    type: 'error',
                });
            }
        };

        return {
            search, searchCandidates, user,
            invite, selected, selectUser,
        }
    }
}
</script>

<style scoped>

</style>
