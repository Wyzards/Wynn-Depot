import { defineStore } from "pinia";
import { router } from "@inertiajs/vue3";

export let useItemFilterStore = defineStore("itemFilter", {
    state() {
        if (localStorage.getItem("itemFilter")) {
            return JSON.parse(localStorage.getItem("itemFilter"));
        } else
            return {
                search: "",
                tiers: {
                    options: [
                        "common",
                        "unique",
                        "rare",
                        "legendary",
                        "fabled",
                        "mythic",
                        "set",
                    ],
                    selected: [],
                },
                types: {
                    options: [
                        "helmet",
                        "chestplate",
                        "leggings",
                        "boots",
                        "necklace",
                        "bracelet",
                        "ring",
                        "relik",
                        "wand",
                        "spear",
                        "dagger",
                        "bow",
                    ],
                    selected: [],
                },
                level: {
                    min: 0,
                    max: 105,
                },
                misc: {
                    options: ["owned", "not owned", "untradable", "quest item"],
                    selected: [],
                },
                storage: {
                    selected: [],
                },
                sortBy: "name",
                sortDirection: "asc",
            };
    },

    actions: {
        update() {
            router.get(
                "/",
                {
                    search: this.search.length > 0 ? this.search : undefined,
                    tier: this.tiers.selected,
                    type: this.types.selected,
                    minLevel: this.level.min != 0 ? this.level.min : undefined,
                    maxLevel: this.level.max < 105 ? this.level.max : undefined,
                    misc: this.misc.selected,
                    storage: this.storage.selected,
                    sortBy: this.sortBy != "name" ? this.sortBy : undefined,
                    sortDirection: this.sortDirection,
                },
                { preserveState: true, replace: true }
            );
        },

        clear() {
            this.search = "";
            this.tiers.selected = [];
            this.types.selected = [];
            this.level.min = 0;
            this.level.max = 105;
            this.misc.selected = [];
            this.storage.selected = [];
            this.sortBy = "name";
            this.sortDirection = "asc";
            this.update();
        },
    },
});
