<script setup>
import {useStore} from "vuex";

const store = useStore();
const props = defineProps(['product']);
</script>

<template>
    <!-- item 1 -->
    <div class="product-div">
        <div class="row text-center text-md-start">
            <div class="col-md-auto">
                <div class="img-div">
                    <img class="img-fluid" :src="product.image" alt="product image">
                </div>
            </div>
            <div class="col-md">
                <div class="product-info">
                    <div class="product-sections">
                        <i class="fa-solid fa-car-side"></i>
                        <span v-text="product.section.name"></span>({{product.category.name}})
                    </div>
                    <h1 v-text="product.name"></h1>

                    <div class="row justify-content-center justify-content-lg-start align-items-center mb-3">
                        <div class="col-auto">
                            <div class="product-price">
                                {{$t('message.youWillPay')}}<span>{{product.has_offer ? product.offer_value : product.price}}</span>{{$t('message.realPerDay')}}
                                <small class="ms-2" v-if="product.has_offer">{{$t('message.insteadOf')}}<span class="ms-1" v-if="product.has_offer">{{product.price}} {{$t('message.realPerDay')}}</span></small>
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
                                {{$t('message.city')}} :&nbsp;&nbsp;<span>{{ product.city.text }}</span>
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

                    <div class="row gy-2 gy-xl-0 align-items-center quantity-div">
                        <div class="col-auto">
                            <span class="title_">{{$t('message.qty')}} :</span>
                        </div>
                        <div class="col-auto">
                            <div class="value_" v-text="product.cart_qty"></div>
                        </div>
                        <div class="col" v-if="product.is_fave">
                            <button :id="'product-favorite-'+product.id" @click="$emit('removeProductFromFave')" class="btn btn-fav active border-0">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        </div>

                        <div class="col" v-else>
                            <button :id="'product-favorite-'+product.id" @click="$emit('addProductToCart')" class="btn btn-fav border-0">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of item 1 -->
</template>
