<template>
    <Dropdown :closeOnClick="false" width="w-fit">
        <template #trigger>
            <FilterTrigger><slot /></FilterTrigger>
        </template>

        <template #content>
            <FilterOption v-for="option in options" :key="option">
                {{ option }}
            </FilterOption>
        </template>
    </Dropdown>
</template>

<script setup>
import Dropdown from "../../Components/Dropdown.vue";
import FilterTrigger from "./FilterTrigger.vue";
import FilterOption from "./FilterOption.vue";

defineProps({
    options: Array,
});
</script>
