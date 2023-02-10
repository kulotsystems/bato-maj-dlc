import { createRouter, createWebHistory } from 'vue-router';

export default createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'login',
            component: () => import('../views/Login.vue'),
            meta: {
                title: 'Login'
            }
        },
        {
            path: '/admin',
            name: 'admin',
            component: () => import('../views/Admin.vue'),
            meta: {
                title: 'Admin'
            }
        },
        {
            path: '/judge',
            name: 'judge',
            component: () => import('../views/Judge.vue'),
            meta: {
                title: 'Judge'
            }
        },
        {
            path: '/technical',
            name: 'technical',
            component: () => import('../views/Technical.vue'),
            meta: {
                title: 'Technical'
            }
        }
    ]
});