<template>
    <tr>
        <td class="border border-gray-300">
            <p class="p-1" :class="item.tier">{{ item.name }}</p>
        </td>
        <td class="border border-gray-300">
            <p class="p-1">{{ item.level }}</p>
        </td>
        <Editable
            :errors="itemForm.errors.storage"
            v-model="storage"
            width="w-30"
        />
        <Editable :errors="itemForm.errors.percent" v-model="percent" />
        <td class="border border-gray-300 h-28">
            <textarea
                style="width: 500px"
                v-if="isAuthenticated"
                v-model="notes"
                class="text-gray-300 bg-gray-950 h-full m-0 mt-1.5 overflow-hidden border"
            />
            <p v-else class="p-1" v-text="notes" />
            <p
                v-if="itemForm.errors.notes"
                v-text="itemForm.errors.notes"
                class="text-red-500"
            />
        </td>

        <ScreenshotManager
            @update="setScreenshot"
            :itemId="item.id"
            :imagePath="item.image"
            :errors="itemForm.errors.screenshot"
        />
    </tr>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { watch, ref, computed } from "vue";
import ScreenshotManager from "./ScreenshotManager.vue";
import debounce from "lodash/debounce";
import Editable from "./Editable.vue";

const props = defineProps({
    item: Object,
});

const isAuthenticated = computed(() => !!usePage().props.auth.user);

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
