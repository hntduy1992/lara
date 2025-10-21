<script setup>
import {ref} from "vue";
import {usePage} from "@inertiajs/vue3";

const fav = ref(true)
const menu = ref(false)
const message = ref(false)
const hints = ref(true)
const page = usePage()
const user = page.props.auth?.user
</script>
<template>
    <v-menu
        v-model="menu"
        :close-on-content-click="true"
        location="top"
    >
        <template v-slot:activator="{ props }">
            <v-btn
                color="indigo"
                v-bind="props"
            >
                {{ user.ho_ten }}
            </v-btn>
        </template>

        <v-card min-width="200">
            <v-list>
                <v-list-item
                    prepend-avatar="https://cdn.vuetifyjs.com/images/john.jpg"
                    :subtitle="user.user_roles[0]"
                    :title="user.ho_ten"
                >
                    <template v-slot:append>
                        <v-btn
                            :class="fav ? 'text-red' : ''"
                            icon="mdi-heart"
                            variant="text"
                            @click="fav = !fav"
                        ></v-btn>
                    </template>
                </v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-list>
                <v-list-item link title="Hồ sơ" prepend-icon="mdi-home-account"></v-list-item>
                <v-list-item link title="Đổi mật khẩu" prepend-icon="mdi-shield-account"></v-list-item>
            </v-list>

            <v-card-actions>
                <slot name="logoutButton" class="w-100"></slot>
            </v-card-actions>
        </v-card>
    </v-menu>
</template>

<style scoped>

</style>
