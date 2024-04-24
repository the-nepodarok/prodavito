<script setup>

</script>

<template>
    <a class="top-logo" href="/">
        <img src="../img/graffiti.png" width="631" style="grid-area: a;" alt="Текстовый логотип: prod'a vita">
        <img class="hamster-logo" src="../img/hamster.png" width="168" style="grid-area: b;" alt="Текстовый логотип: prod'a vita">
    </a>
    <router-view v-slot="{ Component, route }">
        <div :key="route.name">
            <Component :is="Component" />
        </div>
    </router-view>
</template>

<style scoped>

</style>
