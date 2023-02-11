import { createRouter, createWebHistory, NavigationGuardNext, RouteLocationNormalized } from 'vue-router';
import { useAuthStore } from '../store/store-auth';
import { usePortionStore } from '../store/store-portion';
import { isPortionKeyType } from '../types/Portion.type';

const requireAuth = (to: RouteLocationNormalized, from: RouteLocationNormalized, next: NavigationGuardNext) => {
    const authStore = useAuthStore();
    const portionStore = usePortionStore();

    // get user
    const user = authStore.user;

    // set active portion from route
    if(isPortionKeyType(to.params.portion)) {
        portionStore.setActivePortion(to.params.portion);
    }

    if (user) {
        if (user.userType === to.name) {
            next();
        }
        else {
            next({
                name: user.userType,
                params: {
                    portion: portionStore.activePortion
                }
            });
        }
    }
    else {
        next({ name: 'sign-in' });
    }
};

export default createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'sign-in',
            component: () => import('../views/SignIn.vue'),
            meta: {
                title: 'Sign in'
            },
            beforeEnter: (to, from, next) => {
                const authStore = useAuthStore();
                const user = authStore.user;
                if (!user) {
                    next();
                } else {
                    next({ name: user.userType });
                }
            }
        },
        {
            path: '/admin/:portion',
            name: 'admin',
            component: () => import('../views/Admin.vue'),
            meta: {
                title: 'Admin',
                requiresAuth: true
            },
            beforeEnter: requireAuth
        },
        {
            path: '/judge/:portion',
            name: 'judge',
            component: () => import('../views/Judge.vue'),
            meta: {
                title: 'Judge',
                requiresAuth: true
            },
            beforeEnter: requireAuth
        },
        {
            path: '/technical/:portion',
            name: 'technical',
            component: () => import('../views/Technical.vue'),
            meta: {
                title: 'Technical Judge'
            },
            beforeEnter: requireAuth
        },
        {
            path: '/:catchAll(.*)',
            redirect: { name: 'sign-in' }
        }
    ]
});
