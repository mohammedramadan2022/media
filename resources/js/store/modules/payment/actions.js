import {useConfirmationSwal, useSuccessSwal} from "@/composables/useSwal";

export default {
    async setUserOrderPay({state, rootState}, order_id) {
        rootState.errors = {};
        state.paymentData.order_id = order_id;

        let response = await axios.post('/user/setUserOrderPay', state.paymentData);

        if (response.data.status && response.data.data.payment_url !== '') {
            await useSuccessSwal(response.data.message);
            window.location.href = response.data.data.payment_url;
        }
    },
    async setUserOrderPayCash({state, rootState, dispatch}, order_id) {
        rootState.isLoading = true;
        let response = await axios.post('/user/setUserOrderPayCash', {order_id});
        if (response.data.status) await useSuccessSwal(response.data.message);
        dispatch('getOrderById', rootState.order.singleOrder.order_no);
        dispatch('getUpdatedProfile');
        rootState.isLoading = false;
    },
    async setUserPayInsurance({state, rootState}, order_id) {
        try {
            state.errors = {};
            state.payInsuranceData.order_id = order_id;
            let response = await axios.post('/user/setUserPayInsurance', state.payInsuranceData);

            if (response.data.status && response.data.data.payment_url !== '') {
                await useSuccessSwal(response.data.message);
                window.location.href = response.data.data.payment_url;
            }
        } catch (e) {
            if (e.response && e.response.status === 422) state.errors = e.response.data.data;
        }
    },
    async setUserOrderPayByWallet({state, rootState, dispatch}, order_id) {
        let confirm = await useConfirmationSwal(trans('message.walletPayWarning'));
        if (!confirm.isConfirmed) return;
        let response = await axios.post('/user/setUserOrderPayByWallet',{order_id});
        if (response.data.status) {
            dispatch('getOrderById', rootState.order.singleOrder.order_no);
            dispatch('getUpdatedProfile');
            await useSuccessSwal(response.data.message);
        }
    },
    // Delay Payment
    async setUserDelayPay({state, rootState}, order_id) {
        rootState.errors = {};
        state.delayPenaltyData.order_id = order_id;

        let response = await axios.post('/user/setUserDelayPay', state.delayPenaltyData);

        if (response.data.status && response.data.data.payment_url !== '') {
            await useSuccessSwal(response.data.message);
            window.location.href = response.data.data.payment_url;
        }
    },
    async setUserDelayPayCash({state, rootState, dispatch}, order_id) {
        rootState.isLoading = true;
        let response = await axios.post('/user/setUserDelayPayCash', {order_id});
        if (response.data.status) await useSuccessSwal(response.data.message);
        dispatch('getOrderById', rootState.order.singleOrder.order_no);
        dispatch('getUpdatedProfile');
        rootState.isLoading = false;
    },
    async setUserDelayPayByWallet({state, rootState, dispatch}, order_id) {
        let confirm = await useConfirmationSwal(trans('message.walletPayWarning'));
        if (!confirm.isConfirmed) return;
        let response = await axios.post('/user/setUserDelayPayByWallet',{order_id});
        if (response.data.status) {
            dispatch('getOrderById', rootState.order.singleOrder.order_no);
            dispatch('getUpdatedProfile');
            await useSuccessSwal(response.data.message);
        }
    },
}
