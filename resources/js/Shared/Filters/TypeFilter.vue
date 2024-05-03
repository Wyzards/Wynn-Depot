<template>
    <FilterDropdown
        :options="[
            'helmet',
            'chestplate',
            'leggings',
            'boots',
            'necklace',
            'bracelet',
            'ring',
            'wand',
            'dagger',
            'bow',
            'relik',
            'spear',
        ]"
    >
        Type
    </FilterDropdown>
</template>

<script setup>
import FilterDropdown from "./FilterDropdown.vue";
</script>
