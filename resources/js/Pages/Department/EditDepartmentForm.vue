<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import "../../Services/buildTree.js"
import HierarchicalSorter from "@/Services/buildTree.js";
import {onMounted, ref} from "vue";
import {toast} from "vue3-toastify";

const props = defineProps({
    Department: Object
})
const page = usePage()
const items = page.props.departments.filter(e=>e.id!==props.Department.id)
const emit = defineEmits(['updateItems'])
// Khởi tạo và sắp xếp
const sorter = new HierarchicalSorter();
const sortedData = sorter.sort(items);
const formData = useForm({
    parent_id: props.Department.parent_id,
    name: props.Department.name,
    sort: props.Department.sort
})
const loading = ref(null)
const submit = () => {
    loading.value = true
    formData.post(`/don-vi/${props.Department.id}/cap-nhat`, {
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
const updateSort = (e) => {
    const child = items.filter(x => x.parent_id === e).map(y => y.sort)
    formData.sort = Math.max(...child, 0) + 1
}
onMounted(() => {
})
</script>

<template>
    <v-card :loading="loading">
        <v-card-title class="text-center bg-info" >
            THÔNG TIN ĐƠN VỊ
        </v-card-title>
        <v-card-text>
            <v-select variant="outlined" label="Đơn vị trực thuộc" v-model="formData.parent_id" :items="sortedData"
                      item-value="id"
                      item-title="name" clearable
                      @update:modelValue="updateSort">
                <template v-slot:item="{ props: itemProps, item }">
                    <v-list-item v-if="item.raw.level>1" v-bind="itemProps">
                        <template v-slot:prepend>
                            <v-icon v-for="i of item.raw.level-2" :class="{'text-white':i===item.raw.level-2}">mdi-minus
                            </v-icon>
                            <v-icon>mdi-arrow-right-bottom</v-icon>
                        </template>
                    </v-list-item>
                    <template v-else>
                        <v-list-item v-bind="itemProps"
                        ></v-list-item>
                    </template>
                </template>
            </v-select>
            <v-text-field class="mb-2" variant="outlined" label="Tên đơn vị" v-model="formData.name" clearable
                          :error-messages="formData.errors.name"></v-text-field>
            <v-number-input variant="outlined" label="Vị trí" v-model="formData.sort" :min="1" clearable
            ></v-number-input>
            <v-btn prepend-icon="mdi-home-plus-outline" color="info" class="w-100" @click="submit">Cập nhật
            </v-btn>

        </v-card-text>
    </v-card>
</template>

<style scoped>

</style>
