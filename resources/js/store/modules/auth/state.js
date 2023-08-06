import User from "@/libs/User";

export default {
    isAuth: !!(User.hasToken() && User.auth()),
    loginData: {},
    registerData: {},
    forgetPasswordData: {},
    profileData: {
        first_name: User.hasToken() && User.auth() ? User.auth().first_name : '',
        last_name: User.hasToken() && User.auth() ? User.auth().last_name : '',
        identity: '',
        identity_number: User.hasToken() && User.auth() ? User.auth().identity_number : '',
        city_id: User.hasToken() && User.auth() && User.auth().city ? User.auth().city.id : 0,
        phone: User.hasToken() && User.auth() ? User.auth().phone : '',
        whatsapp: User.hasToken() && User.auth() ? User.auth().whatsapp : '',
        email: User.hasToken() && User.auth() ? User.auth().email : ''
    },
    newPassword: {},
    digits: {
        one: '',
        two: '',
        three: '',
        four: ''
    },
};
