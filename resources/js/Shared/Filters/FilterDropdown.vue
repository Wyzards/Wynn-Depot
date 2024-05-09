<template>
    <Dropdown :closeOnClick="false">
        <template #trigger>
            <button
                :class="{
                    'px-2 text-sm text-white border border-black rounded-lg h-7': true,
                    'bg-blue-500': hasOptions,
                    'bg-gray-600': !hasOptions,
                }"
                :disabled="!hasOptions"
            >
                <slot /> {{ selected.length > 0 ? `(${selected.length})` : "" }}
            </button>
        </template>

        <template #content>
            <div
                v-for="option in options"
                @click="clickFilter(option)"
                :class="{
                    'hover:bg-gray-300': !selected.includes(option),
                    'bg-blue-300': selected.includes(option),
                }"
            >
                {{ option }}
            </div>
        </template>
    </Dropdown>
</template>

<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import { computed } from "vue";

const props = defineProps({
    selected: Array,
    options: Array,
});

const emit = defineEmits(["selectFilter"]);
const hasOptions = computed(() => props.options.length > 0);

function clickFilter(filterOption) {
    if (props.selected.includes(filterOption)) {
        props.selected.splice(props.selected.indexOf(filterOption));
    } else {
        props.selected.push(filterOption);
    }

    emit("selectFilter", props.selected);
}
</script>
