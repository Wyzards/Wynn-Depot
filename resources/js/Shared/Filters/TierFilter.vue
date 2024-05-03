<template>
    <FilterDropdown
        :options="[
            'normal',
            'unique',
            'rare',
            'legendary',
            'fabled',
            'mythic',
            'set',
        ]"
    >
        Tier
    </FilterDropdown>
</template>

<script setup>
import FilterDropdown from "./FilterDropdown.vue";
</script>
