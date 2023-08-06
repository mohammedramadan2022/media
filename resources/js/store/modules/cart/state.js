import {getCustomKey, getJsonCustomKey} from "@/composables/useStorage";
import User from "@/libs/User";

export default {
    getCartProducts: [],
    cartSummary: {
        total: 0,
        subtotal: 0,
        total_insurance: 0,
        total_advance_amount: 0,
        tax: 0
    },
    hourlyCartSummary: {
        total: '',
        subtotal: '',
        total_insurance: '',
        total_advance_amount: '',
        tax: ''
    },
    cartSummaryCurrentDays: 0,
    rentingSystemType: getCustomKey('sysType') !== 'undefined' ? getCustomKey('sysType') : 'day',
    cartSummaryDays: 0,
    cartSummaryHours: 0,
    cartProductCount: getCustomKey('cartCount') !== 'undefined' ? getCustomKey('cartCount') : '0',
    applyCouponData: {
        startDate: '',
        endDate: '',
        coupon: '',
    },
    isCartEmpty: true,
    cartTotal: getCustomKey('userCartTotal') !== 'undefined' ? getCustomKey('userCartTotal') : '0',
    cartData: {
        quantity: 1,
        product_id: '',
    },
    cartSummaryData: {
        startDate: getJsonCustomKey('cartSummary') ? getJsonCustomKey('cartSummary').startDate : '',
        startTime: getJsonCustomKey('cartSummary') ? getJsonCustomKey('cartSummary').startTime : '',
        endDate: getJsonCustomKey('cartSummary') ? getJsonCustomKey('cartSummary').endDate : '',
        endTime: '--:-- --'
    },
    cartHourlySummaryData: {
        startDate: getJsonCustomKey('cartSummary') ? getJsonCustomKey('cartSummary').startDate : '',
        startTime: getJsonCustomKey('cartSummary') ? getJsonCustomKey('cartSummary').startTime : '',
        endDate: getJsonCustomKey('cartSummary') ? getJsonCustomKey('cartSummary').endDate : '',
        endTime: getJsonCustomKey('cartSummary') ? getJsonCustomKey('cartSummary').endTime : ''
    },
    completeOrderData: {
        startDate: getJsonCustomKey('cartSummary') ? getJsonCustomKey('cartSummary').startDate : '',
        startTime: getJsonCustomKey('cartSummary') ? getJsonCustomKey('cartSummary').startTime : '',
        endDate: getJsonCustomKey('cartSummary') ? getJsonCustomKey('cartSummary').endDate : '',
        endTime: getJsonCustomKey('cartSummary') ? getJsonCustomKey('cartSummary').endTime : '',
        delivery_type: 'address',
        address_id: User.auth() !== null ? User.auth().address_id : 0,
        coupon: '',
    },
    errors: {
        startData: null,
        startTime: null,
        endDate: null,
        endTime: null
    },
    is_applied: false,
    coupon_discount: 0,
    coupon_total: 0,
    cartAddresses: [],
    timesList: [
        {key: '00:00', value: '12:00 AM'},
        {key: '01:00', value: '01:00 AM'},
        {key: '02:00', value: '02:00 AM'},
        {key: '03:00', value: '03:00 AM'},
        {key: '04:00', value: '04:00 AM'},
        {key: '05:00', value: '05:00 AM'},
        {key: '06:00', value: '06:00 AM'},
        {key: '07:00', value: '07:00 AM'},
        {key: '08:00', value: '08:00 AM'},
        {key: '09:00', value: '09:00 AM'},
        {key: '10:00', value: '10:00 AM'},
        {key: '11:00', value: '11:00 AM'},
        {key: '12:00', value: '12:00 PM'},
        {key: '13:00', value: '01:00 PM'},
        {key: '14:00', value: '02:00 PM'},
        {key: '15:00', value: '03:00 PM'},
        {key: '16:00', value: '04:00 PM'},
        {key: '17:00', value: '05:00 PM'},
        {key: '18:00', value: '06:00 PM'},
        {key: '19:00', value: '07:00 PM'},
        {key: '20:00', value: '08:00 PM'},
        {key: '21:00', value: '09:00 PM'},
        {key: '22:00', value: '10:00 PM'},
        {key: '23:00', value: '11:00 PM'},
    ],
};
