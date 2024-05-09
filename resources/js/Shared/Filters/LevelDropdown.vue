<template>
    <Dropdown :closeOnClick="false">
        <template #trigger>
            <button
                class="px-2 text-sm text-white bg-blue-500 border border-black rounded-lg h-7"
            >
                Level
                {{
                    minLevel > 0 || maxLevel < 105
                        ? `(${minLevel}-${maxLevel})`
                        : ""
                }}
            </button>
        </template>

        <template #content>
            <div class="flex justify-evenly">
                <input
                    v-model="minLevel"
                    type="text"
                    placeholder="0"
                    class="w-14"
                />
                <input
                    v-model="maxLevel"
                    type="text"
                    placeholder="105"
                    class="w-14"
                />
            </div>
        </template>
    </Dropdown>
</template>

<script setup>
import Dropdown from "../../Components/Dropdown.vue";

const minLevel = defineModel("minLevel");
const maxLevel = defineModel("maxLevel");
</script>
