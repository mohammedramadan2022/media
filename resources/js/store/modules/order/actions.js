import {useConfirmationSwal, useSuccessSwal} from "@/composables/useSwal";
import router from "@/routes";

export default {
    async getUserOrders({state, rootState, commit}) {
        rootState.isLoading = true;
        let response = await axios.get('/user/getUserOrders?page=1');
        state.allOrders = response.data.data.data;
        commit('setOrderPaginated', response);
        commit('setPaginationOrdersToMain');
        rootState.isLoading = false;
    },
    async filterOrders({state, rootState, dispatch, commit}, value) {
        rootState.isLoading = true;
        let response = await axios.post('/user/filterUserOrders',{filter: value, term: state.term, page: 1});
        state.filter = value;
        state.allOrders = response.data.data.data;
        commit('setOrderPaginated', response);
        if(state.filter === 'all') commit('setPaginationOrdersToMain');
        else commit('setPaginationOrdersToFilter');
        rootState.isLoading = false;
    },

    async getOrdersNextPage({state, rootState, commit}) {
        rootState.isLoading = true;
        commit('nextOrdersPage');
        let response = await axios.get('/user/getUserOrders?page=' + state.pagination.currentPage);
        state.allOrders = state.allOrders.concat(response.data.data.data);
        commit('setOrderPaginated', response);
        commit('setPaginationOrdersToMain');
        rootState.isLoading = false;
    },
    async getOrdersFilterNextPage({state, rootState, commit}) {
        rootState.isLoading = true;
        commit('nextOrdersPage');
        let term = state.term;
        let response = await axios.post('/user/filterUserOrders',{page: state.pagination.currentPage, term, filter: 'all'});
        state.allOrders = state.allOrders.concat(response.data.data.data);
        commit('setOrderPaginated', response);
        commit('setPaginationOrdersToFilter');
        rootState.isLoading = false;
    },

    async getOrderById({state, dispatch, rootState}, order_no) {
        rootState.isLoading = true;
        state.singleOrder = {};
        let response = await axios.post('/user/getOrderById',{order_no});
        state.singleOrder = response.data.data;
        dispatch('getUpdatedProfile');
        rootState.isLoading = false;
    },
    async filterKeyUp({state, commit}, value) {
        state.term = value;
        let response = await axios.post('/user/filterUserOrders?page=1',{term: value, filter: state.filter});
        state.allOrders = response.data.data.data;
        commit('setOrderPaginated', response);
        commit('setPaginationOrdersToFilter');
    },
    async changeUserOrderDates({state, rootState, commit, dispatch}, order_no) {
        rootState.errors = {};
        state.orderSummaryDatesData.order_id = state.singleOrder.id;
        let response = await axios.post('/user/changeUserOrderDates', state.orderSummaryDatesData);
        if (response.data.status) {
            await useSuccessSwal(response.data.message);
            dispatch('getOrderById', order_no);
        }
        $('div#editDatesModal').modal('hide');
    },
    async cancelUserOrder({state, rootState, dispatch}, order_id) {
        let result = await useConfirmationSwal(trans('message.cancelUserOrderWarning'));
        if (!result.isConfirmed) return;
        let response = await axios.post('/user/cancelUserOrder', {order_id});
        dispatch('getUserOrders');
        if (response.data.status) await router.push({name: 'orders'});
    },
    async getOrderUndertaking({state, rootState, dispatch}, undertaking_id) {
        rootState.isLoading = true;
        let response = await axios.post('/user/getOrderUndertaking',{undertaking_id});
        rootState.isLoading = false;
        state.undertaking = response.data.data;
    },
    async setUserOrderUndertakingAccepted({state, rootState, dispatch}, undertaking_id) {
        rootState.isLoading = true;

        let response = await axios.post('/user/setUserOrderUndertakingAction',{undertaking_id: undertaking_id, action: 'accept'});

        dispatch('getOrderUndertaking', undertaking_id);

        await useSuccessSwal(response.data.message);

        rootState.isLoading = false;
    },
    async setUserOrderUndertakingRefused({state, rootState, dispatch}, undertaking_id) {
        rootState.isLoading = true;

        let response = await axios.post('/user/setUserOrderUndertakingAction',{undertaking_id: undertaking_id, action: 'refuse'});

        dispatch('getOrderUndertaking', undertaking_id);

        await useSuccessSwal(response.data.message);

        rootState.isLoading = false;
    }
};
