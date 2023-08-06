export default {
    cityName(state) {
        return (state.address && state.address.city) ? state.address.city.text : null;
    },
    filteredAddresses(state) {
        return state.addresses.filter(item => item.city.id === User.auth().city_id);
    },
}
