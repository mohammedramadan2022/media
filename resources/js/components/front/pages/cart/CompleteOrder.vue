<script setup>
import {useStore} from "vuex";
import AppLayout from "@/components/front/layout/AppLayout";
import {computed, onBeforeMount} from "vue";
import User from "@/libs/User";
import {useRouter} from "vue-router/dist/vue-router";
import CartOrderItem from "@/components/front/pages/cart/CartOrderItem";
import {getJsonCustomKey} from "@/composables/useStorage";
import moment from "moment";

const store = useStore();
const {push} = useRouter();
let auth = User.auth();

let rentingSystemType = computed(() => store.state.cart.rentingSystemType);
let cartHourlySummaryData = computed(() => store.state.cart.cartHourlySummaryData);

onBeforeMount(() => {
    store.commit('updateCompleteCartSummary');
    if(!getJsonCustomKey('cartSummary')) return push({name: 'shopping-cart'});
    if(rentingSystemType.value === 'day') store.dispatch('getUserCart');
    else store.dispatch('calculateEndDateHours', cartHourlySummaryData.value);
});

store.dispatch('getAllAddresses');
store.dispatch('getAllCities');

let addresses = computed(() => store.state.address.addresses);
let address = computed(() => store.state.address.address);
let products = computed(() => store.state.cart.getCartProducts);
let summary = computed(() => store.state.cart.cartSummary);
let days = computed(() => store.state.cart.cartSummaryDays);
let hours = computed(() => store.state.cart.cartSummaryHours);
let completeOrderData = computed(() => store.state.cart.completeOrderData);
let is_empty = computed(() => store.state.cart.isCartEmpty);
let cartAddresses = computed(() => store.state.cart.cartAddresses);
let addressData = computed(() => store.state.address.addressData);
let errors = computed(() => store.state.errors);
let cities = computed(() => store.state.getAllCities);
let timesList = computed(() => store.state.cart.timesList);
let shoppingCart = computed(() => store.state.cart);

async function removeProductFromFave(product) {
    let res = await store.dispatch('removeProductFromFavorites', product);
    if(res === 'confirmed') product.is_fave = false;
}

function addProductToCart(product) {
    store.dispatch('addProductToFavorites', product);
    product.is_fave = true;
}

function changeDeliverWay() {
    let addresses_length = addresses.value.length;

    if(addresses_length === 0) $('#deliver-div').removeClass('d-none');

    if(addresses_length > 0) {
        $('#show-addresses-div').removeClass('d-none');
        $('#from-location-div').addClass('d-none');
        $('#deliver-div').addClass('d-none');
    }

    store.commit('updateDeliveryType','address');
}

function changeFromLocation() {
    let addresses_length = addresses.value.length;

    if(addresses_length > 0) {
        $('#show-addresses-div').addClass('d-none');
        $('#from-location-div').removeClass('d-none');
        $('#deliver-div').addClass('d-none');
    }

    store.commit('updateDeliveryType','location');
}

function showAllAddresses() {
    changeDeliverWay();
    store.state.errors = {};
    $('#edit-address-div').addClass('d-none');
}

function showEditAddress(address) {
    store.dispatch('getAddressById', address.id);
    $('#deliver-div').addClass('d-none');
    $('#add-address-div').addClass('d-none');
    $('#edit-address-div').removeClass('d-none');
    $('#show-addresses-div').addClass('d-none');
}

function showAddAddress() {
    store.state.address.addressData = {};
    $('#deliver-div').addClass('d-none');
    $('#show-addresses-div').addClass('d-none');
    $('#add-address-div').removeClass('d-none');
    $('#edit-address-div').addClass('d-none');
}

function setAddressDefault(address) {
    store.dispatch('changeDefaultAddress', address);
    store.commit('setAddressDefaultValue', address.id);
}

function changeEndDate(value) {
    store.dispatch('calculateEndDateDays',{
        startDate: completeOrderData.value.startDate,
        endDate: value
    });
}

