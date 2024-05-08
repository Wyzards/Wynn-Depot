<template>
    <table class="m-10 border border-black">
        <thead>
            <tr>
                <Heading>Item Name</Heading>
                <Heading>Level</Heading>
                <Heading>Type</Heading>
                <Heading>Tier</Heading>
                <Heading>Restrictions</Heading>
                <Heading>Percent</Heading>
                <Heading>Storage</Heading>
                <Heading>Notes</Heading>
                <Heading>Image</Heading>
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
