export function getCustomKey(key){
    return localStorage.getItem(key);
}

export function storeCustomKey(key, value){
    localStorage.setItem(key, value);
}

export function updateCustomKey(key, value){
    localStorage.removeItem(key);
    localStorage.setItem(key, value);
}

// ===========================================================

export function getJsonCustomKey(key) {
    return JSON.parse(localStorage.getItem(key));
}

export function storeJsonCustomKey(key, value){
    localStorage.setItem(key, JSON.stringify(value));
}

// ==========================================================

export function clearCustomKey(key){
    localStorage.removeItem(key);
}

export function clearAuthInfo(){
    localStorage.removeItem('token');
    localStorage.removeItem('auth');
    localStorage.removeItem('registerData');
}
