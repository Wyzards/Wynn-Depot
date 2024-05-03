<template>
    <div class="flex justify-between mt-10">
        <input
            v-model="search"
            id="searchbar"
            type="text"
            placeholder="Search for items..."
        />

        <div class="ml-2">
            <p class="text-xl">Filters</p>

            <div class="flex gap-2">
                <TierFilter />
            </div>
        </div>
    </div>
</template>

<script setup>
import debounce from "lodash/debounce";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import TierFilter from "./TierFilter.vue";

const props = defineProps({
    filters: Object,
});

let search = ref(props.filters.search);

watch(
    search,
    debounce(function (value) {
        router.get(
            "/",
            { search: value },
            { preserveState: true, replace: true }
        );
    }, 300)
);
</script>
