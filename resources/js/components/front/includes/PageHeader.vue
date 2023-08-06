<script setup>
import {computed, onBeforeMount, ref} from "vue";
import {useGetImage, handleShowJoinModal} from "@/composables/useHelper";
import {useRouter} from "vue-router";
import {useStore} from "vuex";
import {getCustomKey} from "@/composables/useStorage";
import SearchProduct from "@/components/front/includes/SearchProduct";

const store = useStore();
const {push} = useRouter();
const isAuth = User.hasToken();
let auth = User.auth();
let cartTotalCount = ref(getCustomKey('userCartTotal'));

onBeforeMount(() => {
    if (cartTotalCount === '0' && isAuth) store.dispatch('getUserCart');

    store.dispatch('getAllSections');

    if(isAuth) store.dispatch('getUserNewNotificationsCount');

    store.dispatch('getMetaInfo');

    if (isAuth && auth.address_id) store.dispatch('getAddressById', auth.address_id);
});

let fetchFooter = computed(() => store.state.footerData);
let sections = computed(() => store.state.section.getAllSections);
let cityName = computed(() => store.getters.cityName);
let cartTotal = computed(() => store.state.cart.cartTotal);
let hasNotifications = computed(() => store.state.notification.hasNotifications);

function navigateTo() {
    (!isAuth) ? $('#loginModal').modal('show') : push({name: 'addresses'});
}

function searchKeyUp(e) {
    store.dispatch('searchByKey', e.target.value);
}

window.removeResearchResults = () => {
    $('form.main-search-form .input-group-text').empty().html('<button type="submit"><i class="fa fa-search"></i></button>');
    $('.main-search-results').addClass('d-none');
    $('form.main-search-form input[type="text"]').val('');
    store.dispatch('cleanSearchResult');
}
</script>

