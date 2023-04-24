// resources/js/app.js
import "./bootstrap";
import "../css/app.css";
import { createInertiaApp } from "@inertiajs/svelte";
import Layout from "./Components/Layout/Layout.svelte";

import { initializeAnalytics } from "./analytics";

// Replace with your Google Analytics tracking code
const GA_TRACKING_CODE = "G-XQREYN1QYP";

initializeAnalytics(GA_TRACKING_CODE);

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob("./Pages/**/*.svelte");

        const importPage = pages[`./Pages/${name}.svelte`];

        if (!importPage) {
            throw new Error(`Page not found: ${name}`);
        }

        const page = await importPage();

        const isWelcomePage = name === "Welcome";

        return isWelcomePage
            ? { default: page.default }
            : { default: page.default, layout: page.layout || Layout };
    },
    setup({ el, App, props }) {
        new App({ target: el, props });
    },
});
