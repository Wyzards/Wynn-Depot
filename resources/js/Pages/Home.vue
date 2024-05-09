<template>
    <div>
        <Head title="Home" />

        <main class="flex flex-col items-center min-h-screen bg-gray-950">
            <PrimaryButton v-if="auth" class="mt-2 mr-4 ms-auto">
                <Link href="/logout" method="post">Log Out</Link>
            </PrimaryButton>

            <PrimaryButton v-else class="mt-2 mr-4 ms-auto">
                <Link href="/login">Log In</Link>
            </PrimaryButton>
            <h1 class="mb-8 text-white font-pixelify text-9xl">WynnDepot.</h1>
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
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    items: Object,
    storageOptions: Array,
});

let auth = computed(() => {
    return !!usePage().props.auth.user;
});
</script>
