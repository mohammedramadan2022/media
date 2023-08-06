<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import {useGetImage} from "@/composables/useHelper";
import {computed, onBeforeMount} from "vue";
import User from "@/libs/User";
import {useRouter} from "vue-router";
import {useStore} from "vuex";
import CartItem from "@/components/front/pages/cart/CartItem";
import {removeProductFromFave, addProductToFavoritesList} from "@/composables/useFave";
import moment from "moment";

const {push} = useRouter();
const store = useStore();

let rentingSystemType = computed(() => store.state.cart.rentingSystemType);
let products = computed(() => store.state.cart.getCartProducts);
let summary = computed(() => store.state.cart.cartSummary);
let is_empty = computed(() => store.state.cart.isCartEmpty);
let cartSummaryData = computed(() => store.state.cart.cartSummaryData);
let cartHourlySummaryData = computed(() => store.state.cart.cartHourlySummaryData);
let days = computed(() => store.state.cart.cartSummaryDays);
let hours = computed(() => store.state.cart.cartSummaryHours);
let errors = computed(() => store.state.errors);
let timesList = computed(() => store.state.cart.timesList);

onBeforeMount(() => {
    cartSummaryData.value.startTime = moment().add(2,'hours').format("HH:mm");
    cartSummaryData.value.endTime = moment().add(2,'hours').format("HH:mm");
});

if(User.hasToken()) store.dispatch('getUserCart');
// else store.dispatch('calculateEndDateHours', cartHourlySummaryData.value);

store.commit('setEndTimeValue', cartSummaryData.value.startTime);

function changeStartDate(value) {
    store.dispatch('calculateEndDateDays',{
        endDate: cartSummaryData.value.endDate,
        startDate: value
    });
}

function changeEndDate(value) {
    store.dispatch('calculateEndDateDays',{
        startDate: cartSummaryData.value.startDate,
        endDate: value
    });
}

function changeStartTime(value) {
    cartSummaryData.value.endTime = value;
}

function changeHourlyStartDate(value) {
    cartHourlySummaryData.value.startDate = value;
    store.dispatch('calculateEndDateHours',{
        startDate: value,
        endDate: cartHourlySummaryData.value.endDate,
        startTime: cartHourlySummaryData.value.startTime,
        endTime: cartHourlySummaryData.value.endTime,
    });
}

function changeHourlyEndDate(value) {
    cartHourlySummaryData.value.endDate = value;
    store.dispatch('calculateEndDateHours',{
        startDate: cartHourlySummaryData.value.startDate,
        endDate: value,
        startTime: cartHourlySummaryData.value.startTime,
        endTime: cartHourlySummaryData.value.endTime,
    });
}

function changeHourlyStartTime(value) {
    cartHourlySummaryData.value.startTime = value;
    store.dispatch('calculateEndDateHours',{
        startDate: cartHourlySummaryData.value.startDate,
        endDate: cartHourlySummaryData.value.endDate,
        startTime: value,
        endTime: cartHourlySummaryData.value.endTime,
    });
}

function changeHourlyEndTime(value) {
    cartHourlySummaryData.value.endTime = value;
    store.dispatch('calculateEndDateHours',{
        endDate: cartHourlySummaryData.value.endDate,
        startDate: cartHourlySummaryData.value.startDate,
        startTime: cartHourlySummaryData.value.startTime,
        endTime: value,
    });
}
</script>

