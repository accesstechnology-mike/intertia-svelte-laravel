import { Inertia } from "@inertiajs/inertia-svelte";

export function initializeAnalytics(trackingId) {
    window.gtag =
        window.gtag ||
        function () {
            (window.dataLayer = window.dataLayer || []).push(arguments);
        };
    gtag("js", new Date());
    gtag("config", trackingId);

    Inertia.on("navigate", () => {
        gtag("config", trackingId, {
            page_path: window.location.pathname,
        });
    });
}
