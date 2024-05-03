<template>
    <tr>
        <td class="border border-black">{{ item.name }}</td>
        <td class="border border-black">{{ item.level }}</td>
        <td class="border border-black">{{ item.type }}</td>
        <td class="border border-black">{{ item.tier }}</td>
        <td class="border border-black">{{ item.percent }}</td>
        <td class="border border-black">
            <input type="file" v-if="!item.image" @change="handleFileChange" />

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
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import { useItemImageStore } from "../../../../stores/ItemImageStore.js";

const props = defineProps({
    item: Object,
});

let itemImage = useItemImageStore();

const form = useForm({
    item_id: null,
    item_image: null,
});

function handleFileChange(event) {
    form.item_image = event.target.files[0];
    form.item_id = props.item.id;
    form.post("/items");
}

function showImage() {
    itemImage.path = "/storage/" + props.item.image;
    itemImage.show = true;
}

function removeImage() {
    form.item_id = props.item.id;
    form.item_image = null;
    form.post("/items");
}
</script>
