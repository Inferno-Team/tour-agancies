
import Home from './layouts/Home.vue'
import Login from './layouts/Login.vue'
export const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },

];