<script setup>

import navSideItems from "../Datas/navSideItems.js";
import {router} from "@inertiajs/vue3";
import {ref} from "vue";

const opened = ref(['department'])
</script>

<template>
    <v-list v-model:opened="opened">
        <template v-for="(item,i) of navSideItems">
            <!--                    Item-->
            <v-list-item v-if="item.href"
                         link
                         :title="item.text"
                         :prepend-icon="item.icon"
                         @click="router.visit(item.href)"></v-list-item>

            <!--                    end Item-->
            <!--                    Group list-->
            <v-list-group v-else :value="item.name">
                <template v-slot:activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        :prepend-icon="item.icon"
                        :title="item.text"
                    ></v-list-item>
                </template>

                <v-list-item
                    v-for="(subItem, i) in item.chidren"
                    link
                    :key="i"
                    :prepend-icon="subItem.icon"
                    :title="subItem.text"
                    :href="subItem.href"
                ></v-list-item>
            </v-list-group>
            <!--                    end-->
        </template>
    </v-list>
</template>

<style scoped>

</style>
