import { defineStore } from "pinia";

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
            };
    },
});
