class AppStorage
{
    isExists(key){
        return this.getCustomKey(key) !== null
            || this.getCustomKey(key) !== undefined
            || this.getJsonCustomKey(key) !== null
            || this.getJsonCustomKey(key) !== undefined
            || this.getJsonCustomKey(key) !== ''
            || this.getCustomKey(key) !== '';
    }

    storeCustomKey(key, value) {
        localStorage.setItem(key, value);
    }

    storeJsonCustomKey(key, value){
        this.storeCustomKey(key, JSON.stringify(value));
    }

    getCustomKey(key) {
        return localStorage.getItem(key);
    }

    getJsonCustomKey(key) {
        return JSON.parse(this.getCustomKey(key));
    }

    clearCustomKey(key) {
        localStorage.removeItem(key);
    }

    clearAuthInfo(){
        this.clearCustomKey('token');
        this.clearCustomKey('auth');
        this.clearCustomKey('registerData');
    }

    updateCustomKey(key, value) {
        localStorage.removeItem(key);
        localStorage.setItem(key, value);
    }
}

export default AppStorage = new AppStorage();
