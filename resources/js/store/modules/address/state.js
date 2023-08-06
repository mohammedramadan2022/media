import {getCustomKey} from "@/composables/useStorage";

export default {
    addressData: {
        recipient_name: '',
        street: '',
        phone: '',
        city_id: 0,
        special_marque: '',
        map_url: '',
    },
    addresses: [],
    address: {},
    addressDefaultData: {},
    orderAddressData: {
        order_id: 0,
        address_id: null,
        delivery_type: '',
    },
    userCartTotal: parseInt(getCustomKey('userCartTotal')) ?? 0,
};
