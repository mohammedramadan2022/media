import User from "@/libs/User";

export function isAuth(to, form, next) {
    if(!User.hasToken()) {
        return next({name: 'home'});
    }

    return next();
}
