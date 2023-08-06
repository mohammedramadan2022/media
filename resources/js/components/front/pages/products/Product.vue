<script setup>
import {computed, ref} from "vue";
import {useStore} from "vuex";
import {useSuccessSwal} from "@/composables/useSwal";
import AppLayout from "@/components/front/layout/AppLayout";
import {useRoute, useRouter} from "vue-router";
import Similar from "@/components/front/carousels/Similar";
import RatesDisplayModal from "@/components/front/modals/ratesDisplayModal";
import RateModal from "@/components/front/modals/rateModal";

const store = useStore();
const route = useRoute();
const router = useRouter();

store.dispatch('getProductById', route.params.id);

let product = computed(() => store.state.product.getProduct);
let cartData = computed(() => store.state.cart.cartData);
let fullPath = ref(root + route.fullPath);

function checkUserIsAuth(product) {
    if(!User.hasToken()) { $('#loginModal').modal('show'); return; }
    store.dispatch('addToCart', product);
}
function checkUserAuth() {
    $('#ratesDisplayModal').modal('hide');
    $('#rateModal').modal('show');
}
let showRatesDisplayModal = () => $('#ratesDisplayModal').modal('show');
let onCopy = () => useSuccessSwal(trans('message.copied'));
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item">
                <router-link :to="{name: 'products'}" v-text="$t('message.products')"></router-link>
            </li>
            <li class="breadcrumb-item">
                <router-link :to="'/products/get/'+product.section.id+'/section'" v-text="product.section.name"></router-link>
            </li>
            <li class="breadcrumb-item active">
                <router-link :to="$route.name" v-text="product.name"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="product-details">
            <div class="container">
                <div class="row gy-3 gy-xl-0 align-items-center align-items-xl-end">
                    <!-- product images -->
                    <div class="col-xl-4">
                        <div class="product-images">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <template v-for="(product_image, index) in product.images" :key="index">
                                        <div class="carousel-item" :class="{'active': index === 0}">
                                            <a :href="product_image.image" data-fancybox="product-images" :data-caption="product.name">
                                                <img class="d-block w-100" :src="product_image.image" alt="product image">
                                            </a>
                                        </div>
                                    </template>
                                </div>

                                <div class="carousel-indicators">
                                    <template v-for="(product_image, index) in product.images" :key="product_image.id">
                                        <img :src="product_image.image" alt="product thump image" :class="{'active': index === 0}" data-bs-target="#carouselExampleIndicators" :data-bs-slide-to="index">
                                    </template>
                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <i class="fa fa-angle-right"></i>
                                </button>

                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <i class="fa fa-angle-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- product info -->
                    <div class="col-xl-8">
                        <div class="product-info">
                            <div class="row gy-3 align-items-end">
                                <div class="col-xl-12">
                                    <div class="product-sections" v-if="product.section">
                                        <i :class="['fa ' + product.section.icon]"></i>
                                        <span v-text="product.section.name"></span>({{product.category.name}})
                                    </div>
                                    <span v-if="product.has_offer" class="product-discount">{{product.offer}} %</span>
                                </div>

                                <div class="col-xl-12"><h1 v-text="product.name"></h1></div>

                                <div class="col-xl-12">
                                    <div class="product-code">{{ $t('message.productCode') }} :&nbsp;&nbsp;<span v-text="product.product_code"></span></div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="product-owner" v-if="product.owner">
                                        <i class="fa fa-user"></i>&nbsp;
                                        <a href="javascript:void(0);" v-if="product.owner.id === 0" v-text="$t('message.rental')"></a>
                                        <router-link v-else :to="{name: 'store-details', params: {id: product.owner.id}}" v-text="product.owner.name"></router-link>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="product-city" v-if="product.city">
                                        <i class="fa fa-location-dot"></i>&nbsp;
                                        {{$t('message.city')}} :&nbsp;&nbsp;<span v-text="product.city.text"></span>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="product-rate">
                                        <i class="fa fa-star"></i>&nbsp;{{product.rate}}&nbsp;
                                        <span>({{product.rate_count}})</span>&nbsp;&nbsp;
                                        <a href="javascript:void(0);" v-if="product.rate_count > 0" @click.prevent="showRatesDisplayModal">
                                            {{ product.rate_count }} {{$t('message.rates')}}
                                        </a>
                                    </div>
                                </div>

                                <div class="col-xl-12 d-flex align-items-center justify-content-start price-system">
                                    <div class="product-price">
                                        {{ $t('message.youWillPay') }}
                                        <span v-text="product.has_offer ? product.offer_value : product.price"></span>
                                        {{ $t('message.realPerDay') }}&nbsp;
                                        <small v-if="product.has_offer">
                                            {{ $t('message.insteadOf') }}
                                            <span>{{ product.price }} {{ $t('message.realPerDay') }}</span>
                                        </small>
