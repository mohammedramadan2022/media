<script setup>
import {useStore} from "vuex";

const props = defineProps(['product']);
const store = useStore();
</script>

<template>
    <div class="product-item">
        <div class="img-shimmer">
            <img class="card-img-top" @click="$router.push({name: 'product-details', params: {id: product.id}})" :src="product.image" :alt="product.name" />
            <div class="spinner-border m-5" role="status"></div>
        </div>
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
                <button v-if="product.is_fave" @click="$emit('removeFromFave')" class="btn btn-fav active-wishlist border-0">
                    <i class="fa-regular fa-heart"></i>
                </button>

                <button v-else @click="$emit('addToFave')" class="btn btn-fav border-0">
                    <i class="fa-regular fa-heart"></i>
                </button>

                <span class="discount" v-if="product.has_offer">{{ product.offer }} %</span>

                <form v-if="product.is_in_cart" @submit.prevent="store.dispatch('removeGeneralProductFromCart', product)">
                    <div class="row gy-2 gy-xl-0 justify-content-center align-items-center">
                        <input type="hidden" name="quantity" value="1">
                        <div class="col-auto">
                            <button type="submit" name="submit" class="new_remove_from_cart"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                </form>
                <form v-if="!product.is_in_cart" @submit.prevent="store.dispatch('addGeneralProductToCart', product)">
                    <div class="row gy-2 gy-xl-0 justify-content-center align-items-center">
                        <input type="hidden" name="quantity" value="1">
                        <div class="col-auto">
                            <button type="submit" name="submit" class="new_add_to_cart"><i class="fa fa-cart-shopping"></i></button>
                        </div>
                    </div>
                </form>
                <button class="see-more-details" @click="$router.push({name: 'product-details', params: {id: product.id}})"><i class="far fa-eye"></i></button>
            </div>
        </div>
    </div>
</template>

<style>
#product-details .product-info form button .fa {
    font-size: 17px;
    color: #FF3D71;
}

.product-item .top-product-div {
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid #e2e2e2;
    padding-top: 10px;
}
.product-item .top-product-div button{
    font-size: 16px;
    box-shadow: 0 2px 20px #0000001a;
    border-radius: 50%;
    height: 40px;
    width: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-item .top-product-div button:hover ,
.product-item .top-product-div button:active{
    color: #dc3545;
    transition: 300ms ease;
}

.product-item .top-product-div .btn-fav:hover,
.product-item .top-product-div .btn-fav.active {
    color: #dc3545;
    transition: 300ms ease;
}

.product-item .top-product-div .discount {
    background: var(--primary-color) 0 0 no-repeat padding-box;
    color: var(--white-color);
    border-radius: 2px;
    float: left;
    padding: 0 10px;
}
.product-item .new_add_to_cart {
    border: none;
    background-color: #fff;
    font-size: 16px;
}
.product-item .new_remove_from_cart {
    border: none;
    background-color: #fff;
    font-size: 16px;
    color: #dc3545;
}
.product-item .see-more-details {
    border: none;
    background-color: #fff;
    font-size: 16px;
}

.product-item{
    position: relative;
}
.discount{
    position: absolute;
    top: 20px;
    left: 15px;
    z-index: 3;
}
.img-shimmer{
    height: 155px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}
.img-shimmer .spinner-border{
    position: absolute;
    top: 0;
}
.img-shimmer img{
    z-index: 2;
}
</style>
