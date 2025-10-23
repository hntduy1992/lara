<script setup>

import {usePage} from "@inertiajs/vue3";

const form = defineModel('Form')
const page = usePage()
const getTreeDepartment = () => {
    const items = page.props.departments
    let resultItems = []

}
</script>

<template>
    <v-select variant="outlined" label="Đơn vị trực thuộc" v-model="form.parent_id">
    </v-select>
    <v-text-field variant="outlined" label="Tên đơn vị" v-model="form.name"></v-text-field>
</template>

<style scoped>

</style>
