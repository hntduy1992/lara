<script setup>
import {usePage} from "@inertiajs/vue3";

const page = usePage()
const message = page.props.message
</script>

<template>
<v-container>
   <v-alert :text="message" type="warning" prominent></v-alert>
</v-container>
</template>

<style scoped>

</style>
