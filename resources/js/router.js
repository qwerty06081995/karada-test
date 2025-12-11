import { createRouter, createWebHistory } from 'vue-router';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Tasks from './components/Tasks.vue';

const routes = [
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/', component: Tasks, meta: { requiresAuth: true } },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');

    if(to.meta.requiresAuth && !token) {
        next('/login');
    } else if ((to.path === '/login' || to.path === '/register') && token) {
        next('/');
    } else {
        next();
    }
});

export default router;
