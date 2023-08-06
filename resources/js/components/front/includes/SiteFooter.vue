<script setup>
import {useGetImage, handleShowJoinModal} from "@/composables/useHelper";
import {computed, ref} from "vue";
import {useStore} from "vuex";
import moment from "moment";
import {getCustomKey} from "@/composables/useStorage";
import ConfirmJoinModal from "@/components/front/modals/confirmJoinModal.vue";
import Login from "@/components/front/modals/login";
import Register from "@/components/front/modals/register";
import ForgetPasswordModal from "@/components/front/modals/forgetPasswordModal";
import NewPasswordModal from "@/components/front/modals/newPasswordModal";
import ConfirmMobileModal from "@/components/front/modals/confirmMobileModal";
import CheckResetCode from "@/components/front/modals/checkResetCode";
import JoinRentalModel from "@/components/front/modals/joinRentalModel";
import ConfirmPhoneModal from "@/components/front/modals/confirmPhoneModal";

const store = useStore();
const isAuth = User.hasToken();
let cartTotalCount = getCustomKey('userCartTotal');
let dire = ref(direction);

store.dispatch('fetchFooter');

if (cartTotalCount === '0' && User.hasToken()) store.dispatch('getUserCart');

let cartCount = computed(() => store.state.cart.cartProductCount);
let fetchFooter = computed(() => store.state.footerData);
let newsletter = computed(() => store.state.newsletter);
let errors = computed(() => store.state.errors);
let year = computed(() => moment().format('YYYY'));
let is_ar = store.state.lang;
</script>

