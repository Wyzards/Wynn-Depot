<template>
    <td class="border border-black">
        <input
            type="file"
            v-if="!hasScreenshot && isAuthenticated"
            @change="handleFileChange"
        />
        <p v-if="errors" v-text="errors" class="text-red-500" />
        <PrimaryButton v-if="hasScreenshot" @click="showImage">
            Show Image
        </PrimaryButton>

        <PrimaryButton
            v-if="hasScreenshot && isAuthenticated"
            @click="removeImage"
        >
            Remove Image
        </PrimaryButton>
    </td>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { useItemImageStore } from "/stores/ItemImageStore.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    imagePath: String,
    errors: String,
});
const emit = defineEmits(["update"]);
const itemImage = useItemImageStore();
const hasScreenshot = computed(() => props.imagePath != null);
const isAuthenticated = computed(() => !!usePage().props.auth.user);

function showImage() {
    itemImage.path = "/storage/" + props.imagePath;
    itemImage.show = true;
}

function handleFileChange(event) {
    emit("update", event.target.files[0]);
}

function removeImage() {
    emit("update", null);
}
</script>
