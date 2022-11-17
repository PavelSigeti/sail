<template>
    <div class="dashboard-item">
        <AppLoader v-if="loading" />
        <h3>Команда</h3>
        <div class="content-block" v-if="team">
            <p>Ваша команда: <span class="b500">{{team.name}}</span></p>
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
                            <div class="btn btn-border btn-team">Исключить</div>
                        </div>
                    </div>
                </div>
        </div>
        <div v-else class="content-block">
            <p>Вы не состоите в команде :(</p>
            <form  @submit.prevent="submit">
                <div class="form-control">
                    <label for="name">Создайте свою команду</label>
                    <input class="form-input" id="name" type="text" v-model="name" placeholder="Название команды">
                </div>
                <button class="btn btn-default btn-full-width">Создать команду</button>
            </form>
        </div>


        <AppUserSearchForm
            v-if="owner && teamInvites && teammates && teamInvites.length < 3 - teammates.length"
            :team_id="team.id"
            @invite="addInvite"
            @load="toggleLoad"
        />

        <div class="team-invites" v-if="teamInvites && teamInvites.length > 0">
            <h3>Приглашения</h3>
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
                <div class="user-item__btn" @click="cancelInvite(invite.id, idx)">
                    <div class="btn btn-border btn-team">Отменить</div>
                </div>
            </div>
        </div>
        <button class="btn btn-border btn-full-width" v-if="owner" @click="deleteTeam">Расформировать команду</button>
        <button
            v-if="!owner && team"
            class="btn btn-border btn-full-width"
            @click="removeTeammate(null, null)"
        >
            Покинуть команду
        </button>
        <AppTeamInvite
            v-if="invites && invites.length > 0"
            :invites="invites"
            @update="getData"
            @load="toggleLoad"
        />
    </div>
</template>

<script>
import {onMounted, ref} from "vue";
import axios from "axios";
import AppUserSearchForm from "../AppUserSearchForm.vue";
import AppTeamInvite from "./AppTeamInvite.vue";
import {useStore} from "vuex";
import AppLoader from "../../ui/AppLoader.vue";

export default {
    name: "TheTeamCreateForm",
    components: {
        AppUserSearchForm, AppTeamInvite, AppLoader,
    },
    setup() {
        const store = useStore();

        const name = ref();
        const team = ref();
        const invites = ref();
        const owner = ref(false);
        const teammates = ref([]);
        const teamInvites = ref();
        const loading = ref(false);

        const toggleLoad = () => {
            loading.value = !loading.value;
        };

        const getData = async () => {
            loading.value = true;
            try {
                const response = await axios.get('/api/team/edit');
                team.value = response.data.team;
                invites.value = response.data.invites;
                owner.value = response.data.owner;
                teammates.value = response.data.teammates;
                teamInvites.value = response.data.teamInvites;
                loading.value = false;
            } catch (e) {
                console.log(e.message);
                loading.value = false;
            }
        };

        onMounted(async() => {
            await getData();
        });

        const submit = async () => {
            loading.value = true;
            try {
                await axios.post('/api/team/store', {
                    name: name.value,
                });
                await getData();
                loading.value = false;
            } catch (e) {
                if(e.response.status === 422) {
                    store.dispatch('notification/displayMessage', {
                        value: 'Такое имя команды уже существует',
                        type: 'error',
                    });
                } else {
                    console.log(e.message);
                }
                loading.value = false;
            }
        };

        const cancelInvite = async (id, idx) => {
            loading.value = true;
            try {
                await axios.delete(`/api/team-invite/${id}/delete`);
                teamInvites.value.splice(idx, 1);
                store.dispatch('notification/displayMessage', {
                    value: 'Приглашение отменено',
                    type: 'primary',
                });
                loading.value = false;
            } catch (e) {
                console.log(e.message);
                store.dispatch('notification/displayMessage', {
                    value: e.message,
                    type: 'error',
                });
                loading.value = false;
            }
        };

        const addInvite = (payload) => {
            teamInvites.value.push(payload);
        };

        const removeTeammate = async (id, idx) => {
            loading.value = true;
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
                loading.value = false;
            } catch (e) {
                console.log(e.message);
                store.dispatch('notification/displayMessage', {
                    value: e.response.data.message,
                    type: 'error',
                });
                loading.value = false;
            }
        };

        const deleteTeam = async () => {
            loading.value = true;
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
            loading.value = false;
        };

        return {
            name, team, submit,
            owner, addInvite, teamInvites,
            cancelInvite, teammates, invites,
            getData, removeTeammate, deleteTeam,
            loading, toggleLoad,
        }
    }
}
</script>

<style scoped>

</style>
