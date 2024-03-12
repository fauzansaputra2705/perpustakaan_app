import './bootstrap'
import 'datatables.net-bs5'
import 'vue-toastification/dist/index.css'

//bootstrap bundle
import './asset/js/bootstrap.bundle.min'

//select2
import './asset/select2/select2-bootstrap-5-theme.min.css'
import './asset/select2/select2.min.css'
import './asset/select2/select2.min'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import Toast from 'vue-toastification'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        /* eslint-disable */
        let app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Toast, {
                transition: 'Vue-Toastification__bounce',
                maxToasts: 20,
                newestOnTop: true,
            })

        app.config.globalProperties.iRoute = (v) => route(v)
        return app.mount(el)
    },
    progress: {
        color: '#4B5563',
    },
})
