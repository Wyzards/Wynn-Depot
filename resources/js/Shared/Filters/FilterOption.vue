<template>
    <div class="flex p-1 hover:bg-gray-300">
        <slot />
    </div>
</template>

<script setup>
defineProps({
    active: {
        type: Boolean,
        default: false,
    },
});
</script>
