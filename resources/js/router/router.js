import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: '/',
        component: () => import('../Pages/Adverts.vue')
    },
    {
        path: '/advert/:id',
        component: () => import('../Pages/Advert.vue')
    },
    {
        path: '/advert/add',
        component: () => import('../Pages/Form.vue')
    }
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
