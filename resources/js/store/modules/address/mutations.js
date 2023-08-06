export default {
    async setAddressData(state, address) {
        state.addressData.recipient_name = address.recipient_name ?? '';
        state.addressData.street = address.street ?? '';
        state.addressData.phone = address.phone ?? '';
        state.addressData.city_id = address.city ? address.city.id : '';
        state.addressData.map_url = address.city ? address.map_url : '';
        state.addressData.special_marque = address.special_marque ?? '';
    },
    async setOrderAddressDeliveryType(state, order) {
        state.orderAddressData.delivery_type = order.delivery_type;
    },
    async changeOrderAddressDeliveryType(state, delivery_type) {
        state.orderAddressData.delivery_type = delivery_type;
    },
    async setAddressItemStyle(state, address_id){
        $('#deliver-way #show-addresses-div .address-item .address-item-title .form-check ' + '#address-' + User.auth().address_id + ' .form-check-input:checked').removeAttr('checked');
        $('span#custom-check-icon-js-' + User.auth().address_id).append(``);
        $('span#custom-check-icon-js-' + address_id).append(`<i class="fa-solid fa-circle-check" style=" color: #8c9173; font-size: 22px; margin: auto; position: absolute; top: 2px; left: 0; bottom: 0; right: 0; "></i>`);
    }
};
