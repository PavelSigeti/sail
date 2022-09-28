export default [
    {
        path: '/',
        name: 'Home',
        component: () => import('../views/Home.vue'),
        meta: {
            auth: false,
            layout: 'HomePage',
        }
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import('../views/Dashboard.vue'),
        meta: {
            auth: true,
            layout: 'Dashboard',
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('../views/Login.vue'),
        meta: {
            layout: 'Auth',
        }
    },
    {
        path: '/registration',
        name: 'Register',
        component: () => import('../views/Register.vue'),
        meta: {
            layout: 'Auth',
        }
    },
    {
        path: '/reset',
        name: 'Reset',
        component: () => import('../views/Reset.vue'),
        meta: {
            layout: 'Auth',
        }
    },
    {
        path: '/reset-password/:token',
        name: 'Reset-password',
        component: () => import('../views/ResetPassword.vue'),
        meta: {
            layout: 'Auth',
        }
    },
    {
        path: '/admin',
        name: 'Admin',
        component: () => import('../views/admin/index.vue'),
        meta: {
            layout: 'Admin',
            auth: true,
        }
    },
    {
        path: '/admin/tournament',
        name: 'tournament.index',
        component: () => import('../views/admin/tournament/index.vue'),
        meta: {
            layout: 'Admin',
            auth: true,
        }
    },
    {
        path: '/admin/tournament/:id',
        name: 'tournament.edit',
        component: () => import('../views/admin/tournament/edit.vue'),
        meta: {
            layout: 'Admin',
            auth: true,
        }
    },


    {
        path: '/:pathMatch(.*)*',
        name: '404',
        component: () => import('../views/NotFound.vue'),
        meta: {
            layout: 'Clear',
        }

    },
];
