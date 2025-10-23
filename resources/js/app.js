import './bootstrap';


import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
// Vuetify
import 'vuetify/styles'
import {createVuetify} from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
// Option B — Install via unplugin-fonts + @fontsource (recommended)
import 'unfonts.css'
import DefaultLayout from "@/Layout/DefaultLayout.vue";
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader
import {aliases, mdi} from 'vuetify/iconsets/mdi'
import {fa} from 'vuetify/iconsets/fa'

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
            fa,
        },
    },
    theme: {
        defaultTheme: 'light', // 'light' | 'dark' | 'system'
    },
    // ssr: true,
})
// End Vuetify
// Toastify
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
