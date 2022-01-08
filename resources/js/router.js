
import Router from 'vue-router'
import Vue from 'vue'
Vue.use(Router)
import products from './admin/pages/products'
import login from './admin/pages/login'
import notfound from './admin/pages/notfound'

const routes = [
    {
        path: '/products',
        component: products,
        name: 'products'
    },
    {
        path: '*',
        component: notfound,
        name: 'notfound'
    },
    {
        path: '/login',
        component: login,
        name: 'login'
    },
]

export default new Router({
    mode: 'history',
    routes

})
