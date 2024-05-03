<template>
    <th class="border border-black"><slot /></th>
</template>

<script setup>
defineProps({
    items: Object,
});
</script>
