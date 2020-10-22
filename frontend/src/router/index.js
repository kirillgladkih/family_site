import VueRouter from 'vue-router'
import Vue from 'vue'

Vue.use(VueRouter)

const routes = [
    {
        name: 'groups',
        component: () => import('../views/groups/Groups'),
        path: '/home/groups/'
    },
    {
        name: 'schedule',
        component: () => import('../views/schedule/Schedule'),
        path: '/home/schedule/'
    },
    {
        name: 'leeds',
        component: () => import('../views/leeds/Leeds'),
        path: '/home/leeds/'
    },
    {
        name: 'clients',
        component: () => import('../views/clients/Clients'),
        path: '/home/clients/'
    },
    {
        name: 'procreators',
        component: () => import('../views/procreators/Procreators'),
        path: '/home/procreators/'
    },
    {
        name: 'record',
        component: () => import('../views/record/Record'),
        path: '/home/record/'
    },
    {
        name: 'recordings',
        component: () => import('../views/recordings/Recordings'),
        path: '/home/recordings/'
    },
];

export default new VueRouter({
    routes,
    mode: 'history'
});