import { defineStore } from "pinia";

export let useItemImageStore = defineStore("itemImage", {
    state() {
        return {
            path: "",
            show: false,
        };
    },
});
