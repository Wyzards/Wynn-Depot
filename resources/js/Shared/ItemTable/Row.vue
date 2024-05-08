<template>
    <tr>
        <td class="border border-black">{{ item.name }}</td>
        <td class="border border-black">{{ item.level }}</td>
        <td class="border border-black">{{ item.type }}</td>
        <td class="border border-black">{{ item.tier }}</td>
        <td class="border border-black">{{ item.restrictions }}</td>
        <Editable :callback="editPercent" :errors="itemForm.errors.percent">
            {{ item.percent }}
        </Editable>
        <Editable :callback="editStorage" :errors="itemForm.errors.storage">
            {{ item.storage }}
        </Editable>
        <Editable :callback="editNotes" :errors="itemForm.errors.notes">
            {{ item.notes }}
        </Editable>

        <ScreenshotManager
            @update="setScreenshot"
            :imagePath="item.image"
            :errors="itemForm.errors.screenshot"
        />
    </tr>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Editable from "./Editable.vue";
import ScreenshotManager from "./ScreenshotManager.vue";
import debounce from "lodash/debounce";

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

function editPercent(event) {
    itemForm.percent = event.target.innerText;
    updateItem();
}

function editStorage(event) {
    itemForm.storage = event.target.innerText;
    updateItem();
}

function editNotes(event) {
    itemForm.notes = event.target.innerText;
    updateItem();
}

function setScreenshot(screenshot) {
    itemForm.screenshot = screenshot;
    updateItem();
}
</script>
