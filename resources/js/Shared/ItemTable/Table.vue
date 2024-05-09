<template>
    <table class="m-10 border border-black">
        <thead>
            <tr>
                <Heading sortKey="name">Item Name</Heading>
                <Heading sortKey="level">Level</Heading>
                <Heading sortKey="type">Type</Heading>
                <Heading sortKey="tier">Tier</Heading>
                <Heading sortKey="restrictions">Restrictions</Heading>
                <Heading sortKey="percent">Percent</Heading>
                <Heading sortKey="storage">Storage</Heading>
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
