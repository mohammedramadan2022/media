export default {
    async changeLange(state, language) {
        state.lang = language;
        i18n.global.locale.value = language;
        localStorage.setItem('lang', state.lang);

        let htmlEl = document.querySelector("html");
        htmlEl.setAttribute('dir', state.lang === 'ar' ? 'rtl' : 'ltr');
        htmlEl.setAttribute('lang', state.lang);

        $('#lang-dropdown').dropdown("toggle");

        window.location.reload();
    },
    async setFile(state, e) {
        state.joinRentalRequestData.logo = e;
    },
    async fillFormData(state){
        let formData = new FormData();

        formData.append('name', state.joinRentalRequestData.name);
        formData.append('email', state.joinRentalRequestData.email);
        formData.append('phone', state.joinRentalRequestData.phone);
        formData.append('identity', state.joinRentalRequestData.identity);
        formData.append('address', state.joinRentalRequestData.address);
        formData.append('store_name', state.joinRentalRequestData.store_name);
        formData.append('logo', state.joinRentalRequestData.logo);
        formData.append('terms', state.joinRentalRequestData.terms);
        formData.append('city_id', state.joinRentalRequestData.city_id);

        state.formData = formData;
    },
    async fillHome(state, response) {
        state.home.banners = response.data.data.banners;
        state.home.cities = response.data.data.cities;
        state.home.sections = response.data.data.sections;
        state.home.stores = response.data.data.stores;
        state.home.previews = response.data.data.previews;
        state.home.features = response.data.data.features;
        state.home.popular = response.data.data.popular;
        state.isLoading = false;
    },
    async setSectionId(state, sectionId) {
        state.sectionId = sectionId;
    },
};
