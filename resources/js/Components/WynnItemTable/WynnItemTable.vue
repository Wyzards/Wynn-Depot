<template>
    <table
        @showItemImage="console.log('SHOWING!!')"
        class="border border-black m-10"
    >
        <thead>
            <tr>
                <ColumnHeading>Item Name</ColumnHeading>
                <ColumnHeading>Level</ColumnHeading>
                <ColumnHeading>Type</ColumnHeading>
                <ColumnHeading>Tier</ColumnHeading>
                <ColumnHeading>Percent</ColumnHeading>
                <ColumnHeading>Image</ColumnHeading>
            </tr>
        </thead>

        <ItemRow v-for="item in items.data" :key="item.id" :item="item" />
    </table>
</template>

<script setup>
import ColumnHeading from "./ColumnHeading.vue";
import ItemRow from "./ItemRow.vue";

defineProps({
    items: Object,
});
</script>
