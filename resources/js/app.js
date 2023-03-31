// resources/js/app.js
import './bootstrap';
import '../css/app.css';
import { createInertiaApp } from '@inertiajs/svelte';
import Layout from './Components/Layout/Layout.svelte';

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true });
    let page = pages[`./Pages/${name}.svelte`];

    const isWelcomePage = name === 'Welcome';

    return isWelcomePage
      ? { default: page.default }
      : { default: page.default, layout: page.layout || Layout };
  },
  setup({ el, App, props }) {
    new App({ target: el, props });
  },
});
