<template>
    <td class="border border-gray-300 h-28">
        <input :class="width" class="h-full text-center text-gray-300 bg-gray-950" v-show="isAuthenticated" v-model="model" />
        <p v-show="!isAuthenticated" v-text="model" class="p-1" />
        <p v-if="errors" v-text="errors" class="text-red-500" />
    </td>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const model = defineModel();

defineProps({
    errors: String,
    width: {
        type: String,
        default: "w-20",
    },
});

const isAuthenticated = computed(() => !!usePage().props.auth.user);
</script>
