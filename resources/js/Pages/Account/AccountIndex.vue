<script setup>
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";

const page = usePage()

const data = page.props.data
const headers = [
    {title: 'username', sortable: false, key: 'username',},
    {title: 'Họ tên', key: 'ho_ten', align: 'center', sortable: true},
    {title: 'Điện thoại', key: 'dien_thoai', align: 'center', sortable: false},
    {title: 'Trạng thái', key: 'is_active', align: 'center', sortable: false},
    {title: 'Actions', key: 'actions', align: 'center', sortable: false, width: '10%'},
]

const selected = ref(null)
const search = ref(null)
</script>

<template>
    <v-data-table
        v-model="selected"
        :headers="headers"
        :items="data"
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
                    <CreateAccountForm @updateItems="OnCreateItems"></CreateAccountForm>
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
                <span>{{ item.sort }}  . {{ value }}</span>
            </template>
            <template v-else>
                <span> {{ item.sort }}  .  {{ value }}</span>
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
        <EditAccountForm :Department="itemUD" @updateItems="OnUpdateItems"></EditAccountForm>
    </v-dialog>
    <v-dialog max-width="400" v-model="deleteDialogState">
        <DeleteAccountForm :Department="itemUD" @updateItems="OnUpdateItems"
                           @closed="deleteDialogState=false"></DeleteAccountForm>
    </v-dialog>
</template>

<style scoped>

</style>
