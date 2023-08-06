import {getToken} from "firebase/messaging";
import {clearCustomKey, getCustomKey} from "@/composables/useStorage";

export function useSortByDesc(sort_by) {
    let compare_desc = function(a, b) {
        if (a.price < b.price) return -1;
        if (a.price > b.price) return 1;
        return 0;
    };

    let compare_asc = function(a, b) {
        if (a.price > b.price) return -1;
        if (a.price < b.price) return 1;
        return 0;
    };

    return (sort_by === 'price_low_high') ? compare_desc : compare_asc;
}

export function useGetImage(path){
    return rootUrl + path;
}

export async function useGetToken() {
    try {
        let currentToken = await getToken(messaging,{ vapidKey: 'BN8Iu8hh1DKE8GOER6p0-AxKlnGuyjPM2MOk_poS8IhCBPCwHQYMCui8t0hMq_620zQxe8IReZLJY1xVErfB9E4' });

        if(!currentToken) {
            console.log('No registration token available. Request permission to generate one.');
            return null;
        }

        return currentToken;
    } catch (e) {
        console.log(e);
    }
}

export function getWalletClass(type) {
    if(type === 'shipped' || type === 'refund') return 'custom-success-color';
    else return 'custom-red-color';
}

export function changeSelectedVal(optionable, type, dropdown, category_id, from, currentRoute) {
    let type_id = optionable.id;

    if (dropdown === 'color') $('.custom-color-display-' + optionable.id).toggleClass('color-checked');

    if (dropdown === 'text') $('#option-check-input-' + optionable.id).toggleClass('active-checkbox');

    if (dropdown === 'boolean' && type === 'spec') $('#boolean-input-check-' + optionable.id).toggleClass('active-checkbox');

    if (dropdown === 'text' && type === 'spec') $('#spec-check-input-' + optionable.id).toggleClass('active-checkbox');

    store.dispatch('getProductsByOptionId', { type_id, type, dropdown, category_id, from, currentRoute });
}

export function changeSelectedValInStore(optionable, type, dropdown, category_id) {
    let type_id = optionable.id;

    if (dropdown === 'color') $('.custom-color-display-'+optionable.id).toggleClass('color-checked');

    if (dropdown === 'text') $('#option-check-input-'+optionable.id).toggleClass('active-checkbox');

    if (dropdown === 'boolean' && type === 'spec') $('#boolean-input-check-'+optionable.id).toggleClass('active-checkbox');

    if (dropdown === 'text' && type === 'spec') $('#spec-check-input-'+optionable.id).toggleClass('active-checkbox');

    store.dispatch('getStoreProductsByOptionId', { type_id, type, dropdown, category_id });
}

export function isEmptyObject(value) {
    if(value instanceof String) return jQuery.isEmptyObject(JSON.parse(value));

    return jQuery.isEmptyObject(value);
}

export async function handleShowJoinModal(){
    if (getCustomKey('userPhone')) {
        if (await store.dispatch('checkDemandExists', {phone: getCustomKey('userPhone')})) {
            $('#joinRentalBusinessModal').modal('hide');
            $('#confirmJoinModal').modal('show');
            store.state.countDown = 0;
            store.commit('resetDigits');
        } else {
            clearCustomKey('userPhone');
            $('#confirmJoinModal').modal('hide');
            $('#joinRentalBusinessModal').modal('show');
        }
    } else {
        $('#confirmJoinModal').modal('hide');
        $('#joinRentalBusinessModal').modal('show');
    }
}
