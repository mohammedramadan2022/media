<script setup>
import {computed, ref} from "vue";
import AppLayout from "@/components/front/layout/AppLayout";
import {useStore} from "vuex";
import SingleProduct from "@/components/front/includes/SingleProduct";
import CitySectionsWithCategories from "@/components/front/includes/CitySectionsWithCategories";
import {useRoute} from "vue-router";
import {useGetImage} from "@/composables/useHelper";
import CategoryOptions from "@/components/front/includes/CategoryOptions.vue";

const store = useStore();
const route = useRoute();
let city_id = ref(route.params.id);

store.dispatch('getProductsByCityId', city_id.value);
store.dispatch('getCitySectionWithCategories', city_id.value);

let cities = computed(() => store.state.getAllCities);
let allProducts = computed(() => store.state.product.allProducts);
let sections = computed(() => store.state.providers.sections);
let pagination = computed(() => store.state.product.pagination);
let has_pagination = computed(() => store.state.product.has_pagination);
let has_filter_pagination = computed(() => store.state.product.has_filter_pagination);
let has_category_pagination = computed(() => store.state.product.has_category_pagination);
let filterData = computed(() => store.state.product.productsFilterData);

function removeFromFave(product) {
    store.dispatch('removeProductFromFavorites', product);
    product.is_fave = false;
}

function addToFave(product) {
    store.dispatch('addProductToFavorites', product);
    product.is_fave = true;
}
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'products'}" v-text="$t('message.allProducts')"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content">
            <div class="container">
                <div class="row gy-3 gy-xl-0">
                    <!-- sections filter -->
                    <div class="col-xl-3">
                        <city-sections-with-categories :sections="sections">
                            <router-link :to="{name: 'offers'}" class="offers">
                                <img :src="useGetImage('front/assets/images/icons/offers.svg')" alt="offers icon" class="me-2">{{ $t('message.offers') }}
                            </router-link>
                        </city-sections-with-categories>
                        <category-options from="city" :current-route="route"/>
                    </div>

                    <!-- main filter & data results -->
                    <div class="col-xl-9">
                        <!-- main filter -->
                        <div class="main-filter-div">
                            <form @submit.prevent="store.dispatch('getFilteredProducts')">
                                <div class="row justify-content-end">
                                    <div class="col-md-6 col-xl-6">
                                        <div class="mb-3">
                                            <label for="start-date" class="form-label"
                                                   v-text="$t('message.dateOfReceipt')"></label>
                                            <input type="date" class="form-control" id="start-date">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-6">
                                        <div class="mb-3">
                                            <label for="end-date" class="form-label"
                                                   v-text="$t('message.dateOfDelivery')"></label>
                                            <input type="date" class="form-control" id="end-date">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xl-12">
                                        <div class="mb-3">
                                            <input type="text" name="term" v-model="filterData.term"
                                                   class="form-control" :placeholder="$t('message.productName')">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xl-2">
                                        <button type="submit" class="btn btn-primary-color w-100"
                                                v-text="$t('message.search')"></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- results info -->
                        <div
                            class="row text-center text-md-start justify-content-md-between align-items-center results-info">
                            <div class="col-md-auto">
                                <span class="results-count"
                                      v-text="$t('message.productsCountVar', {var: pagination.total})"></span>
                            </div>
                            <div class="col-md-auto">
                                <div class="row g-2 row-cols-auto justify-content-center align-items-center">
                                    <div class="col"><span class="order-by" v-text="$t('message.sortBy')"></span></div>
                                    <div class="col">
                                        <select class="form-select"
                                                @change="store.commit('filterProducts', $event.target.value)">
                                            <option value="" v-text="$t('message.chooseValue')"></option>
                                            <option value="price_low_high"
                                                    v-text="$t('message.lowPriceProducts')"></option>
                                            <option value="price_high_low"
                                                    v-text="$t('message.highPriceProducts')"></option>
                                        </select>
                                    </div>

                                    <div class="col">
                                        <input type="radio" class="btn-check display-way" name="display_way"
                                               value="grid" id="grid" autocomplete="off" checked>
                                        <label class="btn btn-custom-radio" for="grid"><i class="fa-solid fa-grip"></i></label>
                                    </div>
                                    <div class="col">
                                        <input type="radio" class="btn-check display-way" name="display_way"
                                               value="list" id="list" autocomplete="off">
                                        <label class="btn btn-custom-radio" for="list"><i
                                            class="fa fa-list"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- results data -->
                        <div id="results-data" class="row g-3 row-cols-1 row-cols-md-2 row-cols-lg-3 results-data"
                             v-if="allProducts.length > 0">
                            <div class="col" v-for="(product, index) in allProducts" :key="index">
                                <single-product @addToFave="addToFave(product)"
                                                @removeFromFave="removeFromFave(product)"
                                                :product="product"></single-product>
                            </div>
                        </div>

                        <div class="row g-3 main-filter-div mt-1 row-cols-1" v-else>
                            <div class="alert alert-info text-center" v-text="$t('message.noProducts')"></div>
                        </div>

                        <!-- show more -->
                        <div class="text-center" v-if="has_pagination">
                            <a href="javascript:void(0);" @click.prevent="store.dispatch('getCityNextPage', city_id)"
                               class="show-more-link">
                                {{ $t('message.loadMore') }}<i class="fa fa-arrow-down ms-2"></i>
                            </a>
                        </div>

                        <!-- show getFilteredProductsNextPage more -->
                        <div class="text-center" v-if="has_filter_pagination">
                            <a href="javascript:void(0);" @click.prevent="store.dispatch('getFilteredProductsNextPage')"
                               class="show-more-link">
                                {{ $t('message.loadMore') }}<i class="fa fa-arrow-down ms-2"></i>
                            </a>
                        </div>

                        <!-- show getCategoryProductsNextPage more -->
                        <div class="text-center" v-if="has_category_pagination">
                            <a href="javascript:void(0);" @click.prevent="store.dispatch('getCategoryProductsNextPage')"
                               class="show-more-link">
                                {{ $t('message.loadMore') }}<i class="fa fa-arrow-down ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </app-layout>
</template>
