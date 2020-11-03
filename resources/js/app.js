require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import ProductsList from './components/products/ProductsList.vue';
import ProductCreate from './components/products/ProductCreate.vue';
import ProductEdit from './components/products/ProductEdit.vue';

/*Here are our routes where the index will redirect us to the products index page*/
const routes = [
    {
        path: '/',
        components: {
            productsList: ProductsList
        }
    },
    {path: '/admin/products/create', component: ProductCreate, name: 'create-product'},
    {path: '/admin/products/edit/:id', component: ProductEdit, name: 'edit-product'},
]

const router = new VueRouter({ routes })

const app = new Vue({ router }).$mount('#app')