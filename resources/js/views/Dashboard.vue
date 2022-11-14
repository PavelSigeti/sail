<template>
    <header class="dashboard-header">
        <h1>Личный кабинет</h1>
        <div class="header-content">
            <div class="btn btn-border support-btn">Обратная связь</div>
            <div class="header-notification">
                <span class="header-notification__counter">1</span>
                <i class="ri-notification-2-fill"></i>
            </div>
        </div>
    </header>
    <main>
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-lg-4">
                    <TheTeamSettings />
                </div>
                <div class="col-lg-8"></div>
            </div>
        </div>
    </main>
</template>

<script>
import TheTeamSettings from "../components/user/team/TheTeamSettings.vue";

export default {
    name: "Dashboard",
    components: {
        TheTeamSettings
    },
    setup() {
        return {
        }
    }
}
</script>

