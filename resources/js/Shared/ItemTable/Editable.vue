<template>
    <td class="border border-black">
        <p :contenteditable="!!usePage().props.auth.user" @input="callback">
            <slot />
        </p>
        <p v-if="errors" v-text="errors" class="text-red-500" />
    </td>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";

defineProps({
    errors: String,
    callback: Function,
});
</script>
