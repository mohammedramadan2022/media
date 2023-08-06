import {useGetToken} from "@/composables/useHelper";
import AppStorage from "@/libs/AppStorage";
import User from "@/libs/User";
import {useSwal} from "@/composables/useSwal";

export default {
    validatePassword({state, rootState}) {
        if (!state.newPassword.password && !state.newPassword.password_confirmation) {
            rootState.errors = {
                password: trans('message.newPasswordFieldRequired'),
                password_confirmation: trans('message.newPasswordConfirmationFieldRequired')
            };
            return;
        }

        if (!state.newPassword.password) {
            rootState.errors = {password: trans('message.newPasswordFieldRequired')};
            return;
        }

        if (!state.newPassword.password_confirmation) {
            rootState.errors = {password_confirmation: trans('message.newPasswordConfirmationFieldRequired')};
            return;
        }

        rootState.errors = {};
    },
    validateCheckResetCode({state}) {
        if (!state.digits.one) state.errors.one = trans('message.required');
        if (!state.digits.two) state.errors.two = trans('message.required');
        if (!state.digits.three) state.errors.three = trans('message.required');
        if (!state.digits.four) state.errors.four = trans('message.required');
    },

    async register({state, rootState}) {
        rootState.isLoading = true;
        rootState.errors = {};
        let fcm_token = await useGetToken();
        state.registerData.device_token = fcm_token ? fcm_token : '';
        await axios.post('/user/register', state.registerData);
        AppStorage.storeJsonCustomKey('registerData', state.registerData);
        AppStorage.updateCustomKey('userCartTotal', 0);
        state.registerData = {};
        rootState.isLoading = false;

        $('#registerModal').modal('hide');
        $('#confirmMobileModal').modal('show');
    },
    async logout({state}) {
        await axios.get('/user/logout');
        AppStorage.clearAuthInfo();
        AppStorage.updateCustomKey('userCartTotal', 0);
        state.isAuth = false;
        window.location.href = '/';
    },
    async confirmMobilePhone({state, rootState}) {
        rootState.isLoading = true;
        let userData = AppStorage.getJsonCustomKey('registerData') ?? {};
        let code = state.digits.one + state.digits.two + state.digits.three + state.digits.four;
        let all_data = Object.assign({}, userData, {code});
        let response = await axios.post('/user/checkUserActiveCode', all_data);
        User.saveUser(response);
        $('div#confirmMobileModal').modal('hide');
        AppStorage.clearCustomKey('registerData');
        rootState.isLoading = false;
        window.location.reload();
    },
    async resendActiveCode({dispatch, commit, rootState}) {
        rootState.isLoading = true;
        let registerData = AppStorage.getJsonCustomKey('registerData');
        if (!registerData) {
            $('div#confirmMobileModal').modal('hide');
            $('div#registerModal').modal('show');
        }
        await axios.post('/user/register', registerData);
        rootState.countDown = 60;
        commit('resetDigits');
        dispatch('setCountDown');
        rootState.isLoading = false;
    },
    async confirmPhonePhone({state, rootState}) {
        rootState.isLoading = true;
        let phone = AppStorage.getCustomKey('userPhone');
        let code = state.digits.one + state.digits.two + state.digits.three + state.digits.four;
        let response = await axios.post('/user/checkUserPhoneActive', {code, phone});
        User.saveUser(response);
        $('div#confirmMobileModal').modal('hide');
        await useSwal(response.data.message);
        rootState.isLoading = false;
        window.location.reload();
    },
    async resendActivePhoneCode({dispatch, commit, rootState}) {
        rootState.isLoading = true;
        let phone = AppStorage.getCustomKey('userPhone');
        await axios.post('/user/resendActivePhoneCode', {phone});
        rootState.countDown = 60;
        commit('resetDigits');
        dispatch('setCountDown');
        rootState.isLoading = false;
    },
    async forgetPasswordSubmit({state, rootState}) {
        try {
            rootState.isLoading = true;
            await axios.post('/user/forgetPassword', state.forgetPasswordData);
            state.errors = {};
            AppStorage.clearCustomKey('forgetPasswordPhone');
            AppStorage.storeCustomKey('forgetPasswordPhone', state.forgetPasswordData.phone);
            $('div#forgetPasswordModal').modal('hide');
            $('div#checkResetCodeModal').modal('show');
            state.countDown = 60;
            rootState.isLoading = false;
        } catch (e) {
            if (e.response && e.response.status === 422) state.errors = e.response.data.data;
        }
    },
    async login({state, rootState, dispatch}) {
        rootState.isLoading = true;
        state.errors = {};
        rootState.errors = {};
        let registerData = AppStorage.getJsonCustomKey('registerData');
        let loginModal = $('div#loginModal');
        let confirmMobileModal = $('div#confirmMobileModal');

        // check for mobile activation when register new account
        if (registerData && registerData.email === state.loginData.email) {
            loginModal.modal('hide');
            confirmMobileModal.modal('show');
            dispatch('setCountDown');
            return;
        }

        let fcm_token = await useGetToken();
        state.loginData.device_token = fcm_token ? fcm_token : '';

        let response = await axios.post('/user/login', state.loginData);

        state.loginData = {};
        User.saveUser(response);
        loginModal.modal('hide');
        rootState.isLoading = false;

        window.location.reload();
    },
    async checkResetCode({state, rootState, dispatch}) {
        dispatch('validateCheckResetCode');

        let phone = AppStorage.getCustomKey('forgetPasswordPhone') ?? "";
        let code = state.digits.one + state.digits.two + state.digits.three + state.digits.four;

        await axios.post('/user/checkResetCode', {phone, code});

        $('#checkResetCodeModal').modal('hide');
        $('#newPasswordModal').modal('show');

        rootState.countDown = 1;
    },
    async resendResetCode({state, dispatch, rootState}) {
        let storedPhone = AppStorage.getCustomKey('forgetPasswordPhone') ?? "";
        await axios.post('/user/forgetPassword', {phone: storedPhone});
        state.errors = {};
        rootState.countDown = 60;
        dispatch('setCountDown');
    },
    async newPasswordSubmit({state, rootState, dispatch}) {
        try {
            dispatch('validatePassword');

            if (state.newPassword.password !== state.newPassword.password_confirmation) {
                rootState.errors.password = 'عفوا كلمة المرور الجديدة لا يتطابق مع تاكيد كلمة المرور';
                return;
            }

            let storedPhone = AppStorage.getCustomKey('forgetPasswordPhone') ?? "";
            let userData = {password: state.newPassword.password, phone: storedPhone};

            await axios.post('/user/resetPassword', userData);

            AppStorage.clearCustomKey('forgetPasswordPhone');
            rootState.newPassword = {};
            rootState.digits = {};
            rootState.errors = {};

            $('#newPasswordModal').modal('hide');
            $('#loginModal').modal('show');
        } catch (e) {
            if (e.response && e.response.status === 422) rootState.errors.password = e.response.data.data.password[0];
        }
    },
    async getUpdatedProfile() {
        let response = await axios.get('/user/getUpdatedProfile');
        AppStorage.clearAuthInfo();
        User.saveUser(response);
    },
    async updateUserProfile({state, rootState, dispatch}) {
        rootState.isLoading = true;
        let fd = new FormData();
        fd.append('first_name', state.profileData.first_name);
        fd.append('last_name', state.profileData.last_name);
        fd.append('identity', state.profileData.identity);
        fd.append('identity_number', state.profileData.identity_number);
        fd.append('city_id', state.profileData.city_id);
        fd.append('phone', state.profileData.phone);
        fd.append('email', state.profileData.email);

        let response = await axios.post('/user/updateUserProfile', fd);

        let res = response.data.data;

        if (res.is_active === 0) {
            $('#confirmPhoneModal').modal('show');
            AppStorage.storeCustomKey('userPhone', state.profileData.phone);
            dispatch('setCountDown');
        } else {
            AppStorage.clearAuthInfo();
            User.saveUser(response);
            await useSwal(response.data.message);
        }

        state.errors = {};
        rootState.isLoading = false;
    },
};
