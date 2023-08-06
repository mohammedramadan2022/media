import {clearCustomKey, getJsonCustomKey, updateCustomKey} from "@/composables/useStorage";
import moment from "moment/moment";

export default {
    async updateCartSummary(state) {
        state.cartSummaryData.startDate = getJsonCustomKey('cartSummary').startDate;
        state.cartSummaryData.startTime = getJsonCustomKey('cartSummary').startTime;
        state.cartSummaryData.endDate = getJsonCustomKey('cartSummary').endDate;
        state.cartSummaryData.endTime = getJsonCustomKey('cartSummary').endTime;
    },
    async updateCompleteCartSummary(state) {
        state.completeOrderData.startDate = getJsonCustomKey('cartSummary').startDate;
        state.completeOrderData.startTime = getJsonCustomKey('cartSummary').startTime;
        state.completeOrderData.endDate = getJsonCustomKey('cartSummary').endDate;
        state.completeOrderData.endTime = getJsonCustomKey('cartSummary').endTime;
    },
    async updateDeliveryType(state, value){
        state.completeOrderData.delivery_type = value;
    },
    async setAddressDefaultValue(state, value) {
        state.completeOrderData.address_id = value;
    },
    async setCartStartDateValue(state, value){
        state.completeOrderData.startDate = value;
    },
    async resetCartSummary(state){
        state.startDate = '';
        state.startTime = '';
        state.endTime = '';
        state.endDate = '';
        state.completeOrderData.startDate = '';
        state.completeOrderData.startTime = '';
        state.completeOrderData.endDate = '';
        state.completeOrderData.endTime = '';
        clearCustomKey('cartSummary');
        clearCustomKey('hourlyCartSummary');
        updateCustomKey('userCartTotal', '00:00');
        updateCustomKey('cartCount', '0');
    },
    async updateCartTotalValue(state, value){
        state.cartTotal = value;
    },
    async updateCartCountValue(state, value){
        state.cartProductCount = value;
    },
    async setEndTimeValue(state, value){
        state.cartSummaryData.endTime = moment(value,"HH:mm").format('h:mm A');
    },
    async setEndTimeFromCompleteValue(state, value){
        state.completeOrderData.endTime = value;
    },
    async setRentingSystemType(state, value){
        state.rentingSystemType = value;
        updateCustomKey('sysType', state.rentingSystemType);
    },
    async setDefaultCartSummary(state){
        state.cartSummary = {
            total: '',
            subtotal: '',
            total_insurance: '',
            total_advance_amount: '',
            tax: ''
        };
    },
    async setCalculatedDaysResponse(state, {response, days}){
        state.getCartProducts = response.data.data.products;
        state.isCartEmpty = response.data.data.products.length === 0;
        state.cartAddresses = response.data.data.addresses;
        state.cartSummaryDays = days;
    },
    async incrementProductQtyValue(state, product){
        product.cart_qty++;
    },
    async decrementProductQtyValue(state, product){
        product.cart_qty--;
    },
};
