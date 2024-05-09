<template>
    <Dropdown :closeOnClick="false">
        <template #trigger>
            <PrimaryButton :disabled="!hasOptions">
                <slot /> {{ selected.length > 0 ? `(${selected.length})` : "" }}
            </PrimaryButton>
        </template>

        <template #content>
            <div
                v-for="option in options"
                @click="clickFilter(option)"
                :class="{
                    'block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out': true,
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
import PrimaryButton from "@/Components/PrimaryButton.vue";
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
