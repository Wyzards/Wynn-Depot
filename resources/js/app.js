import "./bootstrap";
import "../css/app.css";

import { createApp, h, watch } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { createPinia } from "pinia";

const appName = import.meta.env.VITE_APP_NAME || "Wynn Depot";

createInertiaApp({
    title: (title) => `${appName} - ${title}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const pinia = createPinia();

        watch(
            pinia.state,
            (state) => {
                localStorage.setItem(
                    "itemFilter",
                    JSON.stringify(state.itemFilter)
                );
            },
            { deep: true }
        );

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component("Head", Head)
            .component("Link", Link)
            .use(pinia)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
