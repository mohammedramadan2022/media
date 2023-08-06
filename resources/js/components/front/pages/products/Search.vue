<script setup>
import {computed} from "vue";
import AppLayout from "@/components/front/layout/AppLayout";
import {useStore} from "vuex";
import SingleProduct from "@/components/front/includes/SingleProduct";
import SectionsWithCategories from "@/components/front/includes/SectionsWithCategories";
import {useGetImage} from "@/composables/useHelper";

const store = useStore();

store.dispatch('getAllProducts');
store.dispatch('getSectionWithCategories');

let cities = computed(() => store.state.getAllCities);
let allProducts = computed(() => store.state.product.allProducts);
let sections = computed(() => store.state.product.sections);
let pagination = computed(() => store.state.product.pagination);
let has_pagination = computed(() => store.state.product.has_pagination);
let filterData = computed(() => store.state.product.filterData);
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item">البحث</li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">توسان</a></li>
        </template>

        <!-- content -->
        <section id="content">
            <div class="container">
                <div class="row gy-3 gy-xl-0">
                    <!-- sections filter -->
                    <div class="col-xl-3">
                        <sections-with-categories :sections="sections">
                            <router-link :to="{name: 'offers'}" class="offers">
                                <img :src="useGetImage('front/assets/images/icons/offers.svg')" alt="offers icon" class="me-2">{{$t('message.offers')}}
                            </router-link>
                        </sections-with-categories>
                    </div>

                    <!-- main filter & data results -->
                    <div class="col-xl-9">
                        <!-- results info -->
                        <div class="row text-center text-md-start justify-content-md-between align-items-center results-info">
                            <div class="col-md-auto">
                                <span class="results-count" v-text="$t('message.productsCountVar', {var: sections.all})"></span>
                            </div>
                            <div class="col-md-auto">
                                <div class="row g-2 row-cols-auto justify-content-center align-items-center">
                                    <div class="col"><span class="order-by">ترتيب حسب</span></div>
                                    <div class="col">
                                        <select class="form-select" @change="store.commit('filterProducts', $event.target.value)">
                                            <option value="">إختر قيمة</option>
                                            <option value="price_low_high">المنتجات الأقل سعرا</option>
                                            <option value="price_high_low">المنتجات الأكبر سعرا</option>
                                        </select>
                                    </div>

                                    <div class="col">
                                        <input type="radio" class="btn-check display-way" name="display_way" value="grid" id="grid" autocomplete="off" checked>
                                        <label class="btn btn-custom-radio" for="grid"><i class="fa-solid fa-grip"></i></label>
                                    </div>
                                    <div class="col">
                                        <input type="radio" class="btn-check display-way" name="display_way" value="list" id="list" autocomplete="off">
                                        <label class="btn btn-custom-radio" for="list"><i class="fa fa-list"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- results data -->
                        <div id="results-data" class="row g-3 row-cols-1 row-cols-md-2 row-cols-lg-3 results-data" v-if="allProducts.length > 0">
                            <div class="col" v-for="(product, index) in allProducts" :key="index">
                                <single-product :products="allProducts" :product="product" :key="index"></single-product>
                            </div>
                        </div>

                        <div class="row g-3 row-cols-1" v-else>
                            <div class="alert alert-info text-center" v-text="$t('message.noProducts')"></div>
                        </div>

                        <!-- show more -->
                        <div class="text-center" v-if="has_pagination">
                            <a href="javascript:void(0);" @click.prevent="store.dispatch('getNextPage')" class="show-more-link">
                                {{$t('message.loadMore')}}<i class="fa fa-arrow-down ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </app-layout>
</template>
