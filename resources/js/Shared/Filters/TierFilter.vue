<template>
    <FilterDropdown
        :options="[
            'Helmet',
            'Chestplate',
            'Leggings',
            'Boots',
            'Necklace',
            'Bracelet',
            'Ring',
         ]"
    >
        Type
    </FilterDropdown>
</template>
<script setup lang="ts">
import FilterDropdown from "@/Shared/Filters/FilterDropdown.vue";
</script>
