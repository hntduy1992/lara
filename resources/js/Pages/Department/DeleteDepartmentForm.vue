<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import "../../Services/buildTree.js"
import {onMounted, ref} from "vue";
import {toast} from "vue3-toastify";

const props = defineProps({
    Department: Object
})

const emit = defineEmits(['updateItems', 'closed'])

const page = usePage()
const loading = ref(null)
const formData = useForm({})
const items = page.props.departments.filter(e => e.parent_id === props.Department.id)
const confirmDelete = () => {
    loading.value = true
    formData.delete(`/don-vi/${props.Department.id}/xoa`, {
        only: ['departments', 'flash'],
        onSuccess: (res) => {
            toast(res.props.flash.message, {type: res.props.flash.type})
            emit('updateItems', res.props.departments)
        },
        onFinish: () => {
            loading.value = false
        }
    })
}
const cancelDelete = () => {
    emit('closed')
}

onMounted(() => {
})
</script>

<template>
    <v-card :loading="loading">
        <v-card-title class="text-h5 bg-error text-white">
            <v-icon left>mdi-alert-circle</v-icon>
            Xác nhận Xóa
        </v-card-title>


        <v-card-text class="py-4 text-center">
            <div>
                <b>Đơn vị</b> <br/>
                <v-chip variant="text" color="info">
                    <h2 class="font-weight-bold">{{ props.Department.name }}</h2>
                </v-chip>
            </div>

            <div class="mt-3">
                <b>Đơn vị trực thuộc: {{ items.length }}</b> <br/>
            </div>
            <h5 class="mt-5 text-red-darken-2 font-italic">
                ** Thao tác này không thể hoàn tác.
            </h5>
        </v-card-text>

        <v-card-actions class="d-flex justify-end">
            <v-btn
                color="grey-darken-1"
                variant="text"
                @click="cancelDelete"
            >
                Hủy bỏ
            </v-btn>

            <v-btn
                color="error"
                variant="flat"
                @click="confirmDelete"
            >
                <v-icon left>mdi-delete</v-icon>
                Xác nhận Xóa
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<style scoped>

</style>
