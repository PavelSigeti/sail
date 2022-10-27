<template>
    <div class="content-block" v-if="team">
        <div class="info-container">
            <div class="info-container__key">Название:</div>
            <div class="info-container__value">{{team.name}}</div>
        </div>
    </div>
    <form v-else @submit.prevent="submit" class="form-control">
        <div class="form-control">
            <label for="name"></label>
            <input id="name" type="text" v-model="name" placeholder="Название команды">
        </div>
        <button>Создать команду</button>
    </form>

    <AppUserSearchForm v-if="owner && teamInvites && teamInvites.length < 3 - teammates.length" :team_id="team.id" @invite="addInvite" />

    <div class="team-invites" v-if="teamInvites">
        <h3>Отправленные приглашения</h3>
        <div
            class="user-item"
            v-for="(invite, idx) in teamInvites"
            :key="invite.id"
        >
            <div class="user-item__content">
                <div class="user-item__nickname">
                    {{invite.nickname}}
                    <span class="user-item__id">#{{invite.user_id}}</span>
                </div>
                <div class="user-item__name">
                    {{invite.surname}} {{invite.name}}
                </div>
            </div>
            <div class="user-item__btn user-item__cancel-btn" @click="cancelInvite(invite.id, idx)">
                <span>отменить</span>
            </div>
        </div>
    </div>

    <div class="team-invites" v-if="invites && invites.length > 0">
        <h3>Приглашения в команду</h3>
        <div
            class="user-item"
            v-for="(invite, idx) in invites"
            :key="invite.id"
        >
            <div class="user-item__content">
                <div class="user-item__team">
                    Команда: <span>{{invite.name}}</span>
                </div>
            </div>
            <div class="user-item__btn user-item__accept-btn" @click="acceptInvite(invite.id)">
                <span>принять</span>
            </div>
            <div class="user-item__btn user-item__cancel-btn" @click="rejectInvite(invite.id, idx)">
                <span>откзаться</span>
            </div>
        </div>
    </div>

</template>

<script>
import {onMounted, ref} from "vue";
import axios from "axios";
import AppUserSearchForm from "./AppUserSearchForm.vue";
import {useStore} from "vuex";

export default {
    name: "TheTeamCreateForm",
    components: {
        AppUserSearchForm,
    },
    setup() {
        const store = useStore();

        const name = ref();

        const team = ref();
        const invites = ref();
        const owner = ref(false);
        const teammates = ref([]);
        const teamInvites = ref();

        const getData = async () => {
            try {
                const response = await axios.get('/api/team/edit');
                team.value = response.data.team;
                invites.value = response.data.invites;
                owner.value = response.data.owner;
                teammates.value = response.data.teammates;
                teamInvites.value = response.data.teamInvites;
            } catch (e) {
                console.log(e.message);
            }
        };

        onMounted(async() => {
            await getData();
            console.log(invites.value);
        });

        const submit = async () => {
            try {
                await axios.post('/api/team/store', {
                    name: name.value,
                });
                await getData();
            } catch (e) {
                console.log(e.message);
            }
        };

        const cancelInvite = async (id, idx) => {
            try {
                await axios.delete(`/api/team-invite/${id}/delete`);
                teamInvites.value.splice(idx, 1);
                store.dispatch('notification/displayMessage', {
                    value: 'Приглашение отменено',
                    type: 'primary',
                });
            } catch (e) {
                console.log(e.message);
                store.dispatch('notification/displayMessage', {
                    value: e.message,
                    type: 'error',
                });
            }
        };

        const addInvite = (payload) => {
            teamInvites.value.push(payload);
            console.log(teamInvites.value);
        };

        const rejectInvite = async (id, idx) => {
            try {
                await axios.delete(`/api/team-invite/${id}/delete`);
                invites.value.splice(idx, 1);
                store.dispatch('notification/displayMessage', {
                    value: 'Приглашение отклонено',
                    type: 'primary',
                });
            } catch (e) {
                console.log(e.message);
                store.dispatch('notification/displayMessage', {
                    value: 'Ошибка при отклонении приглашения',
                    type: 'error',
                });
            }
        };
        const acceptInvite = async (id) => {
            try {
                await axios.post(`/api/team-invite/${id}/accept`);
                invites.value = [];
                store.dispatch('notification/displayMessage', {
                    value: 'Вы вступили в команду',
                    type: 'primary',
                });
                await getData();
            } catch (e) {
                console.log(e.message);
                store.dispatch('notification/displayMessage', {
                    value: 'Ошибка при вступлении в команду',
                    type: 'error',
                });
            }
        };

        return {
            name, team, submit,
            owner, addInvite, teamInvites,
            cancelInvite, teammates, invites,
            rejectInvite, acceptInvite,
        }
    }
}
</script>

<style scoped>

</style>