function changeStartDate(value) {
    store.dispatch('calculateEndDateDays',{
        endDate: completeOrderData.value.endDate,
        startDate: value
    });
}

function changeStartTime(value) {
    store.commit('setEndTimeFromCompleteValue', value);
}

function changeEndTime(value) {
    store.dispatch('calculateCartTimeDays',{
        startTimeValue: completeOrderData.value.startTime,
        endTimeValue: value
    });
}

function changeHourlyStartDate(value) {
    completeOrderData.value.startDate = value;
    store.dispatch('calculateEndDateHours',{
        startDate: value,
        endDate: completeOrderData.value.endDate,
        startTime: completeOrderData.value.startTime,
        endTime: completeOrderData.value.endTime
    });
}

function changeHourlyStartTime(value) {
    completeOrderData.value.startTime = value;
    store.dispatch('calculateEndDateHours',{
        startDate: completeOrderData.value.startDate,
        endDate: completeOrderData.value.endDate,
        startTime: value,
        endTime: completeOrderData.value.endTime,
    });
}

function changeHourlyEndDate(value) {
    completeOrderData.value.endDate = value;
    store.dispatch('calculateEndDateHours', {
        startDate: completeOrderData.value.startDate,
        endDate: value,
        startTime: completeOrderData.value.startTime,
        endTime: completeOrderData.value.endTime
    });
}

function changeHourlyEndTime(value) {
    completeOrderData.value.endTime = value;
    store.dispatch('calculateEndDateHours',{
        startDate: completeOrderData.value.startDate,
        endDate: completeOrderData.value.endDate,
        startTime: completeOrderData.value.startTime,
        endTime: value,
    });
}

changeStartDate(completeOrderData.value.startDate);

changeEndDate(completeOrderData.value.endDate);

function applyCoupon(){
    store.dispatch('applyCoupon', completeOrderData.value.coupon);
    $('#content.cart-fill.complete-order .order-summary .data form .coupon-div .alert-danger').addClass('d-none');
}

function removeCoupon(){
    store.state.cart.is_applied = false;
    store.state.errors = {};
    $('#content.cart-fill.complete-order .order-summary .data form .coupon-div .alert-danger').addClass('d-none');
}

store.commit('setAddressDefaultValue', User.auth().address_id);
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item"><router-link :to="{name: 'shopping-cart'}" v-text="$t('message.shoppingCart')"></router-link></li>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'complete-cart-order'}" v-text="$t('message.completeCartOrder')"></router-link>
            </li>
        </template>

        <section id="content" class="cart-fill complete-order">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9">
                        <!-- deliver way -->
                        <div id="deliver-way" class="deliver-way text-center text-sm-start">
<!--                            <h1 v-text="$t('message.chooseHowToGetTheProduct')"></h1>-->

<!--                            <div id="deliver-way-options" class="deliver-way-options">-->
<!--                                <div class="form-check form-check-inline checked">-->
<!--                                    <input class="form-check-input" type="radio" @click="changeFromLocation" name="delivery_type" id="from_location" value="location" checked>-->
<!--                                    <label class="form-check-label" for="from_location" v-text="$t('message.receiptFromLocation')"></label>-->
<!--                                </div>-->
<!--                                <div class="form-check form-check-inline">-->
<!--                                    <input class="form-check-input" type="radio" @click="changeDeliverWay" name="delivery_type" id="deliver" value="address">-->
<!--                                    <label class="form-check-label" for="deliver" v-text="$t('message.delivery')"></label>-->
<!--                                </div>-->
<!--                            </div>-->

                            <!-- from location -->
