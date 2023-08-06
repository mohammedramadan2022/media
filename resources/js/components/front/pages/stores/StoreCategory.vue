<script setup>
import {computed} from "vue";
import AppLayout from "@/components/front/layout/AppLayout";
import {useStore} from "vuex";
import SingleProduct from "@/components/front/includes/SingleProduct";
import {useRoute} from "vue-router";
import StoreCategoryOptions from "@/components/front/includes/StoreCategoryOptions.vue";

const store = useStore();
const route = useRoute();

store.dispatch('getStoreSectionWithCategories');
store.dispatch('getStoresProductsByCategoryId', route.params.id);

let cities = computed(() => store.state.getAllCities);
let sections = computed(() => store.state.providers.sections);
let pagination = computed(() => store.state.providers.pagination);
let has_pagination = computed(() => store.state.providers.has_pagination);
let allProducts = computed(() => store.state.providers.allProducts);
let filterData = computed(() => store.state.providers.categoryProductsFilterData);

function removeFromFave(product) {
    store.dispatch('removeProductFromFavorites', product);
    product.is_fave = false;
}

function addToFave(product){
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
                    <div class="col-lg-4 col-xl-3">
                        <!-- sections filter -->
                        <div class="sections-div">
                            <h6 v-text="$t('message.sections')"></h6>
                            <ul class="list-unstyled sections-data">
                                <li class="d-flex justify-content-between align-items-center">
                                    <a href="#" class="active" v-text="$t('message.all')"></a>
                                    <span class="badge-count">({{sections.all}})</span>
                                </li>
                                <template v-for="(section, index) in sections.sections" :key="index">
                                    <li v-if="section.categories.length > 0">
                                        <div class="accordion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapseOne-'+section.id">
                                                        {{section.name}}
                                                        <span class="ms-auto badge-count">({{section.products_count}})</span>
                                                    </button>
                                                </h2>
                                                <div :id="'collapseOne-' + section.id" class="accordion-collapse collapse">
                                                    <div class="accordion-body">
                                                        <ul class="list-unstyled">
                                                            <li v-for="(category, index) in section.categories" :key="index">
                                                                <router-link
                                                                    @click="store.dispatch('getStoresProductsByCategoryId', category.id)"
                                                                    :to="{name: 'store-category', params: {id: category.id}}">
                                                                    {{category.name}}
                                                                </router-link>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li v-else class="d-flex justify-content-between align-items-center">
                                        <a href="#" v-text="section.name"></a>
                                        <span class="badge-count">({{ section.products_count }})</span>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <store-category-options/>
                    </div>

                    <!-- main filter & data results -->
                    <div class="col-xl-9">
                        <!-- main filter -->
                        <div class="main-filter-div">
                            <form @submit.prevent="store.dispatch('getStoreFilteredCategoryProducts')">
                                <div class="row justify-content-end">
                                    <div class="col-md-4 col-xl-4">
                                        <div class="mb-3">
                                            <label for="city" class="form-label" v-text="$t('message.city')"></label>
                                            <select class="form-select" v-model="filterData.city_id" id="city">
                                                <option selected value="" v-text="$t('message.all')"></option>
                                                <option v-for="(city, index) in cities" :key="index" :value="city.id" v-text="city.text"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xl-4">
                                        <div class="mb-3">
                                            <label for="start-date" class="form-label" v-text="$t('message.dateOfReceipt')"></label>
                                            <input type="date" class="form-control" id="start-date">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xl-4">
                                        <div class="mb-3">
                                            <label for="end-date" class="form-label" v-text="$t('message.dateOfDelivery')"></label>
                                            <input type="date" class="form-control" id="end-date">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xl-12">
                                        <div class="mb-3">
                                            <input type="text" name="term" v-model="filterData.term" class="form-control" :placeholder="$t('message.productName')">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xl-2">
                                        <button type="submit" class="btn btn-primary-color w-100" v-text="$t('message.search')"></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- results info -->
                        <div class="row text-center text-md-start justify-content-md-between align-items-center results-info">
                            <div class="col-md-auto">
                                <span class="results-count" v-text="$t('message.productsCountVar', {var: allProducts.length})"></span>
                            </div>
                            <div class="col-md-auto">
                                <div class="row g-2 row-cols-auto justify-content-center align-items-center">
                                    <div class="col"><span class="order-by">{{$t('message.sortBy')}}</span></div>
                                    <div class="col">
                                        <select class="form-select" @change="store.commit('filterProducts', $event.target.value)">
                                            <option value="" v-text="$t('message.chooseValue')"></option>
                                            <option value="price_low_high" v-text="$t('message.lowPriceProducts')"></option>
                                            <option value="price_high_low" v-text="$t('message.highPriceProducts')"></option>
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
                                <single-product @addToFave="addToFave(product)" @removeFromFave="removeFromFave(product)" :product="product"></single-product>
                            </div>
                        </div>

                        <div class="row g-3 row-cols-1 main-filter-div mt-1" v-else>
                            <div class="alert alert-info text-center" v-text="$t('message.noProducts')"></div>
                        </div>

                        <!-- show more -->
                        <div class="text-center" v-if="has_pagination">
                            <a href="javascript:void(0);" @click.prevent="store.dispatch('getStoreCategoryNextPage')" class="show-more-link">
                                {{$t('message.loadMore')}}<i class="fa fa-arrow-down ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </app-layout>
</template>
