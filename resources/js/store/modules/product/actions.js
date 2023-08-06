export default {
    async getAllProducts({state, rootState, commit}) {
        rootState.isLoading = true;
        let response = await axios.get('/getAllProducts?page=1');
        state.allProducts = response.data.data.data;
        commit('setProductsPaginated', response);
        commit('setHasPagination');
        rootState.isLoading = false;
    },
    async getPopularProducts({state, rootState, commit}) {
        rootState.isLoading = true;
        let response = await axios.get('/user/getPopularProducts?page=1');
        state.allPopular = response.data.data.data;
        commit('setPopularsPaginated', response);
        rootState.isLoading = false;
    },
    async getProductsByCityId({state, rootState, commit}, city_id) {
        let page = 1;
        rootState.isLoading = true;
        state.allProducts = [];
        let response = await axios.post('/getProductsByCityId',{city_id, page});
        state.allProducts = response.data.data.data;
        commit('setProductsPaginated', response);
        commit('setHasPagination');
        rootState.isLoading = false;
    },
    async getProductsByCategoryId({state, commit, rootState}, category_id) {
        let page = 1;
        rootState.isLoading = true;
        commit('resetAllProducts');
        state.byCategory = true;
        state.category_id = category_id;
        let response = await axios.post('/getProductsByCategoryId',{category_id, page});
        state.allProducts = response.data.data.data;
        commit('setProductsPaginated', response);
        commit('setPaginationToCategory');
        rootState.isLoading = false;
    },
    async getProductsBySectionId({state, rootState, commit}, section_id) {
        rootState.isLoading = true;
        state.allProducts = [];
        let response = await axios.post('/getProductsBySectionId',{section_id: section_id, page: 1});
        state.allProducts = response.data.data.data;
        commit('setSectionProductsPaginated', response);
        commit('setPaginationToSection');
        rootState.isLoading = false;
    },
    async getDefaultSpecForSection({state, rootState, commit}, section_id) {
        rootState.isLoading = true;
        state.allSpecs = [];
        let response = await axios.post('/getDefaultSpecForSection', {section_id});
        state.allSpecs = response.data.data;
        rootState.isLoading = false;
    },
    async getAbsoluteSpec({state, rootState}) {
        rootState.isLoading = true;
        state.allSpecs = [];
        let response = await axios.get('/getAbsoluteSpec');
        state.allSpecs = response.data.data.specs;
        state.category_id = response.data.data.category_id;
        rootState.isLoading = false;
    },
    async getSpecsByCategoryId({state, rootState, commit}, category_id) {
        rootState.isLoading = true;
        state.allSpecs = [];
        store.state.product.options = [];
        let response = await axios.post('/getSpecsByCategoryId', {category_id});
        state.allSpecs = response.data.data;
        rootState.isLoading = false;
    },
    async getProductById({state, rootState}, product_id) {
        rootState.isLoading = true;
        state.getProduct = {};
        state.similar = [];
        let response = await axios.post('/user/getProductById',{product_id});
        state.getProduct = response.data.data.product;
        state.similar = response.data.data.similar;
        rootState.isLoading = false;
    },
    async setUserProductRate({state, rootState, dispatch}, product_id) {
        rootState.isLoading = true;
        state.rateData.product_id = product_id;
        state.rateData.user_id = User.auth().id;
        state.rateData.rate = $('input[name=rate]').val();

        await axios.post('/user/setUserProductRate', state.rateData);

        state.rateData = {};
        state.errors = {};

        dispatch('getProductById', product_id);
        $('#rateModal').modal('hide');
        rootState.isLoading = false;
    },
    async getProductsNextPage({state, rootState, commit}) {
        rootState.isLoading = true;
        commit('nextProductsPage');
        let response = await axios.get('/getAllProducts?page=' + state.pagination.currentPage);
        state.allProducts = state.allProducts.concat(response.data.data.data);
        commit('setProductsPaginated', response);
        commit('setHasPagination');
        rootState.isLoading = false;
    },
    async getPopularsNextPage({state, rootState, commit}) {
        rootState.isLoading = true;
        commit('nextPopularsPage');
        let response = await axios.get('/user/getPopularProducts?page=' + state.pagination.currentPage);
        state.allPopular = state.allPopular.concat(response.data.data.data);
        commit('setPopularsPaginated', response);
        rootState.isLoading = false;
    },

    async getSectionWithCategories({state, rootState}) {
        rootState.isLoading = true;
        let response = await axios.get('/getSectionWithCategories');
        state.sections = response.data.data;
        rootState.isLoading = false;
    },

    async getFilteredProducts({state, commit, rootState}) {
        rootState.isLoading = true;
        state.allProducts = [];
        let response = await axios.post('/filterProducts', state.productsFilterData);
        state.allProducts = response.data.data.data;
        commit('setPaginationToFilter');
        rootState.isLoading = false;
    },
    async getFilteredOffers({state, commit, rootState}) {
        rootState.isLoading = true;
        state.allProducts = [];
        state.productsFilterData.has_offer = true;
        let response = await axios.post('/filterProducts', state.productsFilterData);
        state.allProducts = response.data.data;
        commit('setProductsPaginated', response);
        rootState.isLoading = false;
    },
    async filterByCategory({state, rootState, dispatch}, category_id) {
        rootState.isLoading = true;
        state.allProducts = state.allProducts.filter(item => parseInt(item.category.id) === parseInt(category_id));
        if (state.allProducts.length === 0) dispatch('getAllProducts');
        rootState.isLoading = false;
    },
    async getAllOffers({state, commit, rootState}) {
        rootState.isLoading = true;
        let response = await axios.get('/getAllOffers?page=1');
        state.allProducts = response.data.data.data;
        commit('setOffersPaginated', response);
        rootState.isLoading = false;
    },

    async getCityNextPage({state, rootState, commit}, city_id) {
        rootState.isLoading = true;
        commit('nextProductsPage');
        let response = await axios.post('/getProductsByCityId', {city_id, page: state.pagination.currentPage});
        state.allProducts = state.allProducts.concat(response.data.data.data);
        commit('setProductsPaginated', response);
        commit('setHasPagination');
        rootState.isLoading = false;
    },
    async getCategoryNextPage({state, rootState, commit}, category_id) {
        rootState.isLoading = true;
        commit('nextProductsPage');
        let response = await axios.post('/getProductsByCategoryId', {category_id, page: state.pagination.currentPage});
        state.allProducts = state.allProducts.concat(response.data.data.data);
        commit('setProductsPaginated', response);
        rootState.isLoading = false;
    },
    async getSectionNextPage({state, rootState, commit}, section_id) {
        rootState.isLoading = true;
        commit('nextSectionProductsPage');
        let response = await axios.post('/getProductsBySectionId', {section_id, page: state.pagination.currentPage});
        state.allProducts = state.allProducts.concat(response.data.data.data);
        commit('setSectionProductsPaginated', response);
        rootState.isLoading = false;
    },
    async getOffersNextPage({state, rootState, commit}) {
        rootState.isLoading = true;
        commit('nextProductsPage');
        let response = await axios.get('/getAllOffers?page=' + state.pagination.currentPage);
        state.allProducts = state.allProducts.concat(response.data.data.data);
        commit('setOffersPaginated', response);
        rootState.isLoading = false;
    },
    async getOptionsNextPage({state, rootState, commit}) {
        rootState.isLoading = true;
        commit('nextProductsPage');
        let response = await axios.post('/getProductsByOptionId', {page: state.pagination.currentPage, options: state.options});
        state.allProducts = state.allProducts.concat(response.data.data.data);
        commit('setOptionsPaginated', response);
        rootState.isLoading = false;
    },
    async getFilteredProductsNextPage({state, rootState, commit}) {
        rootState.isLoading = true;
        commit('nextProductsPage');
        let response = await axios.get('/filterProducts?page=' + state.pagination.currentPage);
        state.allProducts = state.allProducts.concat(response.data.data.data);
        commit('setProductsPaginated', response);
        commit('setPaginationToFilter');
        rootState.isLoading = false;
    },
    async getCategoryProductsNextPage({state, rootState, commit}) {
        rootState.isLoading = true;
        let page = state.pagination.currentPage + 1;
        let category_id = state.category_id;
        commit('nextProductsPage');
        let response = await axios.post('/getProductsByCategoryId',{category_id, page});
        state.allProducts = state.allProducts.concat(response.data.data.data);
        commit('setProductsPaginated', response);
        commit('setPaginationToCategory');
        rootState.isLoading = false;
    },
    async getProductsByOptionId({state, commit, dispatch, rootState}, payload){
        state.allProducts = [];

        if (state.options.some(id => id === payload.type_id)) {
            state.options.splice(state.options.indexOf(payload.type_id),1);
        } else {
            state.options.push(payload.type_id);
        }

        let response = await axios.post('/getProductsByOptionId', {
            options: state.options,
            category_id: payload.category_id,
            belongs_to: 'rental',
            page: 1
        });

        state.allProducts = response.data.data.data;

        if (state.allProducts.length === 0)
        {
            if (payload.from === 'products') dispatch('getAllProducts');
            else if (payload.from === 'section') dispatch('getProductsBySectionId', payload.currentRoute.params.id);
            else if (payload.from === 'city') dispatch('getProductsByCityId', payload.currentRoute.params.id);
            else if (payload.from === 'offers') dispatch('getAllOffers');
        }

        commit('setOptionsPaginated', response);
    },
};
