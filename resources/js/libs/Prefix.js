import router from "@/routes";

router.beforeEach((to, from, next) => {
    document.title = to.meta.title ? trans('message.rental') + ' || ' + trans('message.' + to.meta.title) : trans('message.rental');
    next();
});

router.beforeEach((to, from) => {
    store.state.errors = {};
})

export {
    router
};
