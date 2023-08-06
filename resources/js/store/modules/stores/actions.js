import {clearCustomKey, getCustomKey} from "@/composables/useStorage";
import User from "@/libs/User";
import {useSwal} from "@/composables/useSwal";

export default {
    async getAllStores({state, rootState, commit}) {
        rootState.isLoading = true;
        let response = await axios.get('/getAllStores?page=1');
        state.allStores = response.data.data.data;
        commit('setPaginated', response);
        rootState.isLoading = false;
    },
    async getStoreSectionWithCategories({state, rootState}) {
        rootState.isLoading = true;
        let response = await axios.get('/getStoreSectionWithCategories');
        state.sections.all = response.data.data.all;
        state.sections.sections = response.data.data.sections;
        state.sections.offers_count = response.data.data.offers_count;
        rootState.isLoading = false;
    },
    async getCitySectionWithCategories({state, rootState}, city_id) {
        rootState.isLoading = true;
        let {data} = await axios.post('/getCitySectionWithCategories', {city_id});
        state.sections.all = data.data.all;
        state.sections.sections = data.data.sections;
        state.sections.offers_count = data.data.offers_count;
        rootState.isLoading = false;
    },
    async getSingleStoreSectionWithCategories({state, rootState}, store_id) {
        rootState.isLoading = true;
        let response = await axios.post('/getSingleStoreSectionWithCategories', {store_id});
        state.sections.all = response.data.data.all;
        state.sections.sections = response.data.data.sections;
        state.sections.offers_count = response.data.data.offers_count;
        rootState.isLoading = false;
    },

    async getStoreById({state, rootState}, store_id) {
        rootState.isLoading = true;
        let response = await axios.post('/getStoreById', {store_id});
        state.getSingleProvider = response.data.data.store;
        state.allProducts = response.data.data.products;
        rootState.isLoading = false;
    },
    async getOffersByStoreId({state, rootState, commit}, store_id) {
        rootState.isLoading = true;
        let page = 1;
        let response = await axios.post('/getOffersByStoreId', {store_id, page});
        state.allProducts = response.data.data.data;
        commit('setPaginated', response);
        rootState.isLoading = false;
    },
    async getStoreFilteredProducts({state, commit, rootState}, store_id) {
        rootState.isLoading = true;
        state.allProducts = [];
        state.filterData.store_id = store_id;
        let response = await axios.post('/filterProducts', state.filterData);
        state.allProducts = response.data.data.data;
        commit('setPaginated', response);
        rootState.isLoading = false;
    },
    async getStoreFilteredOffers({state, rootState}, store_id = null) {
        rootState.isLoading = true;
        state.allProducts = [];
        state.filterData.store_id = store_id;
        state.filterData.has_offer = true;
        let response = await axios.post('/filterProducts', state.filterData);
        state.allProducts = response.data.data;
        rootState.isLoading = false;
    },

    async getStoreProductsByCategoryId({state, commit, rootState}, payload) {
        rootState.isLoading = true;
        let page = 1;
        let category_id = payload.category_id;
        let store_id = payload.store_id;
        state.allProducts = [];

        let response = await axios.post('/getProductsByCategoryId', {category_id, store_id, page});
        state.allProducts = response.data.data.data;
        commit('setPaginated', response);
        rootState.isLoading = false;
    },
    async getStoreFilteredCategoryProducts({state, rootState}) {
        rootState.isLoading = true;
        state.allProducts = [];
        if (state.categoryProductsFilterData.city_id === '' && state.categoryProductsFilterData.term === '') return;
        let response = await axios.post('/filterProducts', state.categoryProductsFilterData);
        state.allProducts = response.data.data;
        rootState.isLoading = false;
    },
    async getStoresProductsByCategoryId({state, commit, rootState, dispatch}, category_id) {
        rootState.isLoading = true;
        let page = 1;
        state.allProducts = [];
        state.category_id = category_id;

        dispatch('getStoreSpecsByCategoryId', category_id);

        let response = await axios.post('/getStoresProductsByCategoryId', {category_id, page});

        state.allProducts = response.data.data.data;
        commit('setPaginated', response);
        rootState.isLoading = false;
    },
    async setUserStoreRate({state, rootState, dispatch}, store_id) {
        rootState.isLoading = true;
        state.rateData.store_id = store_id;
        state.rateData.user_id = User.auth().id;
        state.rateData.rate = $('input[name=rate]').val();

        await axios.post('/user/setUserStoreRate', state.rateData);

        state.rateData = {};
        state.errors = {};

        dispatch('getStoreById', store_id);
        $('#rateModal').modal('hide');
        rootState.isLoading = false;
    },

    async getStoresNextPage({state, rootState, commit}) {
        rootState.isLoading = true;
        commit('nextPage');
        let response = await axios.get('/getAllStores?page=' + state.currentPage);
        state.allStores = state.allStores.concat(response.data.data.data);
        commit('setPaginated', response);
        rootState.isLoading = false;
    },
    async getStoreCategoryNextPage({state, rootState, commit}) {
        rootState.isLoading = true;
        commit('nextPage');
        let response = await axios.get('/getStoresProductsByCategoryId?page=' + state.currentPage);
        state.allProducts = state.allProducts.concat(response.data.data.data);
        commit('setPaginated', response);
        rootState.isLoading = false;
    },
    async getOffersByStoreIdNextPage({state, rootState, commit}, store_id) {
        rootState.isLoading = true;
        commit('nextPage');
        let response = await axios.post('/getOffersByStoreId', {page: state.currentPage, store_id: store_id});
        state.allStores = state.allStores.concat(response.data.data.data);
        commit('setPaginated', response);
        rootState.isLoading = false;
    },

    async getStoreProductsByOptionId({state, commit, rootState}, payload) {
        state.allProducts = [];

        if (state.options.some(id => id === payload.type_id)) {
            state.options.splice(state.options.indexOf(payload.type_id), 1);
        } else {
            state.options.push(payload.type_id);
        }

        let response = await axios.post('/getProductsByOptionId', {
            options: state.options,
            category_id: payload.category_id,
            belongs_to: 'store',
            page: 1
        });
        state.allProducts = response.data.data.data;
        commit('setStoreOptionsPaginated', response);
    },
    async getDefaultSpecForCategory({state, rootState}, category_id) {
        rootState.isLoading = true;
        state.allStoreSpecs = [];
        let response = await axios.post('/getDefaultSpecForCategory', {category_id});
        state.allStoreSpecs = response.data.data;
        rootState.isLoading = false;
    },
    async getStoreSpecsByCategoryId({state, rootState, commit}, category_id) {
        rootState.isLoading = true;
        state.allStoreSpecs = [];
        state.options = [];
        let response = await axios.post('/getSpecsByCategoryId', {category_id});
        state.allStoreSpecs = response.data.data;
        rootState.isLoading = false;
    },

    async validateStoreMobilePhoneCode({state}) {
        if (!state.digits.one) state.errors.one = trans('message.required');
        if (!state.digits.two) state.errors.two = trans('message.required');
        if (!state.digits.three) state.errors.three = trans('message.required');
        if (!state.digits.four) state.errors.four = trans('message.required');
    },

    async confirmJoinModal({state, dispatch, rootState}){
        rootState.isLoading = true;
        dispatch('validateStoreMobilePhoneCode');
        let phone= getCustomKey('userPhone');

        let code= state.digits.one + state.digits.two + state.digits.three + state.digits.four;

        let response = await axios.post('/checkConfirmPhoneCode', {code, phone});
        $('div#confirmJoinModal').modal('hide');
        await useSwal(response.data.message);
        rootState.isLoading = false;
        clearCustomKey('userPhone');
        window.location.reload();
    },
    async resendConfirmPhoneCode({rootState, dispatch, commit}){
        rootState.isLoading = true;
        await axios.post('/resendConfirmPhoneCode', {phone: getCustomKey('userPhone')});
        rootState.countDown = 60;
        commit('resetDigits');
        dispatch('setCountDown');
        rootState.isLoading = false;
    },
    async checkDemandExists({state}, payload){
        let response = await axios.post('/checkDemandExists', payload);

        return response.data.data.is_exists;
    }
};
