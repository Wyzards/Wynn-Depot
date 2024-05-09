<template>
    <Dropdown :closeOnClick="false">
        <template #trigger>
            <PrimaryButton>
                Level
                {{
                    minLevel > 0 || maxLevel < 105
                        ? `(${minLevel}-${maxLevel})`
                        : ""
                }}
            </PrimaryButton>
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
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Dropdown from "../../Components/Dropdown.vue";

const minLevel = defineModel("minLevel");
const maxLevel = defineModel("maxLevel");
</script>