<template>
    <div>
        <app-layout>
            <template #nav>
                <li class="breadcrumb-item active">
                    <router-link :to="{name: 'shopping-cart'}" v-text="$t('message.cart')"></router-link>
                </li>
            </template>

            <section id="content" class="cart-empty" v-if="is_empty">
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-auto">
                            <img class="img-fluid" :src="useGetImage('front/assets/images/add-to-cart.png')" alt="empty cart image">
                            <span v-text="$t('message.shoppingCartEmpty')"></span>
                            <router-link :to="{name: 'home'}" class="btn btn-primary-color px-5" v-text="$t('message.rental')"></router-link>
                        </div>
                    </div>
                </div>
            </section>

            <!-- content -->
            <section id="content" class="cart-fill" v-else>
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">
                            <div class="cart-products">
                                <cart-item
                                    v-for="product in products"
                                    :key="product.id"
                                    @removeProductFromFave="removeProductFromFave(product)"
                                    @addProductToFavoritesList="addProductToFavoritesList(product)"
                                    :product="product"
                                />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="order-summary">
                                <nav>
                                    <div class="nav nav-tabs d-flex justify-content-around" id="nav-tab" role="tablist">
                                        <button
                                            class="nav-link active"
                                            id="nav-profile-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#booking_by_days"
                                            type="button"
                                            role="tab"
                                            @click="store.commit('setRentingSystemType','day');store.state.errors={};"
                                            aria-controls="nav-profile"
                                            aria-selected="false"
                                            v-text="$t('message.dayRentingSystem')"></button>
                                        <button
                                            class="nav-link"
                                            id="nav-home-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#booking_by_hours"
                                            type="button"
                                            @click="store.commit('setRentingSystemType','hour');store.state.errors={};"
                                            role="tab"
                                            aria-controls="nav-home"
                                            aria-selected="true"
                                            v-text="$t('message.hourRentingSystem')"></button>
                                    </div>
                                </nav>
                                <h1 class="title mt-3" v-text="$t('message.orderSummary')"></h1>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="booking_by_days" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <div class="data">
                                            <form @submit.prevent="store.dispatch('saveOrderSummaryDates')">
                                                <div class="row gx-2">
                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="start-date" class="form-label" v-text="$t('message.determineTheDateOfReceipt')"></label>
                                                            <input type="date" @change.prevent="changeStartDate($event.target.value)" v-model="cartSummaryData.startDate" class="form-control" :class="{'has-error-custom': errors.startDate}" id="start-date">
                                                        </div>
                                                        <span class="text-danger" style="font-size: 11px;" v-if="errors.startDate" v-text="errors.startDate[0]"></span>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="start-time" class="form-label" v-text="$t('message.timeOfReceipt')"></label>
                                                            <input type="time" @change.prevent="changeStartTime($event.target.value)" v-model="cartSummaryData.startTime" class="form-control" :class="{'has-error-custom': errors.startTime}" id="start-time">
                                                        </div>
                                                        <span class="text-danger" style="font-size: 11px;" v-if="errors.startTime" v-text="errors.startTime[0]"></span>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="end-date" class="form-label" v-text="$t('message.determineTheDateOfDelivery')"></label>
                                                            <input type="date" @change.prevent="changeEndDate($event.target.value)" v-model="cartSummaryData.endDate" class="form-control" :class="{'has-error-custom': errors.endDate}" id="end-date">
                                                        </div>
                                                        <span class="text-danger" style="font-size: 11px;" v-if="errors.endDate" v-text="errors.endDate[0]"></span>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="end-time" class="form-label" v-text="$t('message.timeOfDelivery')"></label>
                                                            <input type="time" disabled v-model="cartSummaryData.endTime" class="form-control" :class="{'has-error-custom': errors.endTime}" id="end-time">
                                                        </div>
                                                        <span class="text-danger" style="font-size: 11px;" v-if="errors.endTime" v-text="errors.endTime[0]"></span>
                                                    </div>

