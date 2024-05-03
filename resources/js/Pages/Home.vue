<template>
    <div>
        <Head title="Home" />

        <main class="flex items-center bg-blue-300 flex-col min-h-screen">
            <h1 class="text-8xl">WynnDepot.</h1>

            <ItemModal :itemImagePath="modalItemId" />

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
                        <FilterDropdown
                            :options="[
                                'Normal',
                                'Unique',
                                'Rare',
                                'Legendary',
                                'Fabled',
                                'Mythic',
                                'Set',
                            ]"
                        >
                            Tier
                        </FilterDropdown>
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
                        <FilterDropdown
                            :options="[
                                'Owned',
                                'Not Owned',
                                'Untradeable',
                                'Quest Item',
                            ]"
                        >
                            Misc
                        </FilterDropdown>
                    </div>
                </div>
            </div>

            <WynnItemTable :items="items" />

            <Pagination :links="items.links" />
        </main>
    </div>
</template>

<script setup>
import WynnItemTable from "../Components/WynnItemTable/WynnItemTable.vue";
import FilterDropdown from "../Components/WynnItemTable/FilterDropdown.vue";
import Pagination from "../Components/Pagination.vue";
import ItemModal from "../Components/WynnItemTable/ItemModal.vue";
import debounce from "lodash/debounce";
import { ref, watch } from "vue";

let props = defineProps({
    items: Object,
    filters: Object,
});

let search = ref(props.filters.search);

watch(
    search,
    debounce(function (value) {
        router.get(
            "/items",
            { search: value },
            { preserveState: true, replace: true }
        );
    }, 300)
);
</script>
