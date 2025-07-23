import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import nProgress from 'nprogress';
import { router } from '@inertiajs/vue3';
import '../css/app.css';


createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
   const app=createApp({ render: () => h(App, props) })
      app.use(plugin)
      app.component('EasyDataTable', Vue3EasyDataTable);
      app.mount(el)
  },
})

router.on('start', () => {
  nProgress.start()
})
router.on('finish', () => {
  nProgress.done()
})
