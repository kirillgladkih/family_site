export default [
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
        name: 'clients',
        component: () => import('../views/clients/Clients'),
        path: '/home/clients/'
    },
    // {
    //     name: 'procreator',
    //     component: () => import('../views/Procreator'),
    //     path: '/home/procreator/'
    // },
    // {
    //     name: 'record',
    //     component: () => import('../views/Record'),
    //     path: '/home/record/'
    // },
    // {
    //     name: 'record',
    //     component: () => import('../views/Recordings'),
    //     path: '/home/recordings/'
    // },
    // {
    //     name: 'leeds',
    //     component: () => import('../views/Leeds'),
    //     path: '/home/leeds/'
    // },
    // {
    //     name: 'timeTable',
    //     component: () => import('../views/Timetable'),
    //     path: '/home/timeTable/'
    // },
]
