export default {
    async nextFavoritesPage(state) {
        state.pagination.currentPage += 1;
    },
    async setFavoritesPaginated(state, response) {
        state.pagination = response.data.data.pagination;
        state.has_favorite_pagination = state.pagination.last_page !== state.pagination.currentPage;
    },
};
