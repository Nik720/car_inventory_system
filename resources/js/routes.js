import Vue from 'vue'
import VueRouter from 'vue-router'

import Manufacturer from './components/Manufacturer'
import CarModel from './components/CarModel'
import Inventories from './components/Inventories'

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'manufacturer',
            component: Manufacturer
        },
        {
            path: '/car-model',
            name: 'car-model',
            component: CarModel
        },
        {
            path: '/inventories',
            name: 'inventories',
            component: Inventories
        }
    ],
});

export default router;