<!--                                        <span v-if="product.qty > 0" class="count-in-store">-->
<!--                                            <i class="fa fa-check"></i>&nbsp;&nbsp;{{ $t('message.availableInStore', {num: product.qty}) }}-->
<!--                                        </span>-->
<!--                                        <span v-else class="count-in-store"><i class="fa fa-check"></i>&nbsp;&nbsp;  {{$t('message.notAvailable')}}</span>-->
                                    </div>
                                    <div class="product-price">
                                        <span>/</span>
                                    </div>
                                    <div class="product-price">
                                        {{ $t('message.youWillPay') }}
                                        <span v-text="product.hour_price"></span>
                                        {{ $t('message.realPerHour') }}&nbsp;
                                    </div>
                                </div>

                                <div class="col-auto" v-if="!product.is_in_cart">
                                    <form @submit.prevent="store.dispatch('addToCart', product)">
                                        <div class="row gy-2 gy-xl-0 align-items-center">
                                            <div class="col-auto">
                                                <div class="d-flex align-items-center justify-content-start">
                                                    <button type="button" class="quantity-btn" @click="cartData.quantity++" :disabled="cartData.quantity >= product.qty">+</button>
                                                    <span class="quantity-span">{{ cartData.quantity }}</span>
                                                    <button type="button" class="quantity-btn" @click="cartData.quantity--" :disabled="cartData.quantity <= 1">-</button>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" @click.prevent="checkUserIsAuth(product)" class="btn btn-primary-color">
                                                    <i class="fas fa-cart-shopping"></i>&nbsp;&nbsp;{{$t('message.addToCart')}}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-auto" v-else>
                                    <form @submit.prevent="store.dispatch('removeProductFromCartInDetails', product.id)">
                                        <div class="row gy-2 gy-xl-0 align-items-center">
                                            <div class="col-auto">
                                                <div class="d-flex align-items-center justify-content-start">
                                                    <button type="button" class="quantity-btn" @click="cartData.quantity++" :disabled="cartData.quantity >= product.qty">+</button>
                                                    <span class="quantity-span" v-text="cartData.quantity"></span>
                                                    <button type="button" class="quantity-btn" @click="cartData.quantity--" :disabled="cartData.quantity <= 1">-</button>
                                                </div>
                                            </div>

                                            <div class="col-auto">
                                                <button type="submit" name="submit" class="btn btn-danger2">
                                                    <i class="fa fa-times"></i>&nbsp;&nbsp;{{ $t('message.removeFromCart') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-auto" v-if="product.is_fave">
                                    <button class="btn btn-fav active" @click.prevent="store.dispatch('removeProductFromFavorites', product)"><i class="fa-regular fa-heart"></i></button>
                                </div>

                                <div class="col-auto" v-else>
                                    <button class="btn btn-fav" @click.prevent="store.dispatch('addProductToFavorites', product)"><i class="fa-regular fa-heart"></i></button>
                                </div>

                                <div class="col-auto">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">{{ $t('message.share') }} :</li>
                                        <li class="list-inline-item">
                                            <a target="_blank" :href="'https://www.facebook.com/sharer/sharer.php?u=' + fullPath">
                                                <div class="share-links share-links-facebook"><i class="fa-brands fa-facebook-f"></i></div>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a target="_blank" :href="'https://wa.me/?text=' + fullPath">
                                                <div class="share-links share-links-whatsapp"><i class="fa-brands fa-whatsapp"></i></div>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a target="_blank" :href="'https://twitter.com/intent/tweet?text='+ product.name +'&url='+fullPath">
                                                <div class="share-links share-links-twitter"><i class="fa-brands fa-twitter"></i></div>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" v-clipboard:copy="fullPath" v-clipboard:success="onCopy">
                                                <div class="share-links share-links-copy">
                                                    <i class="fa-solid fa-copy"></i>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- description & rates -->
                    <div class="col-xl-12">
                        <div class="product-descriptions">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-desc" type="button" role="tab" v-text="$t('message.productDescription')"></button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-using" type="button" role="tab" v-text="$t('message.usageInstructions')"></button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-rules" type="button" role="tab" v-text="$t('message.rentalTerms')"></button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-rates" type="button" role="tab" v-text="$t('message.theRates')"></button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-desc" role="tabpanel">
                                    <div class="row pt-3" v-html="product.description"></div>
                                </div>
                                <div class="tab-pane fade" id="pills-using" role="tabpanel">
                                    <div class="row pt-3" v-html="product.usage_instructions"></div>
                                </div>
                                <div class="tab-pane fade" id="pills-rules" role="tabpanel">
                                    <div class="row pt-3" v-html="product.rental_terms"></div>
                                </div>
                                <div class="tab-pane fade" id="pills-rates" role="tabpanel">
                                    <div class="row justify-content-xl-between align-items-center">
                                        <div class="col-auto">
                                            <h6>({{ product.rate_count }}) {{$t('message.clientsRates')}}</h6>
                                        </div>
                                        <div class="col-auto" v-if="!product.is_rated">
                                            <button class="btn btn-gold" @click.prevent="checkUserAuth" v-text="$t('message.addNewReview')"></button>
                                        </div>
                                    </div>

                                    <div class="row gy-3 pt-3 pb-5 comments-div" v-if="product.rate_count > 0">
                                        <template v-for="(review, index) in product.rates" :key="index">
                                            <div class="col-12">
                                                <div class="row g-2 align-items-center">
                                                    <div class="col-auto">
                                                        <div class="user-icon"><i class="fa fa-user"></i></div>
                                                    </div>
                                                    <div class="col">
                                                        <span v-text="review.name"></span>
                                                        <div>
                                                            <template v-for="(n, i) in 5" :key="i">
                                                                <template v-if="review.rate >= n">
                                                                    <i class="fa fa-star"></i>
                                                                </template>
                                                                <template v-else>
                                                                    <i class="fa-regular fa-star"></i>
                                                                </template>
                                                            </template>
                                                        </div>
                                                        <small v-text="review.date"></small>
                                                    </div>
                                                    <div class="col-12" v-if="review.comment !== ''">
                                                        <div class="comment-text" v-text="review.comment"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                    <div v-else class="row gy-3 pt-3 pb-5">
                                        <div class="alert alert-info text-center" v-text="$t('message.noRates')"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- similar products -->
                    <similar/>
                </div>
            </div>
        </section>
        <!-- end of content -->

        <rate-modal :product="product" />

        <rates-display-modal :product="product" />
    </app-layout>
</template>


<style>
    .price-system{
        border-top: 1px solid #EEE;
        border-bottom: 1px solid #EEE;
    }
    .quantity-btn{
        height: 30px;
        width: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
        border: 1px solid #8C9173;
        border-radius: 50%;
        background-color: #EEEFE8;
        color: #000;
    }
    .quantity-span{
        font-size: 20px;
        margin: 0px 15px;
    }
</style>