<!--                            <div id="from-location-div" class="text-start d-none">-->
<!--                                <div class="address-title" v-text="$t('message.addressMessage')"></div>-->
<!--                                <template v-for="(cartAddress, index) in cartAddresses" :key="index">-->
<!--                                    <div class="address-info">-->
<!--                                        <i class="fa-solid fa-location-dot"></i>-->
<!--                                        <div class="ms-3">-->
<!--                                            <span v-text="cartAddress.address"></span>-->
<!--                                            <div class="d-flex align-items-baseline mt-2">-->
<!--                                                <span class="phone-title" v-text="$t('message.mobile')"></span>-->
<!--                                                <span class="phone-value" v-text="cartAddress.phone"></span>-->
<!--                                                <i class="fa-solid fa-circle-check"></i>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </template>-->
<!--                            </div>-->

                            <!-- deliver -->
                            <div id="deliver-div" class="d-none">
                                <h6 v-text="$t('message.noAddresses')"></h6>
                                <a href="javascript:void(0);" class="add-address-big-link">
                                    <div>
                                        <i class="fa-solid fa-circle-plus"></i>
                                        <span class="ms-2" v-text="$t('message.addNewAddress')"></span>
                                    </div>
                                </a>
                            </div>

                            <!-- show addresses -->
                            <div id="show-addresses-div">
                                <div class="row justify-content-between align-items-center mb-3">
                                    <div class="col-auto">
                                        <h6 v-text="$t('message.selectDeliverAddress')"></h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="javascript:void(0);" @click.prevent="showAddAddress" class="add-new-address">
                                            <i class="fa-solid fa-circle-plus"></i>{{ $t('message.addNewAddress') }}
                                        </a>
                                    </div>
                                </div>

                                <div class="row gy-3 row-cols-1 row-cols-lg-2">
                                    <div class="col" v-for="(address, index) in addresses.filter(addr => addr.city.id === auth.city.id)" :key="index" :id="'address-id-'+address.id">
                                        <div class="address-item">
                                            <div class="row justify-content-between align-items-center address-item-title">
                                                <div class="col-auto">
                                                    <div class="form-check" style="position: relative;">
                                                        <input class="form-check-input" @click.prevent="setAddressDefault(address)" type="radio" name="address_id" :checked="auth.address_id === address.id" :value="address.id" :id="'address-'+address.id">
                                                        <span :id="'custom-check-icon-js-' + address.id"></span>
                                                        <label class="form-check-label" :for="'address-'+address.id">
                                                            <i class="fa-solid fa-location-dot me-2"></i> {{ $t('message.addressNo', {num: index+1}) }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="javascript:void(0);" @click.prevent="showEditAddress(address)" class="address-actions edit-address">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" @click.prevent="store.dispatch('deleteUserAddress', address.id)" class="address-actions remove-address">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="row gy-3 align-items-center address-item-body">
                                                <div class="col-3"><span class="title" v-text="$t('message.address')"></span></div>
                                                <div class="col-9"><span class="value" v-text="address.full_address"></span></div>
                                                <div class="col-3"><span class="title" v-text="$t('message.phone')"></span></div>
                                                <div class="col-9">
                                                    <span class="value" v-text="address.phone"></span>
                                                    <i class="fa-solid fa-circle-check ms-3"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- add address -->
                            <div id="add-address-div" class="d-none">
                                <form @submit.prevent="store.dispatch('addNewAddress',true)">
                                    <div class="row justify-content-between align-items-center mb-3">
                                        <div class="col-auto">
                                            <h6 v-text="$t('message.addNewAddress')"></h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="javascript:void(0);" @click="store.state.errors = {}" class="address-cancel" v-text="$t('message.cancel')"></a>
                                            <button type="submit" class="btn btn-primary-color" v-text="$t('message.add')"></button>
                                        </div>
                                    </div>

                                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 text-start">
                                        <div class="col">
                                            <div class="mb-2">
                                                <label for="address-recipient-name" class="form-label" v-text="$t('message.recipientName')"></label>
                                                <input type="text" :class="{'has-error-custom': errors.recipient_name}" v-model="addressData.recipient_name" class="form-control" id="address-recipient-name" :placeholder="$t('message.enterVar', {var: $t('message.recipientName')})">
                                            </div>
                                            <span class="text-danger" v-if="errors.recipient_name">{{ errors.recipient_name[0] }}</span>
                                        </div>
                                        <div class="col">
                                            <div class="mb-2">
                                                <label for="address-mobile" class="form-label" v-text="$t('message.phone')"></label>
                                                <input type="number" min="0" :class="{'has-error-custom': errors.phone}" v-model="addressData.phone" class="form-control" id="address-mobile" :placeholder="$t('message.enterVar', {var: $t('message.phone')})">
                                            </div>
                                            <span class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</span>
                                        </div>
                                        <div class="col">
                                            <div class="mb-2">
                                                <label for="address-city" class="form-label" v-text="$t('message.city')"></label>
                                                <select :class="{'has-error-custom': errors.city_id}" class="form-select" v-model="addressData.city_id" id="address-city">
                                                    <option value="" v-text="$t('message.chooseACity')"></option>
                                                    <option v-for="(city, index) in store.state.getAllCities" :value="city.id" :key="index" v-text="city.text"></option>
                                                </select>
                                            </div>
                                            <span class="text-danger" v-if="errors.city_id">{{ errors.city_id[0] }}</span>
                                        </div>
                                        <div class="col">
                                            <div class="mb-2">
                                                <label for="address-street-name" class="form-label" v-text="$t('message.streetName')"></label>
                                                <input type="text" :class="{'has-error-custom': errors.street}" class="form-control" v-model="addressData.street" id="address-street-name" :placeholder="$t('message.enterVar', {var: $t('message.streetName')})">
                                            </div>
                                            <span class="text-danger" v-if="errors.street">{{ errors.street[0] }}</span>
                                        </div>
                                        <div class="col">
                                            <div class="mb-2">
                                                <label for="address-trademark" class="form-label" v-text="$t('message.specialMarque')"></label>
                                                <input type="text" :class="{'has-error-custom': errors.special_marque}" class="form-control" v-model="addressData.special_marque" id="address-trademark" :placeholder="$t('message.enterVar', {var: $t('message.specialMarque')})">
                                            </div>
                                            <span class="text-danger" v-if="errors.special_marque">{{ errors.special_marque[0] }}</span>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- edit address -->
                            <div id="edit-address-div" class="d-none">
                                <form @submit.prevent="store.dispatch('updateUserAddress', address.id)">
                                    <div class="row justify-content-between align-items-center mb-3">
                                        <div class="col-auto">
                                            <h6 v-text="$t('message.editAddress')"></h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="javascript:void(0);" @click="showAllAddresses" class="address-cancel" v-text="$t('message.cancel')"></a>
                                            <button type="submit" class="btn btn-primary-color" v-text="$t('message.edit')"></button>
                                        </div>
                                    </div>

                                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 text-start">
                                        <div class="col">
                                            <div class="mb-2">
                                                <label for="address-recipient-name" class="form-label" v-text="$t('message.recipientName')"></label>
                                                <input type="text" :class="{'has-error-custom': errors.recipient_name}" class="form-control" v-model="addressData.recipient_name" id="address-recipient-name" :placeholder="$t('message.enterVar', {var: $t('message.recipientName')})">
                                            </div>
                                            <span class="text-danger" v-if="errors.recipient_name" v-text="errors.recipient_name[0]"></span>
                                        </div>
                                        <div class="col">
                                            <div class="mb-2">
                                                <label for="address-mobile" class="form-label" v-text="$t('message.phone')"></label>
                                                <input type="number" :class="{'has-error-custom': errors.phone}" min="0" v-model="addressData.phone" class="form-control" id="address-mobile" :placeholder="$t('message.enterVar', {var: $t('message.phone')})">
                                            </div>
                                            <span class="text-danger" v-if="errors.phone" v-text="errors.phone[0]"></span>
                                        </div>
                                        <div class="col">
                                            <div class="mb-2">
                                                <label for="address-city" class="form-label" v-text="$t('message.city')"></label>
                                                <select :class="{'has-error-custom': errors.city_id}" class="form-select" v-model="addressData.city_id" id="address-city">
                                                    <option value="" v-text="$t('message.chooseACity')"></option>
                                                    <option v-for="(city, index) in cities" :selected="address.city_id === city.id" :value="city.id" :key="index" v-text="city.text"></option>
                                                </select>
                                            </div>
                                            <span class="text-danger" v-if="errors.city_id" v-text="errors.city_id[0]"></span>
                                        </div>
                                        <div class="col">
                                            <div class="mb-2">
                                                <label for="address-street-name" class="form-label" v-text="$t('message.streetName')"></label>
                                                <input type="text" :class="{'has-error-custom': errors.street}" class="form-control" v-model="addressData.street" id="address-street-name" :placeholder="$t('message.enterVar', {var: $t('message.streetName')})">
                                            </div>
                                            <span class="text-danger" v-if="errors.street" v-text="errors.street[0]"></span>
                                        </div>
                                        <div class="col">
                                            <div class="mb-2">
                                                <label for="address-trademark" class="form-label" v-text="$t('message.specialMarque')"></label>
                                                <input type="text" :class="{'has-error-custom': errors.special_marque}" class="form-control" v-model="addressData.special_marque" id="address-trademark" :placeholder="$t('message.enterVar', {var: $t('message.specialMarque')})">
                                            </div>
                                            <span class="text-danger" v-if="errors.special_marque" v-text="errors.special_marque[0]"></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- your cart products -->
                        <div class="cart-products">
                            <div class="row justify-content-between align-items-center cart-products-title mb-3">
                                <div class="col-auto">
                                    <h1 v-text="$t('message.yourOrder')"></h1>
                                </div>
<!--                                <div class="col-auto">-->
<!--                                    <router-link @click="store.dispatch('getUserCart', User.auth().cart_id)" :to="{name: 'shopping-cart'}"><i class="fa-solid fa-pencil"></i>&nbsp;&nbsp;{{$t('message.edit')}}</router-link>-->
<!--                                </div>-->
                            </div>

                            <cart-order-item v-for="product in products" @removeProductFromFave="removeProductFromFave(product)" @addProductToCart="addProductToCart(product)" :product="product"/>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="order-summary">
                            <h1 class="title" v-text="$t('message.orderSummary')"></h1>
                            <div class="data">
                                <form @submit.prevent="store.dispatch('completeUserOrder')">
                                    <div class="row gx-2">
                                        <!-- have a coupon -->
                                        <div class="col-12">
                                            <div class="coupon-div mb-2">
                                                <label for="coupon" class="form-label text-primary-color" v-text="$t('message.doYouHaveCoupon')"></label>
                                                <div class="input-group">
                                                    <input type="text" v-model="completeOrderData.coupon" :class="{'has-error-custom': errors.coupon}" class="form-control" :placeholder="$t('message.enterCoupon')" id="coupon">
                                                    <button type="button" @click.prevent="applyCoupon" class="btn btn-primary-color" v-text="$t('message.apply')"></button>
                                                    <button @click="removeCoupon" class="btn btn-danger2" :class="{'d-none': !shoppingCart.is_applied}" type="button">
                                                        <i class="fa fa-times"></i>&nbsp;&nbsp;{{ $t('message.remove') }}
                                                    </button>
                                                </div>

                                                <div class="alert alert-danger d-inline-flex" style="margin-top: 5px;" v-if="errors.coupon" role="alert">
                                                    <div class="ms-1" v-text="errors.coupon[0]"></div>
                                                </div>

                                                <div class="alert alert-success d-inline-flex" :class="{'d-none': shoppingCart.coupon_discount === 0}" role="alert">
                                                    <i class="fa-solid fa-percent"></i>
                                                    <div class="ms-1" v-text="$t('message.discountApplied')"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- dates & times -->
                                        <div class="col-6" v-if="rentingSystemType === 'day'">
                                            <div class="mb-2">
                                                <label for="start-date" class="form-label" v-text="$t('message.changeTheDateOfReceipt')"></label>
                                                <input type="date" @change.prevent="changeStartDate($event.target.value)" :class="{'has-error-custom': errors.startDate}" v-model="completeOrderData.startDate" class="form-control" id="start-date">
                                                <span class="text-danger" v-if="errors.startDate" v-text="errors.startDate[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-6" v-else>
                                            <div class="mb-2">
                                                <label for="start-date" class="form-label" v-text="$t('message.changeTheDateOfReceipt')"></label>
                                                <input type="date" @change.prevent="changeHourlyStartDate($event.target.value)" :class="{'has-error-custom': errors.startDate}" v-model="completeOrderData.startDate" class="form-control" id="start-date">
                                                <span class="text-danger" v-if="errors.startDate" v-text="errors.startDate[0]"></span>
                                            </div>
                                        </div>

                                        <div class="col-6" v-if="rentingSystemType === 'day'">
                                            <div class="mb-2">
                                                <label for="start-time" class="form-label" v-text="$t('message.changeTimeOfReceipt')"></label>
                                                <input type="time" @change.prevent="changeStartTime($event.target.value)" :class="{'has-error-custom': errors.startTime}" v-model="completeOrderData.startTime" class="form-control" id="start-time">
                                                <span class="text-danger" v-if="errors.startTime" v-text="errors.startTime[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-6" v-else>
                                            <div class="mb-2">
                                                <label for="start-time" class="form-label" v-text="$t('message.changeTimeOfReceipt')"></label>
                                                <select dir="ltr" @change.prevent="changeHourlyStartTime($event.target.value)" :class="{'has-error-custom': errors.startTime}" v-model="completeOrderData.startTime" class="form-control" id="start-time">
                                                    <template v-for="time in timesList" :key="time.key">
                                                        <option :value="time.key" v-text="time.value"></option>
                                                    </template>
                                                </select>
                                                <span class="text-danger" v-if="errors.startTime" v-text="errors.startTime[0]"></span>
                                            </div>
                                        </div>

                                        <div class="col-6" v-if="rentingSystemType === 'day'">
                                            <div class="mb-2">
                                                <label for="end-date" class="form-label" v-text="$t('message.changeTheDateOfDelivery')"></label>
                                                <input type="date" @change.prevent="changeEndDate($event.target.value)" :class="{'has-error-custom': errors.endDate}" v-model="completeOrderData.endDate" class="form-control" id="end-date">
                                                <span class="text-danger" v-if="errors.endDate" v-text="errors.endDate[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-6" v-else>
                                            <div class="mb-2">
                                                <label for="end-date" class="form-label" v-text="$t('message.changeTheDateOfDelivery')"></label>
                                                <input type="date" @change.prevent="changeHourlyEndDate($event.target.value)" :class="{'has-error-custom': errors.endDate}" v-model="completeOrderData.endDate" class="form-control" id="end-date">
                                                <span class="text-danger" v-if="errors.endDate" v-text="errors.endDate[0]"></span>
                                            </div>
                                        </div>

                                        <div class="col-6" v-if="rentingSystemType === 'day'">
                                            <div class="mb-2">
                                                <label for="end-time" class="form-label" v-text="$t('message.timeOfDelivery')"></label>
                                                <div class="div-as-input" dir="ltr">
                                                    <p v-text="moment(completeOrderData.endTime, 'HH:mm').format('hh:mm A') ?? ''"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6" v-else>
                                            <div class="mb-2">
                                                <label for="end-time" class="form-label" v-text="$t('message.changeTimeOfDelivery')"></label>
                                                <select dir="ltr" @change.prevent="changeHourlyEndTime($event.target.value)" :class="{'has-error-custom': errors.endTime}" v-model="completeOrderData.endTime" class="form-control" id="end-time">
                                                    <template v-for="time in timesList" :key="time.key">
                                                        <option :value="time.key" v-text="time.value"></option>
                                                    </template>
                                                </select>
                                                <span class="text-danger" v-if="errors.endTime" v-text="errors.endTime[0]"></span>
                                            </div>
                                        </div>

                                        <!-- prices -->
                                        <div class="col-12">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <span v-text="$t('message.orderSubtotal')"></span>
                                                    <span class="float-end" v-text="$t('message.shoppingCartTotal', {total: summary.subtotal})"></span>
                                                </li>
                                                <li>
                                                    <span v-text="$t('message.orderTotalInsurance')"></span>
                                                    <span class="float-end" v-text="$t('message.shoppingCartTotal', {total: summary.total_insurance})"></span>
                                                </li>
                                                <li>
                                                    <span v-text="$t('message.orderTotalTax')"></span>
                                                    <span class="float-end" v-text="$t('message.shoppingCartTotal', {total: summary.tax})"></span>
                                                </li>
                                                <li v-if="rentingSystemType === 'day'">
                                                    <span v-text="$t('message.orderTotalDays')"></span>
                                                    <span class="float-end" v-text="days"></span>
                                                </li>
                                                <li v-else>
                                                    <span v-text="$t('message.orderTotalHours')"></span>
                                                    <span class="float-end" v-text="hours"></span>
                                                </li>
                                                <li><hr></li>
                                                <li class="total_ total">
                                                    <span class="title_" v-text="$t('message.orderTotal')"></span>
                                                    <span class="price_ float-end" v-text="$t('message.shoppingCartTotal', {total: shoppingCart.cartTotal})"></span>
                                                </li>
                                                <li class="discount" :class="{'d-none': !shoppingCart.is_applied}">
                                                    <span class="title_" v-text="$t('message.discountValue')"></span>
                                                    <span class="price_ float-end" v-text="$t('message.shoppingCartTotal', {total: shoppingCart.coupon_discount})"></span>
                                                </li>
                                                <li class="results total" :class="{'d-none': !shoppingCart.is_applied}">
                                                    <span class="title_" v-text="$t('message.totalOrderValueAfterDiscount')"></span>
                                                    <span class="price_ float-end" v-text="$t('message.shoppingCartTotal', {total: shoppingCart.coupon_total })"></span>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- warning alert -->
                                        <div class="col-12">
                                            <div class="alert alert-warning d-inline-flex" role="alert">
                                                <i class="fa-solid fa-circle-info"></i>
                                                <div class="ms-1" v-text="$t('message.orderNotice')"></div>
                                            </div>
                                        </div>

                                        <!-- agree conditions -->
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input me-2" type="checkbox" value="" id="conditions-rules-agree">
                                                <label class="form-check-label" for="conditions-rules-agree" v-text="$t('message.acceptTermsAndConditions')"></label>
                                            </div>
                                        </div>

                                        <!-- submit button -->
                                        <div class="col-12">
                                            <button disabled type="submit" id="btn-order-done" class="btn btn-primary-color w-100" v-text="$t('message.completeOrderBtn')"></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- success Modal -->
            <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12"><i class="fa-solid fa-circle-check icon"></i></div>
                                <div class="col-12"><h1 class="title" v-text="$t('message.orderSentSuccessfully')"></h1></div>
                                <div class="col-12"><p class="body" v-text="$t('message.orderSentMessage')"></p></div>
                                <div class="col-12">
                                    <a href="/profile/orders" class="btn btn-primary-color" v-text="$t('message.myOrders')"></a>
                                    <a href="/home" class="btn btn-outline-primary-color" v-text="$t('message.home')"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </app-layout>
</template>
