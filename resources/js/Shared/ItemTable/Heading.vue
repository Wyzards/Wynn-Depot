<template>
    <th
        @click="sortable && sortBy()"
        :class="{
            'p-1 border text-gray-300 border-gray-300': true,
            'hover:cursor-pointer': sortable,
        }"
    >
        <slot />
    </th>
</template>

<script setup>
import { useItemFilterStore } from "/stores/ItemFilterStore.js";

const props = defineProps({
    items: Object,
    sortKey: String,
    sortable: {
        type: Boolean,
        default: true,
    },
});

const filters = useItemFilterStore();
const sortBy = function () {
    filters.sortDirection =
        filters.sortBy == props.sortKey
            ? filters.sortDirection == "asc"
                ? "desc"
                : "asc"
            : "asc";
    filters.sortBy = props.sortKey;
    filters.update();
};
</script>
