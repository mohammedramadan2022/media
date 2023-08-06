import User from "@/libs/User";
import store from "@/store/modules/root";
import {clearAuthInfo} from "@/composables/useStorage";
import {useSwalError, useSwalWarning} from "@/composables/useSwal";

axios.defaults.baseURL = api_base_url;
axios.defaults.headers.get['lang'] = currentLang;
axios.defaults.headers.get['Authorization'] = 'Bearer ' + User.getApiToken();
axios.defaults.headers.post['lang'] = currentLang;
axios.defaults.headers.post['Authorization'] = 'Bearer ' + User.getApiToken();
axios.defaults.headers.post['website'] = true;

axios.interceptors.response.use(async (response) => response,async (error) => {
    store.state.isLoading = false;
    if (error.response.status === 401) {
        $('#loginModal').modal('show');
        clearAuthInfo();
    }

    if (error.response.status === 422) {
        store.state.errors = {};
        store.state.errors = error.response.data.data;
        store.state.isLoading = false;
    }

    if (error.response.status === 500) await useSwalError(error.response.data.error);
    if (error.response.status === 400) await useSwalWarning(error.response.data.message);

    return Promise.reject(error);
});
