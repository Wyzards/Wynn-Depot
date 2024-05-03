<template>
    <FilterDropdown
        :options="['Owned', 'Not Owned', 'Untradeable', 'Quest Item']"
    >
        Misc
    </FilterDropdown>
</template>

<script setup>
import FilterDropdown from "./FilterDropdown.vue";
</script>
