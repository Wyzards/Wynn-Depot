<template>
    <tr>
        <td class="border border-black">{{ item.name }}</td>
        <td class="border border-black">{{ item.level }}</td>
        <td class="border border-black">{{ item.type }}</td>
        <td class="border border-black">{{ item.tier }}</td>
        <td class="border border-black">{{ item.restrictions }}</td>
        <Editable :errors="itemForm.errors.percent" v-model="percent" />
        <Editable :errors="itemForm.errors.storage" v-model="storage" />
        <Editable :errors="itemForm.errors.notes" v-model="notes" />

        <ScreenshotManager
            @update="setScreenshot"
            :imagePath="item.image"
            :errors="itemForm.errors.screenshot"
        />
    </tr>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { watch, ref } from "vue";
import ScreenshotManager from "./ScreenshotManager.vue";
import debounce from "lodash/debounce";
import Editable from "./Editable.vue";

const props = defineProps({
    item: Object,
});

const itemForm = useForm({
    percent: props.item.percent,
    id: props.item.id,
    screenshot: undefined,
    storage: props.item.storage,
    notes: props.item.notes,
});

const updateItem = debounce(function (values) {
    itemForm.post(`items/${itemForm.id}`);
}, 300);

function setScreenshot(screenshot) {
    itemForm.screenshot = screenshot;
    updateItem();
}

const percent = ref(itemForm.percent);
const storage = ref(itemForm.storage);
const notes = ref(itemForm.notes);

watch(
    [percent, storage, notes],
    debounce(() => {
        itemForm.percent = percent;
        itemForm.storage = storage;
        itemForm.notes = notes;

        updateItem();
    }, 300)
);
</script>
