import router from "@/routes";
import {
    useConfirmationSwal,
    useConfirmDeleteSwal,
    useSwal,
    useSwalTrans,
    useSwalDeleted,
    useConfirmSwalTrans,
    useSwalWarning
} from "@/composables/useSwal";

import AppStorage from "@/libs/AppStorage";
import {clearAuthInfo} from "@/composables/useStorage";

export default {
    async getAllAddresses({state, rootState}) {
        rootState.isLoading = true;
        let {data} = await axios.get('/user/getAllAddresses');
        state.addresses = data.data;
        rootState.isLoading = false;
    },
    async getAddressById({state, rootState, commit}, address_id) {
        rootState.isLoading = true;
        if (address_id) {
            let response = await axios.post('/user/getAddressById', {address_id});
            commit('setAddressData', response.data.data);
            state.address = response.data.data;
        }
        rootState.isLoading = false;
    },
    async addNewAddress({state, rootState, dispatch}, fromCart= false) {
        rootState.errors = {};
        rootState.isLoading = true;
        let response = await axios.post('/user/addNewAddress', state.addressDefaultData);

        dispatch('getUpdatedProfile');
        dispatch('getAllAddresses');

        if (fromCart) {
            $('#show-addresses-div').removeClass('d-none');
            $('#add-address-div').addClass('d-none');
            return;
        }

        state.addressDefaultData = {};

        rootState.isLoading = false;

        if(response.data.status) await router.push({name: 'addresses'});

        window.location.reload();
    },
    async deleteUserAddress({state, rootState, dispatch}, address_id) {
        let result = await useConfirmDeleteSwal(trans('message.confirmDeleteAddress'));
        if(!result.isConfirmed) return;
        let response = await axios.post('/user/deleteUserAddress', {address_id});
        clearAuthInfo();
        dispatch('getUpdatedProfile');
        $('#address-id-' + address_id).fadeOut();
        await useSwalDeleted(response.data.message);
        window.location.reload();
    },
    async updateUserAddress({state, commit, dispatch, rootState}, address_id) {
        rootState.isLoading = true;
        if (User.auth().address_id === address_id && parseInt(User.auth().city.id) !== state.addressData.city_id) {
            let result = await useConfirmationSwal(trans('message.clearCartContentWarning'));
            if (!result.isConfirmed) return;
            state.addressData.address_id = address_id;
            await axios.post('/user/makeCartEmpty', state.addressData);
            dispatch('getUpdatedProfile');
            AppStorage.clearCustomKey('cartSummary');
            await router.push({name: 'products'});
        } else {
            state.addressData.address_id = address_id;
            let {data} = await axios.post('/user/updateUserAddress', state.addressData);
            state.errors = {};
            state.addressData = data.data;
            dispatch('getAddressById', data.data.id);
            dispatch('getAllAddresses');
            rootState.errors = {};
            await useSwal(data.message);
        }
        rootState.isLoading = false;
    },
    async setDefaultAddress({state, rootState, commit, dispatch}, address) {
        if (User.auth().city.id !== address.city.id && parseInt(rootState.cart.cartTotal) !== 0) {
            let result= await useConfirmSwalTrans('message.warning','message.clearCartContentWarning','setDefaultLocation');
            if (!result.isConfirmed) return;
            let response = await axios.post('/user/changeDefaultAddress', {address_id: address.id});
            dispatch('getUpdatedProfile');
            await useSwalTrans('message.setDefaultAddressMessage');
            $('#address-' + address.id).attr('checked', true);
            commit("setDefaultCartSummary");
            AppStorage.updateCustomKey('userCartTotal', '0');
            AppStorage.updateCustomKey('cartCount', '0');
            rootState.cart.cartTotal = '0';
            rootState.cart.cartProductCount = '0';
            state.address = response.data.data;
            dispatch('getAllAddresses');
        } else {
            let response = await axios.post('/user/setDefaultAddress', {address_id: address.id});
            dispatch('getUpdatedProfile');
            $('#address-' + address.id).attr('checked', true);
            await useSwalTrans('message.setDefaultAddressMessage');
            state.address = response.data.data;
            dispatch('getAllAddresses');
        }
    },
    async changeDefaultAddress({state, rootState, commit, dispatch}, address) {
        if (User.auth().city.id !== address.city.id && state.userCartTotal !== 0) {
            let result= await useConfirmSwalTrans('message.warning','message.clearCartContentWarning','setDefaultLocation');
            if (!result.isConfirmed) return;
            await axios.post('/user/changeDefaultAddress', { address_id: address.id });
            dispatch('getUpdatedProfile');
            $('#address-' + address.id).attr('checked', true);
            AppStorage.clearCustomKey('cartSummary');
            AppStorage.storeCustomKey('userCartTotal','00:00');
            commit('setDefaultCartSummary');
            state.cartTotal = '0';
            await router.push({name: 'products'});
        } else {
            let response = await axios.post('/user/setDefaultAddress', { address_id: address.id });
            dispatch('getUpdatedProfile');
            await useSwal(trans('message.setDefaultAddressMessage'));
            state.address = response.data.data;
            commit('setAddressItemStyle', address.id);
        }
    },
    async setOrderAddress({state, commit}, address_id) {
        state.orderAddressData.address_id = address_id;
    },
    async changeUserOrderAddress({state, rootState, dispatch}) {
        try {
            state.orderAddressData.order_id = rootState.order.singleOrder.id;

            await axios.post('/user/changeUserOrderAddress', state.orderAddressData);

            if (state.orderAddressData.delivery_type === 'address') dispatch('getUpdatedProfile');

            dispatch('getOrderById', rootState.order.singleOrder.order_no);

            $('div#editDeliverWayModal').modal('hide');

            setTimeout(async () => await useSwal(trans('message.setDefaultAddressMessage')),500);
        } catch (e) {
            if (e.response && e.response.status === 422) await useSwalWarning(e.response.data.message);
        }
    },
};
