import AppStorage from './AppStorage';

class User
{
    hasToken() {
        return !!AppStorage.getCustomKey('token');
    }

    storeApiToken(token) {
        AppStorage.storeCustomKey('token', token);
    }

    saveUser(response) {
        this.storeApiToken(response.data.data.jwt);
        AppStorage.storeJsonCustomKey('auth', response.data.data);
        AppStorage.updateCustomKey('userCartTotal', 0);
    }

    auth() {
        return AppStorage.getJsonCustomKey('auth');
    }

    logout() {
        AppStorage.clearCustomKey('registerData');
        AppStorage.clearCustomKey('auth');
        AppStorage.clearCustomKey('token');
    }

    /* handle data */
    getApiToken() {
        let apiToken = AppStorage.getCustomKey('token');

        return (!!apiToken) ? apiToken : '';
    }
}

export default User = new User();
