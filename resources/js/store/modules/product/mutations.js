import {useSortByDesc} from "@/composables/useHelper";

export default {
    async nextProductsPage(state) {
        state.pagination.currentPage += 1;
    },
    async nextPopularsPage(state) {
        state.pagination.currentPage += 1;
    },
    async nextSectionProductsPage(state) {
        state.pagination.currentPage += 1;
    },
    async setProductsPaginated(state, response) {
        state.pagination = response.data.data.pagination;
    },
    async setSectionProductsPaginated(state, response) {
        state.pagination = response.data.data.pagination;
        state.has_section_pagination = state.pagination.last_page !== state.pagination.currentPage;
    },
    async filterProducts(state, sort_by) {
        state.has_pagination = false;
        state.has_filter_pagination = true;
        state.has_category_pagination = false;
        state.allProducts = state.allProducts.sort(useSortByDesc(sort_by));
    },
    async filterOfferedProducts(state, sort_by) {
        state.has_pagination = false;
        state.allProducts = state.allProducts.sort(useSortByDesc(sort_by));
    },
    async resetAllProducts(state) {
        state.allProducts = [];
        state.has_filter_pagination = false;
        state.has_pagination = false;
        state.has_category_pagination = false;
    },
    async setPaginationToFilter(state) {
        state.has_pagination = false;
        state.has_category_pagination = false;
        state.has_filter_pagination = state.pagination.last_page !== state.pagination.currentPage;
    },
    async setPaginationToCategory(state) {
        state.has_filter_pagination = false;
        state.has_pagination = false;
        state.has_category_pagination = state.pagination.last_page !== state.pagination.currentPage;
    },
    async setPaginationToSection(state) {
        state.has_filter_pagination = false;
        state.has_pagination = false;
        state.has_section_pagination = state.pagination.last_page !== state.pagination.currentPage;
    },
    async setPopularsPaginated(state, response) {
        state.pagination = response.data.data.pagination;
        state.has_popular_pagination = state.pagination.last_page !== state.pagination.currentPage;
    },
    async setOffersPaginated(state, response) {
        state.pagination = response.data.data.pagination;
        state.has_offers_pagination = state.pagination.last_page !== state.pagination.currentPage;
    },
    async setOptionsPaginated(state, response) {
        state.pagination = response.data.data.pagination;
        state.has_options_pagination = state.pagination.last_page !== state.pagination.currentPage;
    },
    async setHasPagination(state) {
        state.has_filter_pagination = false;
        state.has_category_pagination = false;
        state.has_popular_pagination = false;
        state.has_options_pagination = false;
        state.has_section_pagination = false;
        state.has_pagination = state.pagination.last_page !== state.pagination.currentPage;
    },
};
