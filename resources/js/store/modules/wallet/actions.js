import {useSuccessSwal} from "@/composables/useSwal";

export default {
    async getUserWallet({state, rootState}) {
        rootState.isLoading = true;
        let response = await axios.get('/user/getUserWallet');
        state.getWallet.balance = response.data.data.balance;
        state.getWallet.currency = response.data.data.currency;
        state.getWallet.transactions = response.data.data.transactions;
        rootState.isLoading = false;
    },
    async chargeWallet({state, rootState, commit, dispatch}) {
        rootState.isLoading = true;
        state.errors = {};
        let response = await axios.post('/user/chargeWallet', state.chargeWalletData);
        if (response.data.status && response.data.data.payment_url !== '') {
            state.isLoading = true;
            commit('resetWalletChargeForm');
            dispatch('getUserWallet');
            dispatch('getUpdatedProfile');
            await useSuccessSwal(response.data.message);
            window.location.href = response.data.data.payment_url;
        }
        rootState.isLoading = false;
    }
};
