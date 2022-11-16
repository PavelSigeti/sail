<template>
    <header class="dashboard-header">
        <h1><slot /></h1>
        <div class="header-content">
            <div class="btn btn-border support-btn">Обратная связь</div>
            <div class="header-notification">
                <span class="header-notification__counter">1</span>
                <i class="ri-notification-2-fill"></i>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    name: "AppHeader.vue"
}
</script>
