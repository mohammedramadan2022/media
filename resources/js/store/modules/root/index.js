import {createStore} from 'vuex';

import mutations from "@/store/modules/root/mutations";
import actions from "@/store/modules/root/actions";
import getters from "@/store/modules/root/getters";
import state from "@/store/modules/root/state";
import auth from "@/store/modules/auth";
import contacts from "@/store/modules/contacts";
import address from "@/store/modules/address";
import product from "@/store/modules/product";
import providers from "@/store/modules/stores";
import favorite from "@/store/modules/favorite";
import cart from "@/store/modules/cart";
import order from "@/store/modules/order";
import wallet from "@/store/modules/wallet";
import payment from "@/store/modules/payment";
import notification from "@/store/modules/notification";
import section from "@/store/modules/section";

export default createStore({
    modules: {
        auth, contacts, address, product,
        providers, favorite, cart, order,
        wallet, payment, notification, section
    },
    state: state,
    mutations: mutations,
    actions: actions,
    getters: getters,
});
