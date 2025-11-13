<script setup>
import {onMounted, ref, shallowRef, watch} from "vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import CreateDepartmentForm from "@/Pages/Department/CreateDepartmentForm.vue";
import HierarchicalSorter from "@/Services/buildTree.js";
import EditDepartmentForm from "@/Pages/Department/EditDepartmentForm.vue";
import DeleteDepartmentForm from "@/Pages/Department/DeleteDepartmentForm.vue";

const search = ref('')
const selected = ref([])
const loading = ref(false)
const headers = ref([
    {
        title: 'Tên đơn vị',
        sortable: false,
        key: 'name',
    },
    {title: 'Actions', key: 'actions', align: 'center', sortable: false, width: '10%'},
])
const page = usePage()
const items = page.props.departments
const sorter = new HierarchicalSorter();
const sortedData = sorter.sort(items);
const itemUD = ref(null)
const createDialogState = shallowRef(null)
const updateDialogState = shallowRef(null)
const deleteDialogState = shallowRef(null)


const OnCreateItems = (newItems) => {
    router.visit('/don-vi', {
        only: ['departments']
    })
    createDialogState.value = false
}
const OnUpdateItems = () => {
    router.visit('/don-vi', {
        only: ['departments']
    })
    updateDialogState.value = false
}

const updateItem = (item) => {
    updateDialogState.value = true;
    itemUD.value = item
}
const deleteItem = (item) => {
    deleteDialogState.value = true
    itemUD.value = item
}
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
                    label="Nhập để tìm kiếm"
                    variant="outlined"
                    density="compact"
                    hide-details
                    single-line
                    max-width="300"
                    class="mr-5"
                    clearable
                >
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
                    <CreateDepartmentForm @updateItems="OnCreateItems"></CreateDepartmentForm>
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
                <span>{{item.sort}}  . {{ value }}</span>
            </template>
            <template v-else>
                <span> {{item.sort}}  .  {{ value }}</span>
            </template>
        </template>
        <template v-slot:item.actions="{ item }">
            <div class="d-flex ga-2 justify-center">

                <v-btn @click="updateItem(item)" color="warning" icon="mdi-pencil" variant="text"
                       size="small"></v-btn>

                <v-btn @click="deleteItem(item)" color="red" icon="mdi-delete" variant="text"
                       size="small"></v-btn>
            </div>
        </template>
    </v-data-table>
    <v-dialog max-width="400" v-model="updateDialogState">
        <EditDepartmentForm :Department="itemUD" @updateItems="OnUpdateItems"></EditDepartmentForm>
    </v-dialog>
    <v-dialog max-width="400" v-model="deleteDialogState">
        <DeleteDepartmentForm :Department="itemUD" @updateItems="OnUpdateItems"
                              @closed="deleteDialogState=false"></DeleteDepartmentForm>
    </v-dialog>
</template>

<style scoped>

</style>
