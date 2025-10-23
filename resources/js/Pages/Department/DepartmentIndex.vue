<script setup>
import {ref} from "vue";
import {router, usePage} from "@inertiajs/vue3";

const search = ref('')
const selected = ref([])
const loading = ref(false)
const itemsPerPage = ref(5)
const headers = ref([
    {
        title: 'Tên đơn vị',
        sortable: true,
        key: 'name',
    },
    {
        title: 'Đơn vị cha',
        sortable: false,
        align: 'center',
        key: 'parent_id',
    },
    {
        title: 'Cấp độ',
        sortable: true,
        align: 'center',
        key: 'level',
    },
    {title: 'Actions', key: 'actions', align: 'center', sortable: false, width: '10%'},
])
const page = usePage()
const items = page.props.departments

function filterText(value, query, item) {
    return value != null && query != null && typeof value === 'string' && value.toString().toLocaleLowerCase().indexOf(query) !== -1
}
</script>

<template>
    <v-data-table
        v-model="selected"
        :headers="headers"
        :items="items"
        :search="search"
        item-value="name"
        return-object
        show-select
        :custom-filter="filterText"
        :hide-default-footer="items.length<11"
    >
        <template v-slot:top>
            <v-toolbar flat>
                <v-toolbar-title>
                    <v-icon color="medium-emphasis" icon="mdi-view-list-outline" size="x-small" start></v-icon>
                    Danh sách đơn vị
                </v-toolbar-title>
                <v-text-field
                    v-model="search"
                    label="Search"
                    variant="outlined"
                    density="compact"
                    hide-details
                    single-line
                    max-width="300"
                    class="mr-5"
                >
                    <template v-slot:append-inner>
                        <v-btn prepend-icon="mdi-magnify"
                               @click="">Tìm
                        </v-btn>
                    </template>
                </v-text-field>
                <v-btn
                    class="me-2"
                    prepend-icon="mdi-plus"
                    rounded="lg"
                    text="Thêm đơn vị"
                    border
                    variant="elevated"
                    color="primary"
                ></v-btn>

                <v-badge v-if="selected.length" bordered location="top left">
                    <template v-slot:badge>
                        {{ selected.length }}
                    </template>
                    <v-btn
                        class="me-2"
                        prepend-icon="mdi-delete-sweep"
                        rounded="lg"
                        text="Xóa nhiều"
                        border
                        variant="elevated"
                        color="red"
                    ></v-btn>
                </v-badge>
            </v-toolbar>

        </template>
        <template v-slot:item.actions="{ item }">
            <div class="d-flex ga-2 justify-center">
                <v-btn color="warning" icon="mdi-pencil" variant="text" size="small"></v-btn>

                <v-btn color="red" icon="mdi-delete" size="small" variant="text"></v-btn>
            </div>
        </template>
    </v-data-table>
</template>

<style scoped>

</style>
