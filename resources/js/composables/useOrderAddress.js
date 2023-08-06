import moment from "moment/moment";

export function setAddressDefault(address) {
    store.dispatch('changeDefaultAddress', address);
    store.commit('setAddressDefaultValue', address.id);
}

export function showAllAddresses() {
    store.state.errors = {};
    $('#edit-address-div').addClass('d-none');
    $('#show-addresses-div').removeClass('d-none');
}

export function showEditAddress(address) {
    store.dispatch('getAddressById', address.id);
    $('#deliver-div').addClass('d-none');
    $('#add-address-div').addClass('d-none');
    $('#edit-address-div').removeClass('d-none');
    $('#show-addresses-div').addClass('d-none');
}

export function showAddAddress() {
    store.state.address.addressData = {};
    $('#deliver-div').addClass('d-none');
    $('#show-addresses-div').addClass('d-none');
    $('#add-address-div').removeClass('d-none');
    $('#edit-address-div').addClass('d-none');
}

export function changeFromLocation(type, order) {
    if (type === 'address') {
        store.commit('changeOrderAddressDeliveryType', 'address');

        let addresses_length = order.addresses.length;

        if (addresses_length === 0) $('#deliver-div').removeClass('d-none');

        if (addresses_length > 0) {
            $('#show-addresses-div').removeClass('d-none');
            $('#from-location-div').addClass('d-none');
            $('#deliver-div').addClass('d-none');
        }
    } else {
        store.commit('changeOrderAddressDeliveryType', 'location');

        if (order.addresses.length > 0) {
            $('#show-addresses-div').addClass('d-none');
            $('#from-location-div').removeClass('d-none');
            $('#deliver-div').addClass('d-none');
        }
    }
}

export function getDeliveryType(type) {
    return type === 'location' ? trans('message.receiptFromLocation') : trans('message.delivery');
}

export function getDeliveryTitle(type) {
    return type === 'location' ? trans('message.deliveryAddresses') : trans('message.deliverAddress');
}

export function convertDate(date, format = 'YYYY/MM/DD') {
    return moment(date).format(format);
}

export function convertTime(date) {
    return moment(date).format('hh:mm A');
}
