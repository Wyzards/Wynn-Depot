<template>
    <td class="border border-black w-fit">
        <input v-show="isAuthenticated" v-model="model" />
        <p v-show="!isAuthenticated" v-text="model" />
        <p v-if="errors" v-text="errors" class="text-red-500" />
    </td>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const model = defineModel();

defineProps({
    errors: String,
});

const isAuthenticated = computed(() => !!usePage().props.auth.user);
</script>
