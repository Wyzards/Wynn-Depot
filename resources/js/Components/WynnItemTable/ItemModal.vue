<template>
    <Modal @close="itemImage.show = false" :show="itemImage.show">
        <img :src="itemImage.path" alt="Item" />
    </Modal>
</template>

<script setup>
import { useItemImageStore } from "/stores/ItemImageStore.js";
import Modal from "../Modal.vue";

let itemImage = useItemImageStore();

defineProps({
    itemImagePath: String,
});
</script>
