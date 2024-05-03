<template>
    <FilterDropdown
        :options="[
            '1-10',
            '11-20',
            '21-30',
            '31-40',
            '41-50',
            '51-60',
            '61-70',
            '71-80',
            '81-90',
            '91-100',
            '100+',
        ]"
    >
        Level
    </FilterDropdown>
</template>

<script setup>
import FilterDropdown from "./FilterDropdown.vue";
</script>
