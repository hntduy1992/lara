import './bootstrap';


import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';

// Vuetify
import 'vuetify/styles'
import {createVuetify} from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader
// Option B — Install via unplugin-fonts + @fontsource (recommended)
import 'unfonts.css'
import AuthLayout from "@/Layout/AuthLayout.vue";
import DefaultLayout from "@/Layout/DefaultLayout.vue";

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi', // This is already the default value - only for display purposes
    },
    theme: {
        defaultTheme: 'light', // 'light' | 'dark' | 'system'
    },
    // ssr: true,
})
// End Vuetify
// Toastifu
import Vue3Toastify from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
// End Toastify

createInertiaApp({
    resolve: async (name) => {
        const pageModule = await resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        );
        const page = pageModule.default;
        if (page.layout !== undefined) {
            return pageModule;
        }
        page.layout = DefaultLayout
        return page
    },
    setup({el, App, props, plugin}) {
        const app = createApp({render: () => h(App, props)})
        app.use(plugin)
        app.use(vuetify)
        app.use(Vue3Toastify, {
            autoClose: 2000
        })
        app.mount(el)
    },
})
