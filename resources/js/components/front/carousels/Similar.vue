<script setup>
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";
import {computed, ref} from "vue";
import {useStore} from "vuex";
import {useRouter} from "vue-router";

const store = useStore();
const router = useRouter();

let products = computed(() => store.state.product.similar);

let settings = ref({
    autoplay: "2000",
    dir: 'rtl',
    itemsToShow: 5,
    pauseAutoplayOnHover: true,
    snapAlign: 'center',
    wrapAround: true,
});

let breakpoints = {
    0: {itemsToShow: 1, snapAlign: 'center'},
    541: {itemsToShow: 2, snapAlign: 'center'},
    811: {itemsToShow: 3, snapAlign: 'start'},
    1081: {itemsToShow: 4, snapAlign: 'start'}
};

function removeProductFromFave(product) {
    store.dispatch('removeProductFromFavorites', product);
    product.is_fave = false;
}

function navigateToSingleProduct(product) {
    store.dispatch('getProductById', product.id);
    return router.push({name: 'product-details', params: {id: product.id}});
}
</script>

<template>
    <div class="col-xl-12" v-if="products.length > 0">
        <div id="most-popular-products">
            <h5>
                {{ $t('message.recommendsProducts') }}
                <router-link :to="{name: 'products'}">{{$t('message.showMore')}}&nbsp;<i class="fa fa-angle-double-left"></i></router-link>
            </h5>

            <carousel class="products-owl-carousel" :breakpoints="breakpoints" :settings="settings">
                <slide v-for="(product, index) in products" :key="index">
                    <div class="product-item">
                        <img class="card-img-top" @click.prevent="navigateToSingleProduct(product)" :src="product.image" :alt="product.name" />

                        <div class="card-body">
                            <div class="card-text">
                                <i class="fa" :class="product.section.icon"></i>
                                <span class="ms-1" v-text="product.section.name"></span>
                            </div>

                            <span class="card-title" v-text="product.name"></span>

                            <span class="card-sub-title d-flex align-items-top justify-content-between">
                                <div class="day-price">
                                    <span class="price-after d-block">{{ product.has_offer ? product.offer_value : product.price }} {{ $t('message.realPerDay') }}</span>
                                    <span class="price-before d-block" v-if="product.has_offer">{{ product.price }} {{ $t('message.realPerDay') }}</span>
                                </div>
                                <span class="price-after">{{ product.hour_price }} {{ $t('message.realPerHour')}}</span>
                            </span>

                            <div class="top-product-div">
                                <button v-if="product.is_fave" @click.prevent="store.dispatch('removeProductFromFavorites', product)" class="btn btn-fav active border-0">
                                    <i class="fa-regular fa-heart"></i>
                                </button>

                                <button v-else @click.prevent="store.dispatch('addProductToFavorites', product)" class="btn btn-fav border-0">
                                    <i class="fa-regular fa-heart"></i>
                                </button>

                                <span class="discount" v-if="product.has_offer">- {{ product.offer }} %</span>

                                <form v-if="product.is_in_cart" @submit.prevent="store.dispatch('removeGeneralProductFromCart', product)">
                                    <div class="row gy-2 gy-xl-0 justify-content-center align-items-center">
                                        <input type="hidden" name="quantity" value="1">
                                        <div class="col-auto">
                                            <button type="submit" name="submit" class="new_remove_from_cart"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <form v-else @submit.prevent="store.dispatch('addGeneralProductToCart', product)">
                                    <div class="row gy-2 gy-xl-0 justify-content-center align-items-center">
                                        <input type="hidden" name="quantity" value="1">
                                        <div class="col-auto">
                                            <button type="submit" name="submit" class="new_add_to_cart"><i class="fa fa-cart-shopping"></i></button>
                                        </div>
                                    </div>
                                </form>

                                <button class="see-more-details" @click.prevent="navigateToSingleProduct(product)"><i class="far fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                </slide>

                <template #addons>
                    <pagination />
                    <navigation />
                </template>
            </carousel>
        </div>
    </div>
</template>

<style>
#most-popular-products .product-item .top-product-div {
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid #e2e2e2;
    padding-top: 10px;
}
#most-popular-products .product-item .top-product-div button{
    font-size: 16px;
    box-shadow: 0 2px 20px #0000001a;
    border-radius: 50%;
    height: 40px;
    width: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#most-popular-products .product-item .top-product-div button:hover ,
.product-item .top-product-div button:active{
    color: #dc3545;
    transition: 300ms ease;
}

.product-item .top-product-div .btn-fav:hover,
.product-item .top-product-div .btn-fav.active {
    color: #dc3545;
    transition: 300ms ease;
}

#most-popular-products .product-item .top-product-div .discount {
    background: var(--primary-color) 0 0 no-repeat padding-box;
    color: var(--white-color);
    border-radius: 2px;
    float: left;
    padding: 0 10px;
}
#most-popular-products .product-item .new_add_to_cart {
    border: none;
    background-color: #fff;
    font-size: 16px;
}

#most-popular-products .product-item .new_remove_from_cart {
    border: none;
    background-color: #fff;
    font-size: 16px;
    color: #dc3545;
}
#most-popular-products .product-item .see-more-details {
    border: none;
    background-color: #fff;
    font-size: 16px;
}
</style>
