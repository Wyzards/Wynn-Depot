<script setup>
defineProps({
    links: Object,
});
</script>

<template>
    <div class="flex gap-2 mb-6">
        <Component
            :is="link.url ? 'Link' : 'span'"
            :key="link.label"
            v-for="link in links"
            :href="link.url"
            class="px-1"
            :class="{
                'text-gray-800': !link.url,
                'font-bold': link.active,
            }"
            preserve-scroll
        >
            <span v-html="link.label" />
        </Component>
    </div>
</template>
