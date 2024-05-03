<template>
    <div>
        <Head title="Home" />

        <main class="flex items-center bg-blue-300 flex-col min-h-screen">
            <h1 class="text-8xl">WynnDepot.</h1>

            <ItemModal />

            <Filters :filters="filters" />

            <WynnItemTable :items="items" />

            <Pagination :links="items.links" />
        </main>
    </div>
</template>

<script setup>
import WynnItemTable from "../Shared/ItemTable/WynnItemTable.vue";
import Pagination from "../Shared/Pagination.vue";
import ItemModal from "../Shared/ItemTable/ItemModal.vue";
import Filters from "@/Shared/Filters/Filters.vue";

let props = defineProps({
    items: Object,
    filters: Object,
});
</script>
