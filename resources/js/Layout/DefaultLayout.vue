<script setup>

import {usePage} from "@inertiajs/vue3";

const page = usePage()
const isAuthenticated = !!page.props.auth.user
</script>

<template>
    <template v-if="isAuthenticated">
        <h1>Authenticated</h1>
        <slot></slot>
    </template>
    <template v-else>
        <h1>Un Authenticated</h1>
        <slot></slot>
    </template>

</template>

<style scoped>

</style>
