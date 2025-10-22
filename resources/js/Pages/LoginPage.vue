<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import {toast} from "vue3-toastify";

const page = usePage()
const form = useForm({
    username: 'admin',
    password: '12345',
})
const onFormSubmit = () => {
    form.post('/login', {
        onSuccess: (res) => {
            window.location.reload()
            toast(res.props.flash.message, {type: res.props.flash.type})
        }
    })

}
</script>
<template>
    <div class="background d-flex justify-center align-center h-screen">
        <v-card width="400">
            <v-card-title class="text-center">VĂN PHÒNG ĐIỆN TỬ <br> Khóm</v-card-title>
            <v-card-text>
                <v-form @submit.prevent="onFormSubmit">
                    <v-text-field
                        v-model="form.username"
                        variant="outlined"
                        label="Username"
                        prepend-icon="mdi-account"
                        :error-messages="form.errors.username"
                        density="compact"
                        class="mb-2"
                    ></v-text-field>
                    <v-text-field
                        v-model="form.password"
                        variant="outlined"
                        label="Password"
                        prepend-icon="mdi-key"
                        :error-messages="form.errors.password"
                        density="compact"
                        class="mb-2"
                        type="password"
                    ></v-text-field>
                    <v-btn color="success" class="w-100" type="submit">Đăng nhập</v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </div>
</template>

<style scoped>
.background{
    background-image: url("../../images/background_login.jpg");
    background-size: cover;
    background-position: left;
}
</style>
