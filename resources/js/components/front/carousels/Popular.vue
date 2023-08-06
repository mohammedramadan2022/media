<script setup>
import {Carousel, Slide, Navigation, Pagination} from "vue3-carousel";
import {ref, computed} from "vue";
import {useStore} from "vuex";

const store = useStore();

let popular = computed(() => store.state.home.popular);

let sectionSettings = ref({
    autoplay: "5000",
    dir: 'rtl',
    itemsToShow: 9,
    pauseAutoplayOnHover: true,
    snapAlign: 'center',
    wrapAround: true,
});

let breakpoints = ref({
    0: {itemsToShow: 1},
    539: {itemsToShow: 2},
    1281: {itemsToShow: 3},
    1300: {itemsToShow: 4},
});
</script>

<template>
    <section class="wow fadeInUp" id="most-popular-products" v-if="popular.length > 0">
        <div class="container">
            <h5>
                {{ $t('message.mostOrderedProducts') }}
                <router-link :to="{name: 'popular-products'}">{{ $t('message.showMore') }}&nbsp;<i class="fa fa-angle-double-left"></i></router-link>
            </h5>
            <carousel :settings="sectionSettings" :breakpoints="breakpoints">
                <slide v-for="product in popular" :key="product.id">
                    <div class="card product-item">
                        <div class="img-shimmer">
                            <img class="card-img-top" @click="$router.push({name: 'product-details', params: {id: product.id}})" :src="product.image" :alt="product.name">
                            <div class="spinner-border m-5" role="status"></div>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <i :class="['fa', product.section.icon]"></i>
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
                                <button v-if="product.is_fave" @click.prevent="store.dispatch('removeProductFromFavorites', product)" class="btn btn-fav active border-0">
                                    <i class="fa-regular fa-heart active-wishlist"></i>
                                </button>

                                <button v-else @click.prevent="store.dispatch('addProductToFavorites', product)" class="btn btn-fav border-0">
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
                                <form v-else @submit.prevent="store.dispatch('addGeneralProductToCart', product)">
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
                </slide>
                <template #addons>
                    <pagination />
                    <navigation />
                </template>
            </carousel>
        </div>
    </section>
</template>

<style>
#most-popular-products {
    padding: 44px 0 0 0;
}

#most-popular-products h5 {
    font-size: 21px;
    line-height: 28px;
    margin-bottom: 25px;
}

#most-popular-products h5 a {
    font-size: 17px;
    font-family: Tajawal-Regular, sans-serif;
    line-height: 20px;
    float: left;
}

#most-popular-products h5 i .fa {
    font-size: 10px;
}

#most-popular-products .carousel {
    text-align: center;
}

#most-popular-products .carousel__viewport {
    height: 480px;
}

#most-popular-products .product-item {
    background: var(--white-color) 0 0 no-repeat padding-box;
    border: 1px solid #EEF1F6;
    border-radius: 10px;
    margin-bottom: 10px;
    padding: 20px;
    text-align: start;
    width: 300px;
}

@media(min-width: 450px) and (max-width: 550px){
    #most-popular-products .product-item {
    width: unset;
    }
    #most-popular-products .product-item .card-img-top{
        max-height: unset;
        height: 155px;
        width: 100%;
        object-fit: contain;
    }
}

#most-popular-products .container {
    height: 530px;
}

#most-popular-products .see-more-details {
    border: none;
    background-color: #fff;
    font-size: 16px;
}
#most-popular-products .new_add_to_cart {
    border: none;
    background-color: #fff;
    font-size: 16px;
}
#most-popular-products .new_remove_from_cart {
    border: none;
    background-color: #fff;
    font-size: 16px;
    color: #dc3545;
}

#most-popular-products .product-item:hover {
    box-shadow: 0 2px 20px #0000001A;
    transition: 300ms ease;
}

#most-popular-products .product-item:hover .card-sub-title .price-after {
    color: var(--primary-color);
    transition: 300ms ease;
}

#most-popular-products .product-item:hover .btn-primary-color,
#most-popular-products .product-item:hover .btn-danger2 {
    display: inline-block;
    transition: 300ms ease;
}

#most-popular-products .btn-danger2 {
    display: inline-block;
    transition: 300ms ease;
}

.active-wishlist {
    color: #dc3545;
}


#most-popular-products .product-item .top-product-div {
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid #e2e2e2;
    margin-bottom: 10px;
    padding-top: 10px;
}
#most-popular-products .product-item .top-product-div button{
    font-size: 16px;
    box-shadow: 0 2px 20px #0000001a;
    border-radius: 50%;
    height: 40px;
    width: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#most-popular-products .product-item .top-product-div button:hover ,
#most-popular-products .product-item .top-product-div button:active{
    color: #dc3545;
    transition: 300ms ease;
}

#most-popular-products .product-item .top-product-div .btn-fav:hover,
#most-popular-products .product-item .top-product-div .btn-fav.active {
    color: #dc3545;
    transition: 300ms ease;
}

#most-popular-products .product-item .top-product-div .discount {
    background: var(--primary-color) 0 0 no-repeat padding-box;
    color: var(--white-color);
    border-radius: 2px;
    float: left;
    padding: 0 10px;
    z-index: 3;
}



#most-popular-products .product-item .card-img-top {
    max-height: 155px;
    object-fit: contain;
}

#most-popular-products .product-item .card-body {
    padding: 40px 0 0 0 !important;
}

#most-popular-products .product-item .card-text {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

#most-popular-products .product-item .card-text span {
    font-size: 12px;
    color: var(--basic-700-color);
}

#most-popular-products .product-item .card-title {
    display: block;
    color: var(--basic-1000-color);
    font-size: 14px;
    font-family: Tajawal-Medium, sans-serif;
    margin-bottom: 10px;
    min-height: 48px;
}

#most-popular-products .product-item .card-sub-title {
    display: block;
    font-size: 16px;
    margin-bottom: 15px;
}

#most-popular-products .product-item .card-sub-title .price-after {
    color: var(--basic-1000-color);
    font-family: Tajawal-Bold, sans-serif;
    margin-left: 10px;
}

#most-popular-products .product-item .card-sub-title .price-before {
    color: #C5C8B8;
    font-family: Tajawal-Regular, sans-serif;
    text-decoration: line-through;
}

#most-popular-products .product-item .btn-primary-color,
#most-popular-products .product-item .btn-danger2 {
    display: none;
}

#most-popular-products .carousel__icon {
    background: var(--basic-200-color) 0 0 no-repeat padding-box;
    width: 27px;
    height: 27px;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
}

#most-popular-products .carousel__prev {
    background: var(--basic-200-color) 0 0 no-repeat padding-box;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    top: 165px;
}

#most-popular-products .carousel__next {
    background: var(--basic-200-color) 0 0 no-repeat padding-box;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    top: 165px;
}

@media(max-width: 300px){
    #most-popular-products .product-item{
        width: unset !important;
    }
}
@media(min-width: 650px) and (max-width: 1300px){
    #stores .store-item .img-div{
        width: unset;
    }
    #most-popular-products .product-item{
        width: unset;
    }
}
.card-img-top:hover {
    cursor: pointer;
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
