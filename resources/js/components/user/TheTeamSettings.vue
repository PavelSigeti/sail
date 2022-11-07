<template>
    <div class="content-block" v-if="team">
        <div class="info-container">
            <div class="info-container__key">Название:</div>
            <div class="info-container__value">{{team.name}}</div>
        </div>
        <div class="info-container">
            <h3>Состав команды</h3>
            <div class="teammate-container">
                <div class="user-item" v-for="(user, idx) in teammates" :key="user.id">
                    <div class="user-item__content">
                        <div class="user-item__nickname">
                            {{user.nickname}}
                            <span class="user-item__id">#{{user.id}}</span>
                        </div>
                        <div class="user-item__name">
                            {{user.surname}} {{user.name}}
                        </div>
                    </div>
                    <div class="user-item__icon" v-if="team.owner_id === user.id">
                        <img src="@/static/crown.svg" alt="crown">
                    </div>
                    <div
                        class="user-item__btn user-item__cancel-btn"
                        v-if="owner && team.owner_id !== user.id"
                        @click="removeTeammate(user.id, idx)"
                    >
                        <span>исключить</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form v-else @submit.prevent="submit" class="form-control">
        <div class="form-control">
            <label for="name"></label>
            <input id="name" type="text" v-model="name" placeholder="Название команды">
        </div>
        <button>Создать команду</button>
    </form>

    <AppUserSearchForm v-if="owner && teamInvites && teammates && teamInvites.length < 3 - teammates.length" :team_id="team.id" @invite="addInvite" />

    <div class="team-invites" v-if="teamInvites && teamInvites.length > 0">
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

    <AppTeamInvite v-if="invites && invites.length > 0" :invites="invites" @update="getData" />

    <button v-if="owner" @click="deleteTeam">Расформировать команду</button>

    <button v-if="!owner && team" @click="removeTeammate(null, null)">Покинуть команду</button>

</template>

<script>
import {onMounted, ref} from "vue";
import axios from "axios";
import AppUserSearchForm from "./AppUserSearchForm.vue";
import AppTeamInvite from "./AppTeamInvite.vue";
import {useStore} from "vuex";

export default {
    name: "TheTeamCreateForm",
    components: {
        AppUserSearchForm, AppTeamInvite,
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
            console.log(teammates.value);
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

        const removeTeammate = async (id, idx) => {
            try {
                await axios.post(`/api/user/remove-teammate`, {id});
                if(id === null) {
                    await getData();
                } else {
                    teammates.value.splice(idx, 1);
                }
                store.dispatch('notification/displayMessage', {
                    value: 'Пользователь покинул команду',
                    type: 'primary',
                });
            } catch (e) {
                console.log(e.message);
                store.dispatch('notification/displayMessage', {
                    value: e.response.data.message,
                    type: 'error',
                });
            }
        };

        const deleteTeam = async () => {
          try {
              await axios.delete(`/api/team/delete`);
              store.dispatch('notification/displayMessage', {
                  value: 'Команда расформирована!',
                  type: 'primary',
              });
              await getData();
          }  catch (e) {
              console.log(e.message);
              store.dispatch('notification/displayMessage', {
                  value: e.response.data.message,
                  type: 'error',
              });
          }
        };

        return {
            name, team, submit,
            owner, addInvite, teamInvites,
            cancelInvite, teammates, invites,
            getData, removeTeammate, deleteTeam,
        }
    }
}
</script>

<style scoped>

</style>
