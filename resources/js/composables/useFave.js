export function removeFromFave(product){
    store.dispatch('removeProductFromFavorites', product);
    product.is_fave = false;
}

export function addToFave(product){
    store.dispatch('addProductToFavorites', product);
    product.is_fave = true;
}

// ===========================================================

export function removeProductFromFave(product) {
    store.dispatch('removeProductFromFavorites', product);
}

export function addProductToFavoritesList(product) {
    store.dispatch('addProductToFavorites', product);
}
