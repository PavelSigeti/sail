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
                <div class="col-lg-8">
                    <div class="dashboard-item">
                        <h3>Актуальные гонки</h3>
                        <div class="dash-stage__container">
                            <AppDashActualStages></AppDashActualStages>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import TheTeamSettings from "../components/user/team/TheTeamSettings.vue";
import AppDashActualStages from "../components/user/dash/AppDashActualStages.vue";

export default {
    name: "Dashboard",
    components: {
        TheTeamSettings, AppDashActualStages,
    },
    setup() {
        return {
        }
    }
}
</script>

