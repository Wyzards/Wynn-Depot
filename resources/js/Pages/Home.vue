<template>
    <div>
        <Head title="Home" />

        <main class="flex flex-col items-center min-h-screen bg-blue-300">
            <button
                v-if="auth"
                class="p-2 mt-2 mr-4 bg-gray-300 border border-black ms-auto tx-lg rounded-xl"
            >
                <Link href="/logout" method="post">Log Out</Link>
            </button>

            <button
                v-else
                class="p-2 mt-2 mr-4 bg-gray-300 border border-black ms-auto tx-lg rounded-xl"
            >
                <Link href="/login">Log In</Link>
            </button>
            <h1 class="mb-8 text-8xl">WynnDepot.</h1>
            <Modal />

            <Filters :storageOptions="storageOptions" />

            <Table :items="items" />

            <Pagination :links="items.links" />
        </main>
    </div>
</template>

<script setup>
import Table from "../Shared/ItemTable/Table.vue";
import Pagination from "../Shared/Pagination.vue";
import Modal from "../Shared/ItemTable/Modal.vue";
import Filters from "../Shared/Filters/Filters.vue";
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    items: Object,
    storageOptions: Array,
});

let auth = computed(() => {
    return !!usePage().props.auth.user;
});
</script>
