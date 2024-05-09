<template>
    <table class="m-10 text-gray-300 border border-gray-300">
        <thead>
            <tr>
                <Heading sortKey="name">Item Name</Heading>
                <Heading sortKey="level">Level</Heading>
                <Heading sortKey="storage">Storage</Heading>
                <Heading sortKey="percent">Percent</Heading>
                <Heading sortKey="notes">Notes</Heading>
                <Heading :sortable="false">Image</Heading>
            </tr>
        </thead>

        <Row v-for="item in items.data" :key="item.id" :item="item" />
    </table>
</template>

<script setup>
import Heading from "./Heading.vue";
import Row from "./Row.vue";

defineProps({
    items: Object,
});
</script>
