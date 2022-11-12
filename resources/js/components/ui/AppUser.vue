<template>
  <div class="user">
      <div class="user__container">
          <div class="user-icon">
              <img src="@/static/sea.png" alt="">
          </div>
          <div class="user-data">
              <div class="user-nick">
                  {{ user.nickname }}
                  <span class="user-id">#{{user.id}}</span>
              </div>
              <div class="user-name">
                  {{user.name}} {{user.surname}}
              </div>
          </div>
      </div>
      <div class="user-settings">
          <router-link to="/settings"><i class="ri-settings-2-fill"></i></router-link>
      </div>
  </div>
</template>

<script>
import { useStore } from 'vuex';
import { ref } from 'vue';

export default {
    name: "AppUser",
    setup() {
        const store = useStore();

        const user = ref(store.getters['auth/user']);

        return {
            user
        };

    }
}
</script>

<style scoped>

</style>
