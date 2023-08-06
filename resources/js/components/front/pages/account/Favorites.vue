<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import ProfileSideMenu from "@/components/front/includes/ProfileSideMenu";

import {useRouter} from "vue-router";
import {computed} from "vue";
import {useStore} from "vuex";

const {push} = useRouter();
const store = useStore();

store.dispatch('getAllFavorites');

let products = computed(() => store.state.favorite.getAllFavorites);
let has_favorite_pagination = computed(() => store.state.favorite.has_favorite_pagination);
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'favorites'}" v-text="$t('message.myFavorites')"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content" class="my-account favorite">
            <div class="container">
                <div class="row gy-3 gy-lg-0">
                    <!-- menu -->
                    <div class="col-lg-3"><ProfileSideMenu/></div>

                    <!-- data -->
                    <div class="col-lg-9">
                        <div class="data" v-if="products.length > 0">
                            <div class="product-div" v-for="product in products" :key="product.id" :id="'favorite-id-'+product.id">
                                <div class="row text-center text-md-start">
                                    <div class="col-md-auto">
                                        <div class="img-div">
                                            <img class="img-fluid" :src="product.image" alt="product image">
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="product-info">
                                            <div class="d-xl-flex d-lg-flex d-md-flex align-items-center justify-content-between">
                                                <div>
                                                    <div class="product-sections">
                                                        <i class="fa-solid" :class="product.section.icon"></i>
                                                        <span v-text="product.section.name"></span>({{product.category.name}})
                                                    </div>
                                                    <h1 v-text="product.name"></h1>
                                                </div>
                                                <a href="javascript:void(0);" @click.prevent="store.dispatch('removeFromFavorites', product)" class="remove-fav">
                                                    <div><i class="fa-solid fa-trash"></i></div>
                                                </a>
                                            </div>
                                            <div class="row justify-content-center justify-content-lg-start align-items-center mb-3">
                                                <div class="col-auto">
                                                    <div class="product-price">{{$t('message.youWillPay')}}<span>{{product.has_offer ? product.offer_value : product.price}}</span>{{$t('message.realPerDay')}}<small class="ms-2" v-if="product.has_offer">{{$t('message.insteadOf')}}<span class="ms-1" v-if="product.has_offer">{{product.price}} {{ $t('message.realPerDay') }}</span></small></div>
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
                                                        <a href="#">{{product.rate_count}} {{$t('message.rates')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data" v-else>
                            <div class="alert alert-info text-center" v-text="$t('message.noProducts')"></div>
                        </div>
                    </div>

                    <!-- show getProductsNextPage more -->
                    <div class="text-center" style="margin-top: 25px; margin-right: 180px;" v-if="has_favorite_pagination">
                        <a href="javascript:void(0);" @click.prevent="store.dispatch('getFavoritesNextPage')" class="show-more-link">
                            {{$t('message.loadMore')}}<i class="fa fa-arrow-down ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </app-layout>
</template>

<style scoped>
    .text-warning3 {
        font-size: 16px;
        line-height: 30px;
        color: #FA9600;
    }
</style>