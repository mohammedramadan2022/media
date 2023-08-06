<script setup>
import {useStore} from "vuex";
import {computed, ref} from "vue";
import {useRoute} from "vue-router";
import AppLayout from "@/components/front/layout/AppLayout";
import StoreSectionsWithCategories from "@/components/front/includes/StoreSectionsWithCategories";
import SingleProduct from "@/components/front/includes/SingleProduct";
import {useGetImage} from "@/composables/useHelper";

const store = useStore();
const route = useRoute();

let store_id = ref(route.params.id);

store.dispatch('getStoreById', store_id.value);
store.dispatch('getSingleStoreSectionWithCategories', store_id.value);

let sections = computed(() => store.state.providers.sections);
let cities = computed(() => store.state.getAllCities);
let provider = computed(() => store.state.providers.getSingleProvider);
let allProducts = computed(() => store.state.providers.allProducts);
let filterData = computed(() => store.state.providers.filterData);
let rateData = computed(() => store.state.providers.rateData);
let errors = computed(() => store.state.errors);

function checkUserAuth() {
    if (!User.hasToken()) {
        $('#loginModal').modal('show');
        return;
    }
    $('#rateModal').modal('show');
}

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
            <li class="breadcrumb-item">
                <router-link :to="{name: 'stores'}" v-text="$t('message.allStores')"></router-link>
            </li>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'store-details'}" v-text="provider.store_name"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content" class="store-details">
            <div class="container">
                <div class="row gy-3 gy-xl-0">
                    <!-- store info -->
                    <div class="col-xl-12">
                        <div class="store-info">
                            <div class="row gy-2 text-center text-md-start align-items-center">
                                <div class="col-md-auto">
                                    <div class="img-div"><img :src="provider.logo" :alt="provider.store_name"></div>
                                </div>
                                <div class="col-md">
                                    <div class="store-info-details">
                                        <h1 class="mb-2" v-text="provider.store_name"></h1>

                                        <div class="ul-shape mb-2">
                                            <span v-text="$t('message.joinDate') + ':'"></span>
                                            <span v-text="provider.created_date"></span>
                                        </div>

                                        <div class="ul-shape mb-2">
                                            <span v-text="$t('message.city') + ':'"></span>
                                            <span v-text="provider.city.text"></span>
                                        </div>

                                        <div class="store-rate">
                                            <i class="fa fa-star"></i>&nbsp;&nbsp;{{provider.rate}}
                                            &nbsp;&nbsp;<a href="javascript:void(0);" class="rate-count" data-bs-target="#ratesDisplayModal" data-bs-toggle="modal">{{provider.rate_count}} {{ $t('message.rates') }}</a>
                                            &nbsp;&nbsp;<a href="javascript:void(0);" @click.prevent="checkUserAuth" class="rate-link" v-text="$t('message.rateStore')"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- sections filter -->
                    <div class="col-xl-3">
                        <store-sections-with-categories :sections="sections" :store_id="store_id">
                            <router-link :to="{name: 'store-offers', params: {id: store_id}}" class="offers">
                                <img :src="useGetImage('front/assets/images/icons/offers.svg')" alt="offers icon" class="me-2">{{$t('message.offers')}}
                            </router-link>
                        </store-sections-with-categories>
                    </div>

                    <!-- main filter & data results -->
                    <div class="col-xl-9">
                        <!-- main filter -->
                        <div class="main-filter-div">
                            <form @submit.prevent="store.dispatch('getStoreFilteredProducts', store_id)">
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
                                <span class="results-count" v-text="$t('message.productsCountVar', {var: sections.all})"></span>
                            </div>
                            <div class="col-md-auto">
                                <div class="row g-2 row-cols-auto justify-content-center align-items-center">
                                    <div class="col">
                                        <span class="order-by" v-text="$t('message.sortBy')"></span>
                                    </div>
                                    <div class="col">
                                        <select class="form-select" @change="store.commit('filterStoreProducts', $event.target.value)">
                                            <option value="" v-text="$t('message.chooseValue')"></option>
                                            <option value="price_low_high" v-text="$t('message.lowPriceProducts')"></option>
                                            <option value="price_high_low" v-text="$t('message.highPriceProducts')"></option>
                                        </select>
                                    </div>

                                    <div class="col">
                                        <input type="radio" class="btn-check display-way" name="display_way" value="grid" id="grid" autocomplete="off" checked>
                                        <label class="btn btn-custom-radio" for="grid">
                                            <i class="fa-solid fa-grip"></i>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <input type="radio" class="btn-check display-way" name="display_way" value="list" id="list" autocomplete="off">
                                        <label class="btn btn-custom-radio" for="list">
                                            <i class="fa fa-list"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-if="allProducts.length > 0" id="results-data" class="row g-3 row-cols-1 row-cols-md-2 row-cols-lg-3 results-data">
                            <template v-for="(product, index) in allProducts" :key="index">
                                <div class="col">
                                    <single-product @addToFave="addToFave(product)" @removeFromFave="removeFromFave(product)" :product="product"></single-product>
                                </div>
                            </template>
                        </div>

                        <div v-else class="row g-3 row-cols-1 main-filter-div mt-1 results-data">
                            <div class="alert alert-info text-center" v-text="$t('message.noProducts')"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of content -->

        <!-- rateModal -->
        <div class="modal fade" id="rateModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn btn-close2" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h1 v-text="$t('message.rateYourStore')"></h1>

                        <form @submit.prevent="store.dispatch('setUserStoreRate', provider.id)">
                            <div class="form-group mb-3">
                                <label class="form-label" v-text="$t('message.userName')"></label>
                                <div class="input-group" :class="{'has-error-custom': errors.name}">
                                    <input type="text" v-model="rateData.name" class="form-control" :placeholder="$t('message.userName')">
                                </div>
                                <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" v-text="$t('message.writeYourComment')"></label>
                                <div class="input-group" :class="{'has-error-custom': errors.comment}">
                                    <textarea class="form-control" v-model="rateData.comment" :placeholder="$t('message.writeYourComment')" rows="4"></textarea>
                                </div>
                                <span class="text-danger" v-if="errors.comment">{{ errors.comment[0] }}</span>
                            </div>

                            <div class="rate-section">
                                <div class="row gy-4 align-items-center">
                                    <div class="col-6 col-sm-4">
                                        <p v-text="$t('message.selectYourRate')"></p>
                                    </div>
                                    <div class="col-6 col-sm-8">
                                        <div class="rates-input-div">
                                            <input type="hidden" name="rate" class="rate-input">
                                            <i class="fa-regular fa-star rate-event" data-count="1"></i>
                                            <i class="fa-regular fa-star rate-event" data-count="2"></i>
                                            <i class="fa-regular fa-star rate-event" data-count="3"></i>
                                            <i class="fa-regular fa-star rate-event" data-count="4"></i>
                                            <i class="fa-regular fa-star rate-event" data-count="5"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-danger" v-if="errors.rate">{{ errors.rate[0] }}</span>
                            </div>

                            <div class="row g-4 row-cols-auto justify-content-center align-items-center mb-3">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary-color" v-text="$t('message.addNewTheReview')"></button>
                                </div>
                                <div class="col">
                                    <a href="javascript:void(0);" class="btn btn-outline-primary-color" data-bs-dismiss="modal" v-text="$t('message.close')"></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of rateModal -->

        <!-- ratesDisplayModal -->
        <div class="modal fade" id="ratesDisplayModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn btn-close2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <div class="modal-body">
                        <h1 v-text="$t('message.theRates')"></h1>

                        <template v-if="provider.rates.length > 0">
                            <div class="rate-unit" v-for="(review, index) in provider.rates.slice(0,4)" :key="index">
                                <p v-text="review.name"></p>
                                <div>
                                    <template v-for="(n, i) in 5" :key="i">
                                        <template v-if="review.rate >= n">
                                            <i class="fa-solid fa-star text-warning"></i>
                                        </template>
                                        <template v-else>
                                            <i class="fa-solid fa-star text-secondary"></i>
                                        </template>
                                    </template>
                                </div>
                                <span v-if="review.comment !== ''" v-text="review.comment"></span>
                                <small v-text="review.since"></small>
                            </div>
                        </template>
                        <template v-else>
                            <div class="alert alert-info text-center" v-text="$t('message.noVar', {var: $t('message.rates')})"></div>
                        </template>

                        <div class="row row-cols-auto justify-content-center align-items-center mb-3">
                            <div class="col">
                                <a href="javascript:void(0);" class="btn btn-primary-color" v-if="!provider.is_rated" @click.prevent="checkUserAuth" v-text="$t('message.addNewReview')"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of ratesDisplayModal -->
    </app-layout>
</template>
