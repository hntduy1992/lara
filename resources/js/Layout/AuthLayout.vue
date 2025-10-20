<script setup>
import {ref} from 'vue'
const drawer = ref(null)
</script>

<template>
    <v-app>
        <v-navigation-drawer v-model="drawer">
            <!--  -->
        </v-navigation-drawer>

        <v-app-bar>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-app-bar-title>Application</v-app-bar-title>
        </v-app-bar>
        <v-main>
            <slot></slot>
        </v-main>
    </v-app>
</template>

<style scoped>

</style>
