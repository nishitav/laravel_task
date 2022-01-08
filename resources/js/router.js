
import Router from 'vue-router'
import Vue from 'vue'
Vue.use(Router)
import products from './admin/pages/products'
import login from './admin/pages/login'
import notfound from './admin/pages/notfound'
import resetPassword from './admin/pages/resetPassword'
import doResetPassword from './admin/pages/doResetPassword'

const routes = [
    {
        path: '/',
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
    {
        path: '/resetPassword',
        component: resetPassword,
        name: 'resetPassword'
    },
    {
        path: '/doResetPassword',
        component: doResetPassword,
        name: 'doResetPassword'
    },
]

export default new Router({
    mode: 'history',
    routes

})
