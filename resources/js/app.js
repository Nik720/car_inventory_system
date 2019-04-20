
import './bootstrap'
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Route information
import Routes from './routes.js'

import App from './views/App'

Vue.use(BootstrapVue)

const app = new Vue({
    el: '#app',
    router: Routes,
    render: h => h(App)
});

export default app;
