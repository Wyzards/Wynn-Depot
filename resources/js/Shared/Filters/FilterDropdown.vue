<template>
    <Dropdown :closeOnClick="false">
        <template #trigger>
            <button
                class="px-2 text-sm text-white bg-blue-500 border border-black rounded-lg h-7"
            >
                <slot />
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

const props = defineProps({
    selected: Array,
    options: Array,
});

const emit = defineEmits(["selectFilter"]);

function clickFilter(filterOption) {
    if (props.selected.includes(filterOption)) {
        props.selected.splice(props.selected.indexOf(filterOption));
    } else {
        props.selected.push(filterOption);
    }

    emit("selectFilter", props.selected);
}
</script>
