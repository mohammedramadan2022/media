import User from "@/libs/User";
import {
    clearCustomKey,
    getCustomKey,
    storeCustomKey,
    storeJsonCustomKey,
    updateCustomKey
} from "@/composables/useStorage";
import {useSuccessSwal, useSwal, useSwalAddressWarning} from "@/composables/useSwal";
import router from "@/routes";
import moment from "moment/moment";

export default {
    async getUserCart({state, commit}) {
        commit('setDefaultCartSummary');
        if (User.auth().cart_id) {
            let {data} = await axios.post('/user/getUserCartContent');
            state.getCartProducts = data.data.products;
            state.cartSummary = data.data.summary;
            state.isCartEmpty = data.data.products.length === 0;
            state.cartAddresses = data.data.addresses;
            updateCustomKey('cartCount', state.cartSummary.total === 0 ? 0 : data.data.products.length);
            updateCustomKey('userCartTotal', state.cartSummary.total === 0 ? '00:00' : state.cartSummary.total);

            commit('updateCartCountValue', getCustomKey('cartCount'));
            commit('updateCartTotalValue', getCustomKey('userCartTotal'));
        }
    },
    async addToCart({rootState, dispatch}, product) {
        dispatch('addingToCart', product);
        product.is_in_cart = true;
    },
    async addGeneralProductToCart({state, rootState, dispatch, commit}, product) {
        product.is_in_cart = true;
        dispatch('addingToCart', product);
    },
    async removeProductFromCart({state, rootState, dispatch}, product_id) {
        let {data} = await axios.post('/user/removeProductFromCart', {
            cart_id: User.auth().cart_id,
            product_id: product_id
        });
        $('#product-div-id-' + product_id).fadeOut();
        dispatch('getUserCart');
        await useSwal(data.message);
    },
    async removeProductFromCartInDetails({state, rootState, commit, dispatch}, product_id) {
        let {data} = await axios.post('/user/removeProductFromCart', {
            cart_id: User.auth().cart_id,
            product_id: product_id
        });
        clearCustomKey('userCartTotal');
        dispatch('getUserCart');
        rootState.product.getProduct.is_in_cart = false;
        await useSwal(data.message);
    },
    async replaceProductFromCart({state, rootState}, product_id) {
        await axios.post('/user/removeProductFromCart', {cart_id: User.auth().cart_id, product_id: product_id});
        $('#product-div-id-' + product_id).fadeOut();
        await router.push({name: 'products'});
    },
    async saveOrderSummaryDates({state, rootState, commit}) {
        state.errors = {};
        rootState.errors = {};

        let response = await axios.post('/user/validateShoppingCartDates', state.cartSummaryData);

        if (response.data.status) {
            clearCustomKey('cartSummary');
            storeJsonCustomKey('cartSummary', state.cartSummaryData);

            commit('updateCartSummary');

            await router.push({name: 'complete-cart-order'});
        }
    },
    async saveHourOrderSummaryDates({state, rootState, commit}) {
        state.errors = {};
        rootState.errors = {};

        // let response = await axios.post('/user/validateHourlyShoppingCartDates', state.cartHourlySummaryData);

        // if(response.data.status) {
        //
        // }

        clearCustomKey('cartSummary');
        storeJsonCustomKey('cartSummary', state.cartHourlySummaryData);

        commit('updateCartSummary');

        await router.push({name: 'complete-cart-order'});
    },
    async applyCoupon({state, rootState}, coupon) {
        rootState.isLoading = true;
        state.is_applied = false;

        state.applyCouponData.startDate = state.completeOrderData.startDate;
        state.applyCouponData.endDate = state.completeOrderData.endDate;
        state.applyCouponData.coupon = coupon;

        let {data} = await axios.post('/user/applyCoupon', state.applyCouponData);

        if (data.status && data.data.discount) {
            state.is_applied = true;
            state.coupon_discount = data.data.discount;
            state.coupon_total = data.data.total;
            $('#content.cart-fill.complete-order .order-summary .data form .coupon-div .alert-success').removeClass('d-none');
            $('#content.cart-fill.complete-order .order-summary .data form .coupon-div .btn-danger2').addClass('d-none');
        }
        rootState.isLoading = false;
    },
    async completeUserOrder({state, commit, rootState}){
        state.errors = {};
        rootState.errors = {};
        rootState.isLoading = true;
        state.completeOrderData.is_applied = state.is_applied;
        state.completeOrderData.type = state.rentingSystemType;

        let response = await axios.post('/user/completeUserOrder', state.completeOrderData);

        commit('resetCartSummary');
        commit('updateCartTotalValue', '00:00');

        if (response.data.status) $('#successModal').modal('show');

        rootState.isLoading = false;
    },
    async changeProductQty({state, rootState, commit, dispatch}, payload){
        let response = await axios.post('/user/changeProductQty', { product_id: payload.product.id, quantity: payload.product.cart_qty });

        if (response.data.status) {
            if (getCustomKey('sysType') === 'hour') dispatch('calculateEndDateHours', state.cartHourlySummaryData);

            else dispatch('calculateEndDateDays');

            dispatch('getUserCart');

            await useSuccessSwal(response.data.message);
        }
    },
    async calculateEndDateDays({state, commit, dispatch, rootState}, payload) {
        state.errors = {};
        rootState.errors = {};

        state.completeOrderData.startDate = payload.startDate;
        state.completeOrderData.endDate = payload.endDate;

        const days = await dispatch('getDaysDiff', payload);

        let response = await axios.post('/user/calculateDatesDays', { startDate: state.completeOrderData.startDate, endDate: state.completeOrderData.endDate });

        if (response.data.data) state.cartSummary = response.data.data.summary;

        dispatch('applyCouponValue');

        if (response.data.data) commit('setCalculatedDaysResponse', {response, days});

        if (state.cartSummary.total) updateCustomKey('userCartTotal', state.cartSummary.total);

        state.cartTotal = getCustomKey('userCartTotal');
    },
    async calculateEndDateHours({state, commit, dispatch, rootState}, payload) {
        state.errors = {};
        rootState.errors = {};

        let _hours = await dispatch('getTimeDiff', payload);

        payload.diff = _hours;

        let response = await axios.post('/user/calculateDatesHours', payload);

        if (response.data.data) state.cartSummary = response.data.data.summary;

        if (state.applyCouponData.coupon !== '') {
            state.coupon_discount = 0;
            state.coupon_total = 0;

            let {data} = await axios.post('/user/applyCoupon', {
                coupon: state.applyCouponData.coupon,
                startDate: payload.startDate,
                endDate: payload.endDate,
            });

            state.coupon_discount = data.data.discount;
            state.coupon_total = data.data.total;
        }

        if (response.data.data) {
            state.getCartProducts = response.data.data.products;
            state.isCartEmpty = response.data.data.products.length === 0;
            state.cartAddresses = response.data.data.addresses;
            state.cartSummaryHours = _hours;
        }

        storeCustomKey('userCartTotal', state.cartSummary.total ?? 0);

        state.cartTotal = getCustomKey('userCartTotal');
    },
    async removeGeneralProductFromCart({state, dispatch, rootState, commit}, product) {
        let {data} = await axios.post('/user/removeProductFromCart', {
            cart_id: User.auth().cart_id,
            product_id: product.id
        });
        clearCustomKey('userCartTotal');
        dispatch('getUserCart');
        product.is_in_cart = false;
        await useSwal(data.message);
    },
    async addingToCart({state, commit, rootState, dispatch}, product) {
        try {
            state.cartData.product_id = product.id;

            let response = await axios.post('/user/addProductToCart', state.cartData);

            if (response.data.data.has_address === false && response.data.data.same_city === false) {
                let result = await useSwalAddressWarning(trans('message.addAnAddressFirst'));
                if (result.isDismissed) await router.push({name: 'addresses'});
                product.is_in_cart = false;
                return;
            }

            if (response.data.data.has_address === true && response.data.data.same_city === true) {
                let result = await useSwalAddressWarning(trans('message.notInYourCity'));
                if (result.isDismissed) await router.push({name: 'addresses'});
                product.is_in_cart = false;
                return;
            }

            dispatch('getUpdatedProfile');
            dispatch('getUserCart');
            commit('updateCartTotalValue', state.cartSummary.total);
            await useSuccessSwal(response.data.message);
        } catch (e) {
            product.is_in_cart = false;
            if (e.response && e.response.status === 401) {
                $('#loginModal').modal('show');
            }
            if (e.response && e.response.status === 400) {
                await useSwalAddressWarning(trans('message.addAnAddressFirst'));
            }
        }
    },
    async calculateCartTimeDays({state, dispatch}, payload){
        state.cartSummaryHours = await dispatch('getTimeDiff', {
            startDate: payload.startDate,
            endDate: payload.endDate,
            startTime: payload.startTime,
            endTime: payload.endTime,
        });
    },
    async getTimeDiff({state}, payload){
        if (payload.startDate && payload.endDate) {
            const start = moment(payload.startDate + ' ' + payload.startTime);

            const end = moment(payload.endDate + ' ' + payload.endTime);

            return end.diff(start, 'hour');
        }
    },
    async getDaysDiff({state}, payload){
        let days = moment(payload.endDate).diff(moment(payload.startDate),'days');

        return isNaN(days) ? 0 : days;
    },
    async applyCouponValue({state}){
        if (state.applyCouponData.coupon !== '') {
            state.coupon_discount = 0;
            state.coupon_total = 0;

            let {data} = await axios.post('/user/applyCoupon', {
                coupon: state.applyCouponData.coupon,
                startDate: state.completeOrderData.startDate,
                endDate: state.completeOrderData.endDate,
            });

            state.coupon_discount = data.data.discount;
            state.coupon_total = data.data.total;
        }
    }
};
