<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";

const search = ref('')
const serverItems = ref([])
const loading = ref(true)
const totalItems = ref(0)
const itemsPerPage = ref(5)
const headers = ref([
    {
        title: 'Dessert (100g serving)',
        align: 'start',
        sortable: false,
        key: 'name',
    },
    { title: 'Calories', key: 'calories', align: 'end' },
    { title: 'Fat (g)', key: 'fat', align: 'end' },
    { title: 'Carbs (g)', key: 'carbs', align: 'end' },
    { title: 'Protein (g)', key: 'protein', align: 'end' },
    { title: 'Iron (%)', key: 'iron', align: 'end' },
])
function loadItems({page, itemsPerPage, sortBy}) {
    loading.value = true
    router.get('', {page, itemsPerPage, sortBy}, {
        onSuccess: (res) => {
            serverItems.value = res.props.items
            totalItems.value = res.props.total
            loading.value = false
        }
    })
}
</script>

<template>
    <v-data-table-server
        v-model:items-per-page="itemsPerPage"
        :headers="headers"
        :items="serverItems"
        :items-length="totalItems"
        :loading="loading"
        :search="search"
        item-value="name"
        @update:options="loadItems"
    ></v-data-table-server>
</template>

<style scoped>

</style>