<template>
    <section id="header">
        <!-- top header -->
        <div class="container">
            <div class="row align-items-center align-items-xl-start text-center text-md-start gy-2 gy-xl-0 gx-xl-5 py-xl-4">
                <!-- main logo -->
                <div class="col-md-4 col-xl-2">
                    <router-link :to="{name: 'home'}">
                        <img class="img-fluid top-header-logo" :src="fetchFooter.logo" alt="logo">
                    </router-link>
                </div>

                <!-- main search & other -->
                <div class="col-md-8 col-xl-10">
                    <div class="row gy-2 gy-xl-0 gx-xl-5 align-items-end">
                        <!-- main search -->
                        <div class="col-xl-6">
                            <div class="position-relative">
                                <form class="main-search-form" @submit.prevent="store.dispatch('getSearchResult')">
                                    <div class="input-group">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-search-sections dropdown-toggle" data-bs-toggle="dropdown" data-bs-offset="0,10">
                                                <span class="pe-xl-3 section-name-display">
                                                    <span class="d-inline-block d-sm-none" v-text="$t('message.all')"></span>
                                                    <span class="d-none d-sm-inline-block" v-text="$t('message.allSections')"></span>
                                                </span>
                                            </button>

                                            <ul class="dropdown-menu">
                                                <li><a href="javascript:void(0);" class="dropdown-item section-name active" @click="store.commit('setSectionId','')" data-section-id="" v-text="$t('message.all')"></a></li>
                                                <li v-for="(section, index) in sections">
                                                    <a href="javascript:void(0);" :key="index" class="dropdown-item section-name" @click="store.commit('setSectionId', section.id)" :data-section-id="section.id" v-text="section.name"></a>
                                                </li>
                                            </ul>
                                        </div>

                                        <input type="text" class="form-control" @keyup="searchKeyUp($event)" :placeholder="$t('message.productName')" autocomplete="false">

                                        <span class="input-group-text">
                                            <button type="submit"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </form>

                                <template v-if="store.state.searchResult.length > 0">
                                    <div class="main-search-results d-none">
                                        <search-product v-for="(product, index) in store.state.searchResult" :key="index" :product="product" />
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- other -->
                        <div class="col-xl-6">
                            <div class="row gy-2 gy-xl-0 row-cols-auto justify-content-between justify-content-lg-around justify-content-xl-around">
                                <div class="col col-head">
                                    <router-link :to="{name: 'notifications'}" class="top-header-link1">
                                        <div class="active">
                                            <span class="badge-count" v-show="hasNotifications"></span>
                                            <i class="fa fa-bell"></i>
                                        </div>
                                        <span class="notify-span" v-text="$t('message.notifications')"></span>
                                    </router-link>
                                </div>
                                <div class="col col-head">
                                    <div class="dropdown top-header-my-account">
                                        <a href="#" v-if="isAuth" class="top-header-link1 dropdown-toggle" data-bs-toggle="dropdown" data-bs-offset="0,10">
                                            <div class="active"><i class="fa fa-user"></i></div>
                                            <span class="ps-1">
                                                <span class="welcome" v-text="$t('message.welcomeVar', {user: auth.first_name})"></span>
                                                <span class="title" v-text="$t('message.myAccount')"></span>
                                            </span>
                                        </a>
                                        <div class="col" v-else>
                                            <a href="javascript:void(0);" class="top-header-link1" data-bs-toggle="modal" data-bs-target="#loginModal">
                                                <div class="me-1"><i class="fa fa-user"></i></div>
                                                {{$t('message.register')}}
                                            </a>
                                        </div>
                                        <ul class="dropdown-menu">
                                            <li><router-link :to="{name: 'profile'}" class="dropdown-item" active-class="active" exact v-text="$t('message.personalInfo')"></router-link></li>
                                            <li><router-link :to="{name: 'orders'}" class="dropdown-item" active-class="active" exact v-text="$t('message.myOrders')"></router-link></li>
                                            <li><router-link :to="{name: 'favorites'}" class="dropdown-item" active-class="active" exact v-text="$t('message.myFavorites')"></router-link></li>
                                            <li><router-link :to="{name: 'wallet'}" class="dropdown-item" active-class="active" exact v-text="$t('message.myWallet')"></router-link></li>
                                            <li><router-link :to="{name: 'addresses'}" class="dropdown-item" active-class="active" exact v-text="$t('message.myAddresses')"></router-link></li>
                                            <li class="text-center"><hr></li>
                                            <li><a href="javascript:void(0);" @click.prevent="store.dispatch('logout')" class="dropdown-item logout-link" v-text="$t('message.logout')"></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col col-head">
                                    <router-link :to="{name: 'contact-us'}" class="top-header-link1">
                                        <div class="me-1"><i class="fa fa-phone"></i></div>
                                        <span v-text="$t('message.contactUs')"></span>
                                    </router-link>
                                </div>
                                <div class="col col-head">
                                    <router-link :to="{name: 'shopping-cart'}" class="top-header-link1">
                                        <div class="active me-1">
                                            <span class="badge-count" v-if="parseInt(cartTotalCount) > 0"></span>
                                            <i class="fa fa-cart-shopping"></i>
                                        </div>
                                        <span v-text="$t('message.shoppingCartTotal', {total: (isAuth ? cartTotal : '00:00')})"></span>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- bottom header -->
        <div class="bottom-header mb-0">
            <div class="container">
                <div class="row justify-content-xl-center justify-content-lg-center justify-content-md-between justify-content-between align-items-center navbar-main-menu">
                    <!-- all sections btn -->
                    <div class="col-auto col-xl-2">
                        <a class="all-menu-link" data-bs-toggle="offcanvas" href="#all-sections">
                            <div><i class="fa fa-bars fa-lg"></i></div>
                        </a>
                    </div>

                    <!-- menu -->
                    <div class="col-auto col-xl d-none d-lg-inline-block">
                        <ul class="list-inline main-menu">
                            <li class="list-inline-item"><router-link :to="{name: 'home'}" class="active" v-text="$t('message.home')"></router-link></li>
                            <li class="list-inline-item"><router-link :to="{name: 'products'}" v-text="$t('message.allProducts')"></router-link></li>
                            <li class="list-inline-item">
                                <router-link :to="{name: 'offers'}" class="offers">
                                    <img :src="useGetImage('front/assets/images/icons/offers.svg')" alt="offers icon" class="me-2"> {{ $t('message.offers') }}
                                </router-link>
                            </li>
                            <li class="list-inline-item"><router-link :to="{name: 'stores'}" v-text="$t('message.allStores')"></router-link></li>
                            <li class="list-inline-item"><router-link :to="{name: 'whatWeProvide'}" v-text="$t('message.whatWeProvide')"></router-link></li>
                            <li class="list-inline-item"><a href="javascript:void(0);" @click.prevent="handleShowJoinModal();" v-text="$t('message.joinRental')"></a></li>
                            <li class="list-inline-item nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" v-text="$t('message.sections')"></a>
                              <ul class="dropdown-menu main-nav-dropdown" aria-labelledby="navbarDropdown">
                                  <li v-for="(section, index) in sections">
                                      <router-link :to="{name: 'section-products', params: {id: section.id ?? 0}}" @click="store.dispatch('getProductsBySectionId',section.id ?? 0)" :key="index" class="dropdown-item" v-text="section.name"></router-link>
                                  </li>
                              </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- city & lang -->
                    <div class="col-auto col-xl-auto city-lang-div">
                        <div class="deliver-to-city float-start">
                            <i class="fa fa-location-dot"></i>
                            <span class="deliver-to-city-text" v-text="$t('message.deliveryTo')"></span>
                            <router-link :to="{name: 'addresses'}" v-if="cityName" v-text="cityName"></router-link>
                            <a href="javascript:void(0);" @click.prevent="navigateTo" v-else v-text="$t('message.chooseAddress')"></a>
                        </div>

                        <div class="dropdown float-end">
                            <template v-if="store.state.lang === 'ar'">
                                <a class="dropdown-toggle font-size-12" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img :src="useGetImage('front/assets/images/icons/saudi.svg')" alt="lang icon" class="me-2">
                                    {{ $t('message.arabic') }}
                                </a>
                            </template>

                            <template v-else>
                                <a class="dropdown-toggle font-size-12" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img :src="useGetImage('front/assets/images/icons/EN.png')" alt="lang icon" class="me-2">
                                    {{ $t('message.english') }}
                                </a>
                            </template>

                            <ul class="dropdown-menu" id="lang-dropdown">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" @click="store.commit('changeLange','ar');">
                                        <img :src="useGetImage('front/assets/images/icons/saudi.svg')" alt="lang icon" class="me-2"> {{ $t('message.arabic') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" @click="store.commit('changeLange','en');">
                                        <img :src="useGetImage('front/assets/images/icons/EN.png')" alt="lang icon" class="me-2" style="width: 20px;height: 14px;object-fit: cover;">{{ $t('message.english') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of header -->
</template>

<style scoped>
    @media(max-width: 300px) {
        .col-head{
            flex: 0 0 auto;
            width: 50%;
            display: flex;
            justify-content: flex-start;
        }
    }
    [lang="en"] .city-lang-div{
        display: flex;
    }
</style>
