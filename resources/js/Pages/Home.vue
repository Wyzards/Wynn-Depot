<template>
    <Head title="Home" />

    <main class="flex items-center bg-blue-300 flex-col">
        <h1 class="text-8xl">WynnDepot.</h1>

        <div class="flex justify-between mt-10">
            <input
                id="searchbar"
                type="text"
                placeholder="Search for items..."
            />

            <div class="ml-2">
                <p class="text-xl">Filters</p>

                <div class="flex gap-3">
                    <button>Tier</button>
                    <button>Type</button>
                    <button>Level</button>
                    <button>Misc</button>
                </div>
            </div>
        </div>

        <table class="border border-black m-10">
            <thead>
                <tr>
                    <th class="border border-black">Item Name</th>
                    <th class="border border-black">Level</th>
                    <th class="border border-black">Type</th>
                    <th class="border border-black">Tier</th>
                    <th class="border border-black">Image</th>
                </tr>
            </thead>

            <tr v-for="item in items" :key="item.id">
                <td class="border border-black">{{ item.name }}</td>
                <td class="border border-black">{{ item.level }}</td>
                <td class="border border-black">{{ item.type }}</td>
                <td class="border border-black">{{ item.tier }}</td>
                <td class="border border-black">
                    <input type="file" />
                </td>
            </tr>
        </table>
    </main>
</template>

<script setup>
defineProps({
    items: Array,
});
</script>
