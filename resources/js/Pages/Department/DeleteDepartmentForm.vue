<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import "../../Services/buildTree.js"
import {onMounted, ref} from "vue";
import {toast} from "vue3-toastify";

const props = defineProps({
    Data: Object,
    multi: Boolean
})

const emit = defineEmits(['updateItems', 'closed'])

const page = usePage()
const loading = ref(null)
const formData = useForm({
    item: null,
    ids: null
})
const items = page.props.departments.filter(e => e.parent_id === props.Data.id)
const confirmDelete = () => {
    loading.value = true
    if (props.multi) {
        formData.ids = props.Data.map(x => x.id)
        formData.delete(`/don-vi/multi/xoa`, {
            only: ['departments', 'flash'],
            onSuccess: (res) => {
                toast(res.props.flash.message, {type: res.props.flash.type})
                emit('updateItems')
            },
            onFinish: () => {
                loading.value = false
            }
        })
    } else {
        loading.value = true
        formData.item = props.Data
        formData.delete(`/don-vi/${formData.item.id}/xoa`, {
            only: ['departments', 'flash'],
            onSuccess: (res) => {
                toast(res.props.flash.message, {type: res.props.flash.type})
                emit('updateItems')
            },
            onFinish: () => {
                loading.value = false
            }
        })
    }
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


        <v-card-text class="py-4 text-center" v-if="props.multi">
            <div>
                <b>Bạn đang xóa</b> <br/>
                <v-chip variant="text" color="info">
                    <h2 class="font-weight-bold"> {{ props.Data.length }}</h2>
                </v-chip>
            </div>

            <div class="mt-3">
                <b>Đơn vị</b> <br/>
            </div>
            <h5 class="mt-5 text-red-darken-2 font-italic">
                ** Thao tác này không thể hoàn tác.
            </h5>
        </v-card-text>
        <v-card-text class="py-4 text-center" v-else>
            <div>
                <b>Đơn vị</b> <br/>
                <v-chip variant="text" color="info">
                    <h2 class="font-weight-bold">{{ props.Data.name }}</h2>
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
