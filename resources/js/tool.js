Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'cpanel-mail',
            path: '/cpanel-mail',
            component: require('./components/Tool'),
        },
    ])
})
