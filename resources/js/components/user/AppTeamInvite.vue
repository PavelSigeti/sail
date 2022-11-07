<template>
    <div class="team-invites">
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
import {ref} from "vue";
import axios from "axios";
import {useStore} from "vuex";

export default {
    name: "AppTeamInvite",
    props: ['invites'],

    setup(props, {emit}) {
        const invites = ref(props.invites);
        const store = useStore();

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
                emit('update');
            } catch (e) {
                console.log(e.message);
                store.dispatch('notification/displayMessage', {
                    value: 'Ошибка при вступлении в команду',
                    type: 'error',
                });
            }
        };

        return {
            invites, rejectInvite, acceptInvite
        }
    }
}
</script>

<style scoped>

</style>
