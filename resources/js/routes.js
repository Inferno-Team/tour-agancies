import Home from './layouts/Home.vue'
import Login from './layouts/Login.vue'
import TourLayout from './layouts/TourLayout.vue'
import TourTimeLine from './layouts/TourTimeLine.vue'
export const routes = [{
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/tours',
        name: 'tours',
        component: TourLayout
    },
    {
        path: '/tour-time-line/:id',
        name: 'tour-time-line',
        component: TourTimeLine,
        props: true,
    },

];