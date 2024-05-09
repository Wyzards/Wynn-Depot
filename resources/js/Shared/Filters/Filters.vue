<template>
    <div class="flex gap-2">
        <input v-model="search" type="text" placeholder="Search for items..." />

        <FilterDropdown
            :options="filters.tiers.options"
            :selected="filters.tiers.selected"
            @selectFilter="
                (sel) => {
                    filters.tiers.selected = sel;
                    filters.update();
                }
            "
        >
            Tier
        </FilterDropdown>

        <FilterDropdown
            :options="filters.types.options"
            :selected="filters.types.selected"
            @selectFilter="
                (sel) => {
                    filters.types.selected = sel;
                    filters.update();
                }
            "
        >
            Type
        </FilterDropdown>

        <LevelDropdown
            v-model:minLevel="minLevel"
            v-model:maxLevel="maxLevel"
        />

        <FilterDropdown
            :options="filters.misc.options"
            :selected="filters.misc.selected"
            @selectFilter="
                (sel) => {
                    filters.misc.selected = sel;
                    filters.update();
                }
            "
        >
            Misc
        </FilterDropdown>

        <FilterDropdown
            :options="storageOptions"
            :selected="filters.storage.selected"
            @selectFilter="
                (sel) => {
                    filters.storage.selected = sel;
                    filters.update();
                }
            "
        >
            Storage
        </FilterDropdown>

        <button
            @click="filters.clear()"
            class="p-2 bg-red-400 border border-black rounded-lg h-fit"
        >
            <svg height="10" width="10" xmlns="http://www.w3.org/2000/svg">
                <line
                    x1="0"
                    y1="0"
                    x2="10"
                    y2="10"
                    style="stroke: black; stroke-width: 1"
                />
                <line
                    x1="0"
                    y1="10"
                    x2="10"
                    y2="0"
                    style="stroke: black; stroke-width: 1"
                />
            </svg>
        </button>
    </div>
</template>

<script setup>
import { watch, ref } from "vue";
import { useItemFilterStore } from "/stores/ItemFilterStore.js";
import debounce from "lodash/debounce";
import FilterDropdown from "./FilterDropdown.vue";
import LevelDropdown from "./LevelDropdown.vue";

const props = defineProps({
    storageOptions: Array,
});

const filters = useItemFilterStore();
const search = ref(filters.search);
const minLevel = ref(filters.level.min);
const maxLevel = ref(filters.level.max);

watch(
    [search, minLevel, maxLevel],
    debounce(function (values) {
        filters.search = search;
        filters.level.min = minLevel;
        filters.level.max = maxLevel;
        filters.update();
    }, 300)
);
</script>
