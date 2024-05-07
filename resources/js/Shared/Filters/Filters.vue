<template>
    <div class="flex gap-2">
        <input v-model="search" type="text" placeholder="Search for items..." />

        <FilterDropdown
            :options="filters.tiers.options"
            :selected="filters.tiers.selected"
            @selectFilter="
                (sel) => {
                    filters.tiers.selected = sel;
                    updateFilters();
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
                    updateFilters();
                }
            "
        >
            Type
        </FilterDropdown>

        <Dropdown :closeOnClick="false">
            <template #trigger>
                <button
                    class="px-2 text-sm text-white bg-blue-500 border border-black rounded-lg h-7"
                >
                    Level
                </button>
            </template>

            <template #content>
                <div class="flex justify-evenly">
                    <input
                        v-model="minLvl"
                        type="text"
                        placeholder="0"
                        class="w-14"
                    />
                    <input
                        v-model="maxLvl"
                        type="text"
                        placeholder="105"
                        class="w-14"
                    />
                </div>
            </template>
        </Dropdown>

        <FilterDropdown
            :options="filters.misc.options"
            :selected="filters.misc.selected"
            @selectFilter="
                (sel) => {
                    filters.misc.selected = sel;
                    updateFilters();
                }
            "
        >
            Misc
        </FilterDropdown>

        <FilterDropdown
            :options="filters.misc.options"
            :selected="filters.misc.selected"
            @selectFilter="
                (sel) => {
                    filters.misc.selected = sel;
                    updateFilters();
                }
            "
        >
            Storage
        </FilterDropdown>
    </div>
</template>

<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import { useItemFilterStore } from "/stores/ItemFilterStore.js";
import FilterDropdown from "./FilterDropdown.vue";
import { router } from "@inertiajs/vue3";
import { watch, ref } from "vue";
import debounce from "lodash/debounce";

const filters = useItemFilterStore();
const search = ref(filters.search);
const minLvl = ref(filters.level.min);
const maxLvl = ref(filters.level.max);

watch(
    [search, minLvl, maxLvl],
    debounce(function (values) {
        filters.search = search;
        filters.level.min = minLvl;
        filters.level.max = maxLvl;

        updateFilters();
    }, 300)
);

function updateFilters() {
    router.get(
        "/",
        {
            search: filters.search,
            tier: filters.tiers.selected,
            type: filters.types.selected,
            level: filters.level,
            misc: filters.misc.selected,
        },
        { preserveState: true, replace: true }
    );
}
</script>
