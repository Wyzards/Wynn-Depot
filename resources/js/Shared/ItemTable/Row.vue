<template>
    <tr>
        <td class="border border-black">{{ item.name }}</td>
        <td class="border border-black">{{ item.level }}</td>
        <td class="border border-black">{{ item.type }}</td>
        <td class="border border-black">{{ item.tier }}</td>
        <td class="border border-black">{{ item.restrictions }}</td>
        <td
            class="border border-black"
            :contenteditable="!!usePage().props.auth.user"
            @input="editStorage"
        >
            {{ item.storage }}
            <p
                v-if="itemForm.errors.percent"
                v-text="itemForm.errors.percent"
                class="text-red-500"
            />
        </td>

        <td
            class="border border-black"
            :contenteditable="!!usePage().props.auth.user"
            @input="editPercent"
        >
            {{ item.percent }}
            <p
                v-if="itemForm.errors.percent"
                v-text="itemForm.errors.percent"
                class="text-red-500"
            />
        </td>

        <td class="border border-black">
            <input type="file" v-if="!item.image" @change="handleFileChange" />
            <p
                v-if="itemForm.errors.screenshot"
                v-text="itemForm.errors.screenshot"
                class="text-red-500"
            />
            <PrimaryButton v-if="item.image" @click="showImage">
                Show Image
            </PrimaryButton>

            <PrimaryButton v-if="item.image" @click="removeImage">
                Remove Image
            </PrimaryButton>
        </td>
    </tr>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import { useItemImageStore } from "../../../../stores/ItemImageStore.js";

const props = defineProps({
    item: Object,
});

let itemImage = useItemImageStore();

function showImage() {
    itemImage.path = "/storage/" + props.item.image;
    itemImage.show = true;
}

const itemForm = useForm({
    percent: props.item.percent,
    id: props.item.id,
    screenshot: undefined,
});

function updateItem() {
    itemForm.post(`items/${itemForm.id}`);
}

function editPercent(event) {
    itemForm.percent = event.target.innerText;

    updateItem();
}

function handleFileChange(event) {
    itemForm.screenshot = event.target.files[0];
    updateItem();
}

function removeImage() {
    itemForm.screenshot = null;
    updateItem();
}
</script>