<!--                                                    <div class="col-6">-->
<!--                                                        <div class="mb-2">-->
<!--                                                            <label for="end-time" class="form-label" v-text="$t('message.timeOfDelivery')"></label>-->
<!--                                                            <div class="div-as-input" dir="ltr">-->
<!--                                                                <p v-text="cartSummaryData.endTime"></p>-->
<!--                                                            </div>-->
<!--                                                        </div>-->
<!--                                                    </div>-->

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
                                                            <li>
                                                                <span v-text="$t('message.orderTotalDays')"></span>
                                                                <span class="float-end" v-text="days"></span>
                                                            </li>
                                                            <li><hr></li>
                                                            <li class="total">
                                                                <span class="title_" v-text="$t('message.orderTotal')"></span>
                                                                <span class="price_ float-end" v-text="$t('message.shoppingCartTotal', {total: store.state.cart.cartTotal})"></span>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" name="submit" class="btn btn-primary-color w-100" v-text="$t('message.completeCartOrder')"></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="booking_by_hours" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="data">
                                            <form @submit.prevent="store.dispatch('saveHourOrderSummaryDates')">
                                                <div class="row gx-2">
                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="start-date" class="form-label" v-text="$t('message.determineTheDateOfReceipt')"></label>
                                                            <input type="date" @change.prevent="changeHourlyStartDate($event.target.value)" v-model="cartHourlySummaryData.startDate" class="form-control" :class="{'has-error-custom': errors.startDate}" id="start-date">
                                                        </div>
                                                        <span class="text-danger" style="font-size: 11px;" v-if="errors.startDate" v-text="errors.startDate[0]"></span>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="start-time" class="form-label" v-text="$t('message.timeOfReceipt')"></label>
                                                            <select class="form-control" dir="ltr" :class="{'has-error-custom': errors.startTime}" v-model="cartHourlySummaryData.startTime" @change.prevent="changeHourlyStartTime($event.target.value)" id="start-time">
                                                                <template v-for="time in timesList" :key="time.key">
                                                                    <option :value="time.key" v-text="time.value"></option>
                                                                </template>
                                                            </select>
                                                        </div>
                                                        <span class="text-danger" style="font-size: 11px;" v-if="errors.startTime" v-text="errors.startTime[0]"></span>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="end-date" class="form-label" v-text="$t('message.determineTheDateOfDelivery')"></label>
                                                            <input type="date" @change.prevent="changeHourlyEndDate($event.target.value)" v-model="cartHourlySummaryData.endDate" class="form-control" :class="{'has-error-custom': errors.endDate}" id="end-date">
                                                        </div>
                                                        <span class="text-danger" style="font-size: 11px;" v-if="errors.endDate" v-text="errors.endDate[0]"></span>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="end-time" class="form-label" v-text="$t('message.timeOfDelivery')"></label>
                                                            <select class="form-control" dir="ltr" :class="{'has-error-custom': errors.endTime}" v-model="cartHourlySummaryData.endTime" @change.prevent="changeHourlyEndTime($event.target.value)" id="end-time">
                                                                <template v-for="time in timesList" :key="time.key">
                                                                    <option :value="time.key" v-text="time.value"></option>
                                                                </template>
                                                            </select>
                                                        </div>
                                                        <span class="text-danger" style="font-size: 11px;" v-if="errors.endTime" v-text="errors.endTime[0]"></span>
                                                    </div>

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
                                                            <li>
                                                                <span v-text="$t('message.orderTotalHours')"></span>
                                                                <span class="float-end" v-text="hours"></span>
                                                            </li>
                                                            <li><hr></li>
                                                            <li class="total">
                                                                <span class="title_" v-text="$t('message.orderTotal')"></span>
                                                                <span class="price_ float-end" v-text="$t('message.shoppingCartTotal', {total: store.state.cart.cartTotal})"></span>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" name="submit" class="btn btn-primary-color w-100" v-text="$t('message.completeCartOrder')"></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </app-layout>
    </div>
</template>

<style>
    .nav-tabs .nav-link{
        font-size: 16px;
        color: #8C9173;
    }
    .div-as-input{
        height: 32px;
        line-height: 32px;
        font-size: 12px;
        font-family: Tajawal-Regular, sans-serif;
        color: var(--basic-700-color);
        background-color: #e9ecef;
        opacity: 1;
        border: 1px solid #E4E9F2;
        border-radius: 5px;
        padding: 0px 10px;
    }
    .div-as-input p{
        font-size: 12px;
        color: #000;
    }
</style>