<template>
    <div>
        <footer>
            <div id="contact-us">
                <div class="container wow fadeInUp">
                    <div class="row gy-2 gy-xl-0 align-items-center">
                        <div class="col-lg-4 col-xl-5 text-start text-sm-center text-xl-start">
                            <h5 v-text="$t('message.weAreReadyToHelpYou')"></h5>
                            <span v-text="$t('message.contactUsThrough')"></span>
                        </div>
                        <div class="col-lg-8 col-xl-7">
                            <div class="row gy-2 gy-xl-0 row-cols-auto justify-content-sm-center align-items-center">
                                <!-- whatsapp -->
                                <div class="col" v-if="fetchFooter.whatsapp">
                                    <div class="contact-us-item row g-2">
                                        <div class="col-auto">
                                            <div class="contact-us-item-image">
                                                <img :src="useGetImage('front/assets/images/icons/whatsapp.svg')" alt="whatsapp icon">
                                            </div>
                                        </div>
                                        <div class="col" dir="ltr">
                                            <span class="contact-us-item-title" :dir="dire" v-text="$t('message.whatsApp')"></span>
                                            <a :href="'https://wa.me/'+fetchFooter.whatsapp" class="contact-us-item-value" v-text="fetchFooter.whatsapp"></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- mail -->
                                <div class="col">
                                    <div class="contact-us-item row g-2">
                                        <div class="col-auto">
                                            <div class="contact-us-item-image">
                                                <img :src="useGetImage('front/assets/images/icons/mail.svg')" alt="mail icon">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <span class="contact-us-item-title" v-text="$t('message.emailForConnection')"></span>
                                            <a :href="'mailto:'+fetchFooter.email" class="contact-us-item-value" v-text="fetchFooter.email"></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- phone -->
                                <div class="col" v-if="fetchFooter.mobile">
                                    <div class="contact-us-item row g-2">
                                        <div class="col-auto">
                                            <div class="contact-us-item-image">
                                                <img :src="useGetImage('front/assets/images/icons/telephone.svg')" alt="telephone icon">
                                            </div>
                                        </div>
                                        <div class="col" dir="ltr">
                                            <span class="contact-us-item-title" :dir="dire" v-text="$t('message.contactUs')"></span>
                                            <a :href="'tel:' + fetchFooter.mobile" class="contact-us-item-value" v-text="fetchFooter.mobile"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <router-link :to="{name: 'shopping-cart'}" class="outer-lower-button" v-if="isAuth">
                <div class="inner-lower-button">
                    <i class="fa fa-shopping-cart"></i>
                    <div class="indecator" v-if="cartCount > 0">
                        <span class="indecator-counter" v-text="cartCount"></span>
                    </div>
                </div>
            </router-link>

            <!-- footer -->
            <div id="footer">
                <div class="container wow fadeInUp">
                    <div class="row gx-xl-5 gx-lg-5">
                        <div class="col-sm-12 col-lg-3">
                            <router-link :to="{name: 'home'}"><img class="img-fluid footer-logo" :src="fetchFooter.footer_logo" alt="logo"></router-link>

                            <span class="footer-desc" v-text="fetchFooter.description"></span>

                            <h6 class="text-center text-sm-start" v-text="$t('message.followUsOn')"></h6>
                            <ul class="list-inline text-center text-sm-start">
                                <li class="list-inline-item"><a :href="fetchFooter.facebook"><div class="follow-us-item"><i class="fa-brands fa-facebook-f"></i></div></a></li>
                                <li class="list-inline-item"><a :href="fetchFooter.twitter"><div class="follow-us-item"><i class="fa-brands fa-twitter"></i></div></a></li>
                                <li class="list-inline-item"><a :href="fetchFooter.linkedin"><div class="follow-us-item"><i class="fa-brands fa-linkedin-in"></i></div></a></li>
                                <li class="list-inline-item"><a :href="fetchFooter.instagram"><div class="follow-us-item"><i class="fa-brands fa-instagram"></i></div></a></li>
                            </ul>
                        </div>

                        <div class="col-sm-6 col-lg-2">
                            <h5 class="footer-menu-title" v-text="$t('message.featuredLinks')"></h5>
                            <ul class="list-unstyled footer-menu-ul">
                                <li><router-link :to="{name: 'products'}" v-text="$t('message.products')"></router-link></li>
                                <li><router-link :to="{name: 'orders'}" v-text="$t('message.trackYourOrder')"></router-link></li>
                                <li><router-link :to="{name: 'shopping-cart'}" v-text="$t('message.shoppingCart')"></router-link></li>
                                <li><router-link :to="{name: 'whatWeProvide'}" v-text="$t('message.whatWeProvide')"></router-link></li>
                                <li><a href="javascript:void(0);" @click.prevent="handleShowJoinModal();" v-text="$t('message.joinRental')"></a></li>
                            </ul>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <h5 class="footer-menu-title" v-text="$t('message.importantPages')"></h5>
                            <ul class="list-unstyled footer-menu-ul">
                                <li><router-link :to="{name: 'about'}" v-text="$t('message.aboutRental')"></router-link></li>
                                <li><router-link :to="{name: 'policy'}" v-text="$t('message.policy')"></router-link></li>
                                <li><router-link :to="{name: 'terms'}" v-text="$t('message.terms')"></router-link></li>
                                <li><router-link :to="{name: 'faqs'}" v-text="$t('message.faqs')"></router-link></li>
                                <li><router-link :to="{name: 'contact-us'}" v-text="$t('message.contactUs')"></router-link></li>
                            </ul>
                        </div>

                        <div class="col-sm-12 col-lg-4 text-center text-sm-start">
                            <h5 class="footer-menu-title" v-text="$t('message.subscribeToNewsletter')"></h5>
                            <div class="rss-div">
                                <p class="rss-desc" v-text="$t('message.newsletterTitle')"></p>
                                <form @submit.prevent="store.dispatch('newsletterSubscription')">
                                    <div class="input-group">
                                        <input type="email" :style="[errors.email ? {border: '1px solid red'} : '']" v-model="newsletter.email" class="form-control rss-input" :placeholder="$t('message.email')">
                                        <button class="btn rss-button" type="submit" v-text="$t('message.subscribe')"></button>
                                    </div>
                                    <span class="text-danger" style="padding: 5px;" v-if="errors.email" v-text="errors.email[0]"></span>
                                </form>
                                <div class="payment-gateways">
                                    <ul class="list-unstyled footer-gateway">
                                        <li><a href="#"><img :src="useGetImage('front/assets/images/gateways/visa.png')" alt=""></a></li>
                                        <li><a href="#"><img :src="useGetImage('front/assets/images/gateways/mada.png')" alt=""></a></li>
                                        <li><a href="#"><img :src="useGetImage('front/assets/images/gateways/apple_pay.png')" alt=""></a></li>
                                        <li><a href="#"><img :src="useGetImage('front/assets/images/gateways/stc.png')" alt=""></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- copy rights -->
            <div id="copy-rights">
                <div class="container wow fadeInUp">
                    <div class="row gy-2 gy-xl-0 row-cols-1 row-cols-sm-auto text-center text-xl-start justify-content-center justify-content-lg-center align-items-center">
<!--                        <div class="col d-flex justify-content-center align-items-center">-->
<!--                            <span class="me-1 font-size-15" v-text="$t('message.madeWithAllLove')"></span>-->
<!--                            <router-link :to="{name: 'home'}">-->
<!--                                <img class="img-fluid" :src="useGetImage('front/assets/images/wesal.png')" width="137" height="38" alt="wesal logo">-->
<!--                            </router-link>-->
<!--                        </div>-->

                        <div class="col">
                            <span class="font-size-15" v-text="$t('message.copyRights', {year})"></span>
                        </div>

