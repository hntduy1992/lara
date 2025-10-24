<script setup>
import {onMounted, ref, shallowRef, watch} from "vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import CreateDepartmentForm from "@/Pages/Department/CreateDepartmentForm.vue";
import HierarchicalSorter from "@/Services/buildTree.js";
import EditDepartmentForm from "@/Pages/Department/EditDepartmentForm.vue";

const search = ref('')
const selected = ref([])
const loading = ref(false)
const headers = ref([
    {
        title: 'Tên đơn vị',
        sortable: true,
        key: 'name',
    },
    {title: 'Actions', key: 'actions', align: 'center', sortable: false, width: '10%'},
])
const page = usePage()
const items = page.props.departments
const sorter = new HierarchicalSorter();
const sortedData = sorter.sort(items);

function filterText(value, query, item) {
    return value != null && query != null && typeof value === 'string' && value.toString().toLocaleLowerCase().indexOf(query) !== -1
}

const createDialogState = shallowRef(null)
const createDepartmentForm = useForm({
    name: '',
    parent_id: '',
    sort: ''
});

const OpenCreateDialog = () => {
    createDialogState.value = true
}

const OnUpdateItems = (newItems) => {
    router.visit('/don-vi', {
        only: ['departments']
    })
    createDialogState.value = false
}


// Edit
const editDialogState = ref(null)
</script>

<template>
    <v-data-table
        v-model="selected"
        :headers="headers"
        :items="sortedData"
        :search="search"
        item-value="name"
        return-object
        show-select
        :custom-filter="filterText"
        :items-per-page="-1"
        hide-default-footer
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
                <v-dialog
                    v-model="createDialogState"
                    max-width="400"
                >
                    <template v-slot:activator="{ props: activatorProps }">
                        <v-btn
                            class="me-2"
                            prepend-icon="mdi-plus"
                            rounded="lg"
                            text="Thêm đơn vị"
                            border
                            variant="elevated"
                            color="primary"
                            v-bind="activatorProps"
                        ></v-btn>
                    </template>
                    <CreateDepartmentForm @updateItems="OnUpdateItems"></CreateDepartmentForm>
                </v-dialog>

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
        <template v-slot:item.name="{item, value }">
            <template v-if="item.level>1">
                <v-icon v-for="i of item.level-1" class="text-white">mdi-minus
                </v-icon>
                <v-icon class="mr-3">mdi-arrow-right-bottom</v-icon>
                <span>   {{ value }}</span>
            </template>
            <template v-else>
                <span>   {{ value }}</span>
            </template>
        </template>
        <template v-slot:item.actions="{ item }">
            <div class="d-flex ga-2 justify-center">
                <v-dialog max-width="340">
                    <template v-slot:activator="{ props: activatorProps }">
                        <v-btn  v-bind="activatorProps" color="warning" icon="mdi-pencil" variant="text" size="small"></v-btn>
                    </template>
                    <EditDepartmentForm :Department="item"></EditDepartmentForm>
                </v-dialog>

                <v-btn color="red" icon="mdi-delete" size="small" variant="text"></v-btn>
            </div>
        </template>
    </v-data-table>

</template>

<style scoped>

</style>
