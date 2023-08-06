import {useSortByDesc} from "@/composables/useHelper";

export default {
    async nextPage(state) {
        state.currentPage += 1;
    },
    async setPaginated(state, response) {
        state.pagination = response.data.data.pagination;
        state.has_pagination = state.pagination.last_page !== state.pagination.currentPage;
    },
    async setStoreOptionsPaginated(state, response) {
        state.pagination = response.data.data.pagination;
        state.has_options_pagination = state.pagination.last_page !== state.pagination.currentPage;
    },
    async filterStoreProducts(state, sort_by) {
        state.has_pagination = false;
        state.allProducts = state.allProducts.sort(useSortByDesc(sort_by));
    },
};
