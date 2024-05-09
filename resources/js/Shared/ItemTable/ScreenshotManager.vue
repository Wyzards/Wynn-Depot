<template>
    <td class="border border-gray-300">
        <div class="flex items-center" v-if="!hasScreenshot && isAuthenticated">
            <input
                :id="'upload.' + itemId"
                type="file"
                class="hidden"
                @change="handleFileChange"
            />
            <label :for="'upload.' + itemId">
                <p
                    class="px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out border border-transparent rounded-md hover:cursor-pointer bg-sky-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Upload
                </p>
            </label>
        </div>

        <div class="flex flex-col">
            <PrimaryButton v-if="hasScreenshot" @click="showImage">
                Show
            </PrimaryButton>

            <PrimaryButton
                v-if="hasScreenshot && isAuthenticated"
                @click="removeImage"
            >
                Remove
            </PrimaryButton>
        </div>
        <p v-if="errors" v-text="errors" class="text-red-500" />
    </td>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { useItemImageStore } from "/stores/ItemImageStore.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    itemId: Number,
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
