import {useConfirmationSwal, useSwal} from "@/composables/useSwal";

export default {
    async getAllFavorites({state, rootState, commit}) {
        rootState.isLoading = true;
        let response = await axios.get('/user/getUserFavorites?page=1');
        state.getAllFavorites = response.data.data.data;
        commit('setFavoritesPaginated', response);
        rootState.isLoading = false;
    },
    async getFavoritesNextPage({state, rootState, commit}) {
        rootState.isLoading = true;
        commit('nextFavoritesPage');
        let response = await axios.get('/user/getUserFavorites?page=' + state.pagination.currentPage);
        state.getAllFavorites = state.getAllFavorites.concat(response.data.data.data);
        commit('setFavoritesPaginated', response);
        rootState.isLoading = false;
    },

    async setUserProductFave({state, rootState}, product_id) {
        let selector = $('#product-favorite-'+product_id);

        if(!selector.hasClass('active')) {
            let response = await axios.post('/user/setOrRemoveUserProductFavorite',{product_id: product_id, type: 'add'});
            if(response.data.status) {
                selector.addClass('active');
                await useSwal(response.data.message);
            }
        }
    },
    async addProductToFavorites({state, rootState}, product) {
        try {
            let {data} = await axios.post('/user/setOrRemoveUserProductFavorite',{product_id: product.id, type: 'add'});
            if(data.status) {
                product.is_fave = true;
                await useSwal(data.message);
            }
        } catch (e) {
            product.is_fave = false;
        }
    },

    async removeFromFavorites({state, rootState, dispatch}, product) {
        let result = await useConfirmationSwal(trans('message.confirmDeleteFavoriteProduct'));
        if (!result.isConfirmed) return;
        await axios.post('/user/setOrRemoveUserProductFavorite',{product_id: product.id, type: 'remove'});
        $('#favorite-id-' + product.id).fadeOut();
        dispatch('getAllFavorites');
    },
    async removeProductFromFavorites({state, rootState, dispatch}, product) {
        let result = await useConfirmationSwal(trans('message.confirmDeleteFavoriteProduct'));
        if (!result.isConfirmed) return;
        await axios.post('/user/setOrRemoveUserProductFavorite',{product_id: product.id, type: 'remove'});
        product.is_fave = false;
    }
};
