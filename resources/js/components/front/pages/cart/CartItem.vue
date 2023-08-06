<script setup>
import {useStore} from "vuex";

const store = useStore();
const props = defineProps(['product']);

function incrementProductQty(product){
    store.commit('incrementProductQtyValue', product);
    store.dispatch('changeProductQty',{product:product});
}

function decrementProductQty(product){
    store.commit('decrementProductQtyValue', product);
    store.dispatch('changeProductQty',{product:product});
}
</script>

<template>
    <div class="product-div" :id="'product-div-id-'+product.id">
        <div class="row text-center text-md-start">
            <div class="col-md-auto">
                <div class="img-div">
                    <img @click="$router.push({name: 'product-details', params: {id: product.id}})" class="img-fluid product-img" :src="product.image" :alt="product.name">
                </div>
            </div>
            <div class="col-md">
                <div class="product-info">
                    <div class="product-sections">
                        <i class="fa-solid" :class="product.section.icon"></i>
                        <span v-text="product.section.name"></span>({{product.category.name}})
                    </div>

                    <h1 @click="$router.push({name: 'product-details', params: {id: product.id}})" class="product-img" v-text="product.name"></h1>

                    <div class="row justify-content-center justify-content-lg-start align-items-center mb-3">
                        <div class="col-auto">
                            <div class="product-price">
                                {{$t('message.youWillPay')}}<span>{{product.has_offer ? product.offer_value : product.price}}</span>{{$t('message.realPerDay')}}
                                <small class="ms-2" v-if="product.has_offer">{{$t('message.insteadOf')}}<span class="ms-1" v-if="product.has_offer">{{product.price}} {{$t('message.real')}}</span></small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="product-price">
                                <span class="me-1">/</span><span>{{product.hour_price}}</span>{{ $t('message.realPerHour') }}
                            </div>
                        </div>

                        <div class="col-auto">
                            <div class="product-city">
                                <i class="fa fa-location-dot"></i>&nbsp;
                                {{$t('message.city')}} :&nbsp;&nbsp;<span v-text="product.city.text"></span>
                            </div>
                        </div>

                        <div class="col-auto">
                            <div class="product-rate">
                                <i class="fa fa-star"></i>&nbsp;{{product.rate}}&nbsp;
                                <span>({{product.rate_count}})</span>&nbsp;&nbsp;
                                <a href="javascript:void(0);">{{product.rate_count}} {{$t('message.rates')}}</a>
                            </div>
                        </div>
                    </div>

                    <div class="row gx-2 gy-2 gy-xl-0 align-items-center">
                        <div class="col-auto" v-if="product.qty > 0">
                            <form @submit.prevent="store.dispatch('removeProductFromCart', product.id)">
                                <div class="row gy-2 gy-xl-0 justify-content-center align-items-center">
                                    <div class="col-auto">
                                        <div class="row align-items-center">
                                            <label for="quantity" class="form-label col-auto">{{$t('message.qty')}}:</label>
                                            <div class="d-flex align-items-center justify-content-start">
                                                <button
                                                    type="button"
                                                    class="quantity-btn"
                                                    @click.prevent="incrementProductQty(product)"
                                                    :disabled="parseInt(product.cart_qty) >= parseInt(product.qty)">+</button>
                                                <span class="quantity-span" :id="'quantity-span-' + product.id" v-text="product.cart_qty"></span>
                                                <button
                                                    type="button"
                                                    class="quantity-btn"
                                                    @click.prevent="decrementProductQty(product)"
                                                    :disabled="parseInt(product.cart_qty) <= 1">-</button>
                                            </div>
<!--                                            <input-->
<!--                                                :value="product.cart_qty"-->
<!--                                                @change="store.dispatch('changeProductQty',{product:product, currentInput: this, value:$event.target.value})"-->
<!--                                                type="number" min="1"-->
<!--                                                :max="product.qty ?? 1"-->
<!--                                                class="form-control col"-->
<!--                                                :id="'quantity' + product.id"-->
<!--                                                :placeholder="$t('message.qty')">-->
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <button type="submit" name="submit" class="btn btn-danger2"><i class="fa fa-times"></i>&nbsp;&nbsp;{{$t('message.removeFromCart')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-auto" v-else>
                            <form @submit.prevent="store.dispatch('replaceProductFromCart', product.id)">
                                <div class="row gy-2 gy-xl-0 align-items-center">
                                    <div class="col-auto">
                                        <span class="text-warning2" v-text="$t('message.theProductIsNotAvailable')"></span>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-warning2">
                                            <i class="fa fa-recycle"></i>&nbsp;&nbsp;{{$t('message.replaceProduct')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col" v-if="product.is_fave">
                            <button :id="'product-favorite-'+product.id" @click="$emit('removeProductFromFave')" class="btn btn-fav active border-0">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        </div>

                        <div class="col" v-else>
                            <button :id="'product-favorite-'+product.id" @click="$emit('addProductToFavoritesList')" class="btn btn-fav border-0">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .product-img:hover {
        cursor: pointer;
    }
</style>
