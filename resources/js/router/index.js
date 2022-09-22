import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../views/Home.vue'),
        meta: {
            auth: true,
        }
    },
    {
        path: '/dashboard',
        name: 'Dash',
        component: () => import('../views/Dashboard.vue'),
        meta: {
            auth: true,
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('../views/Login.vue'),
    },
    {
        path: '/registration',
        name: 'Register',
        component: () => import('../views/Register.vue'),
    },
    {
        path: '/reset',
        name: 'Reset',
        component: () => import('../views/Reset.vue'),
    },
    {
        path: '/reset-password/:token',
        name: 'Reset-password',
        component: () => import('../views/ResetPassword.vue')
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'active',
    linkExactActiveClass: 'active',
});

router.beforeEach((to, from, next) => {
    const requireAuth = to.meta.auth;

    const token = localStorage.getItem('x_xsrf_token');

    if(requireAuth && token) {
        next();
    } else if (requireAuth && !token) {
        next('/login?message=auth');
    } else {
        next();
    }
});


export default router;
