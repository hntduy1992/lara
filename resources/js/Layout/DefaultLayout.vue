<script setup>

import {router, useForm, usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import {toast} from "vue3-toastify";
import UserControl from "@/Components/UserControl.vue";

const page = usePage()
const isAuthenticated = !!page.props.auth.user
const drawer = ref(null)
const links = [
    ['mdi-inbox-arrow-down', 'Inbox'],
    ['mdi-send', 'Send'],
    ['mdi-delete', 'Trash'],
    ['mdi-alert-octagon', 'Spam'],
]

const loginDialog = ref(false)
const logoutDialog = ref(false)
const loginFormLoading = ref(false)
const loginForm = useForm({
    username: '',
    password: ''
})
const login = () => {
    loginFormLoading.value = true
    loginForm.post('/login', {
        onSuccess: (page) => {
            toast(page.props.flash.message, {type: page.props.flash.type})
            window.location.reload()
        },
        onFinish: () => {
            loginFormLoading.value = false
        }
    })
}
const logout = () => {
    const formLogout = useForm({})
    formLogout.post('/logout', {
        onSuccess: (res) => {
            window.location.reload()
        }
    })
}
</script>

<template>
    <v-app>
        <!--        Nav for admin-->
        <template v-if="isAuthenticated">
            <v-navigation-drawer v-model="drawer">
                <v-divider></v-divider>
                <v-list>
                    <v-list-item link title="Test" @click="router.visit('/test-role')"></v-list-item>
                </v-list>
            </v-navigation-drawer>
            <v-app-bar class="d-flex justify-lg-space-between">
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

        </template>
        <!--        Nav for user-->
        <template v-else>
            <v-app-bar class="d-flex justify-lg-space-between">
                <v-tabs color="primary">
                    <v-tab value="one">Item One</v-tab>
                    <v-tab value="two">Item Two</v-tab>
                    <v-tab value="three">Item Three</v-tab>
                </v-tabs>
                <v-spacer/>
                <v-dialog
                    v-model="loginDialog"
                    max-width="400"
                >
                    <template v-slot:activator="{ props: activatorProps }">
                        <v-btn v-bind="activatorProps">
                            Đăng nhập
                        </v-btn>
                    </template>

                    <v-card :loading="loginFormLoading">
                        <v-card-title class="text-center">TÀI KHOẢN ĐĂNG NHẬP</v-card-title>
                        <v-card-text class="px-5 py-1">
                            <v-form>
                                <v-text-field class="mb-2" v-model="loginForm.username"
                                              :error-messages="loginForm.errors.username"
                                              label="Username" variant="outlined"></v-text-field>
                                <v-text-field v-model="loginForm.password" :error-messages="loginForm.errors.password"
                                              type="password" label="Password" variant="outlined"></v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn @click="login" color="primary" variant="elevated" class="w-100">
                                Đăng nhập
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-app-bar>
        </template>
        <v-main>
            <slot></slot>
        </v-main>
    </v-app>


    <slot></slot>
</template>

<style scoped>

</style>