<!--                        <div class="col d-flex justify-content-center align-items-center">-->
<!--                            <span class="me-2 font-tajawal-bold font-size-15" v-text="$t('message.verifiedIn')"></span>-->
<!--                            <router-link :to="{name: 'home'}">-->
<!--                                <img class="img-fluid" :src="useGetImage('front/assets/images/maarouf.png')" width="38" height="38" alt="maarouf logo">-->
<!--                            </router-link>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
        </footer>

        <!-- canvas -->
        <div class="offcanvas" :class="[is_ar === 'ar' ? 'offcanvas-start' : 'offcanvas-end']" tabindex="-1" id="all-sections">
            <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="list-unstyled">
                    <li class="mb-3"><router-link :to="{name: 'home'}" class="active" v-text="$t('message.home')"></router-link></li>
                    <li class="mb-3"><router-link :to="{name: 'products'}" v-text="$t('message.allProducts')"></router-link></li>
                    <li class="mb-3"><router-link :to="{name: 'sections'}" v-text="$t('message.sections')"></router-link></li>
                    <li class="mb-3"><router-link :to="{name: 'shopping-cart'}" v-text="$t('message.shoppingCart')"></router-link></li>
                    <li class="mb-3"><router-link :to="{name: 'contact-us'}" v-text="$t('message.contactUs')"></router-link></li>

                    <template v-if="!isAuth">
                         <li class="mb-3"><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#loginModal" v-text="$t('message.login')"></a></li>
                    </template>

                    <li class="mb-3"><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#joinRentalBusinessModal" v-text="$t('message.joinRental')"></a></li>

                    <li class="mb-3">
                        <router-link :to="{name: 'offers'}" class="offers">
                            <img :src="useGetImage('front/assets/images/icons/offers.svg')" alt="offers icon">
                            {{$t('message.offers')}}
                        </router-link>
                    </li>
                    <li class="mb-3"><router-link :to="{name: 'stores'}" v-text="$t('message.allStores')"></router-link></li>
                    <li><router-link :to="{name: 'whatWeProvide'}" v-text="$t('message.whatWeProvide')"></router-link></li>
                </ul>
            </div>
        </div>
        <!-- end of canvas -->

        <login/>
        <forget-password-modal/>
        <confirm-mobile-modal/>
        <confirm-phone-modal/>
        <new-password-modal/>
        <register/>
        <check-reset-code/>
        <join-rental-model/>
        <confirm-join-modal/>
    </div>
</template>

<style>
    .footer-gateway{
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 25px;
    }
    .footer-gateway li{
        margin-left: 15px;
        background-color: #fff;
        padding: 10px 5px;
        border-radius: 5px;
    }
    .footer-gateway li a:hover{
        cursor: pointer;
    }
    .footer-gateway li a img{
        height: 20px;
        width: 60px;
        object-fit: contain;
    }
    @media(max-width: 767px){
        .footer-gateway li a img{
        height: 15px;
        width: 40px;
        }
        .footer-gateway li{
        margin-left: 15px;
        background-color: #fff;
        padding: 5px;
        border-radius: 5px;
        }
    }

    .outer-lower-button{
        position: fixed;
        bottom: 16px;
        left: 16px;
    }
    .inner-lower-button{
        position: relative;
        height: 60px;
        width: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #b29d7b;
        border-radius: 50px;
        color: #EEEFE8;
        cursor: pointer;
        font-size: 26px;
        outline: none;
        transition: all .3s;
        z-index: 99;
        //border: 2px solid #eeefe8;
    }
    .inner-lower-button .indecator{
        background-color: #d13737;
        height: 25px;
        min-width: 25px;
        border-radius: 50%;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        bottom: 38px;
        left: 38px;
    }
    .indecator-counter {
        position: absolute;
        top: 3px;
        font-weight: bolder;
        font-size: 15px;
    }
    .inner-lower-button i{
        font-size: 24px;
        color: #EEEFE8;
    }

    @media(max-width: 767px){
    .inner-lower-button .indecator{
        bottom: 35px !important;
        font-size: 12px !important;
        height: 20px !important;
        left: 35px !important;
        min-width: 20px !important;
    }
    .inner-lower-button{
        font-size: 26px !important;
        height: 60px !important;
        width: 60px !important;
    }
    .indecator-counter{
        top: 0px !important;
    }
}
</style>
