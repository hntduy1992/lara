<script setup>

import {router, useForm, usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import {toast} from "vue3-toastify";
import UserControl from "@/Components/UserControl.vue";

const page = usePage()
const isAuthenticated = !!page.props.auth.user
const user = page.props.auth.user
const drawer = ref(null)
const links = [
    ['mdi-inbox-arrow-down', 'Inbox'],
    ['mdi-send', 'Send'],
    ['mdi-delete', 'Trash'],
    ['mdi-alert-octagon', 'Spam'],
]

const logoutDialog = ref(false)
const logout = () => {
    const formLogout = useForm({})
    formLogout.delete('/logout', {
        onSuccess: (res) => {
            window.location.reload()
            logoutDialog.value = false
        }
    })
}
import NavSideControl from "@/Layout/NavSideControl.vue";
</script>

<template>
    <v-app>
        <v-navigation-drawer v-if="isAuthenticated" v-model="drawer" color="primary">
            <v-divider></v-divider>
            <NavSideControl></NavSideControl>
        </v-navigation-drawer>
        <v-app-bar class="d-flex justify-lg-space-between" v-if="isAuthenticated">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-spacer></v-spacer>
            <UserControl>
                <template v-slot:logoutButton>
                    <v-dialog
                        v-model="logoutDialog"
                        max-width="400"
                    >
                        <template v-slot:activator="{ props: activatorProps }">
                            <v-btn v-bind="activatorProps" color="error" variant="elevated" class="w-100">
                                Đăng xuất
                            </v-btn>
                        </template>

                        <v-card
                            title="THÔNG BÁO"
                            text="Bạn đang đăng xuất khỏi hệ thống!"
                        >
                            <v-card-actions>
                                <v-btn @click="logoutDialog=false" class="flex-grow-1">
                                    Thoát
                                </v-btn>
                                <v-btn @click="logout" class="flex-grow-0" color="error" variant="elevated">
                                    Đăng xuất
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </template>
            </UserControl>
        </v-app-bar>
        <v-main>
            <slot></slot>
        </v-main>
    </v-app>
</template>

<style scoped>

</style>
