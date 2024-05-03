import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { createPinia } from "pinia";

const appName = import.meta.env.VITE_APP_NAME || "Wynn Depot";

createInertiaApp({
    title: (title) => `Wynn Depot - ${title}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const pinia = createPinia();
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia)
            .component("Head", Head)
            .component("Link", Link)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});