<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import SingleOrderProduct from "@/components/front/includes/SingleOrderProduct";

import {useGetImage} from "@/composables/useHelper";
import {computed} from "vue";
import {useStore} from "vuex";
import {getCurrentStatus, getCurrentStatusClass} from "@/composables/useOrderStatus";
import {showAddAddress, showAllAddresses, convertDate, convertTime, getDeliveryTitle, getDeliveryType} from "@/composables/useOrderAddress";
import User from '@/libs/User';
import moment from "moment";

const props = defineProps(['order_no']);

const store = useStore();
let auth = User.auth();

store.dispatch('getAddressById', auth.address_id);
store.dispatch('getOrderById', props.order_no);
store.dispatch('getAllAddresses');
store.dispatch('getAllCities');

let order = computed(() => store.state.order.singleOrder);
let addresses = computed(() => store.state.address.addresses);
let addressData = computed(() => store.state.address.addressData);
let addressDefaultData = computed(() => store.state.address.addressDefaultData);
let orderAddressData = computed(() => store.state.address.orderAddressData);
let orderSummaryDatesData = computed(() => store.state.order.orderSummaryDatesData);
let address = computed(() => store.state.address.address);
let errors = computed(() => store.state.errors);
let payErrors = computed(() => store.state.payment.errors);
let cities = computed(() => store.state.getAllCities);
let paymentData = computed(() => store.state.payment.paymentData);
let delayPenaltyData = computed(() => store.state.payment.delayPenaltyData);
let payDepositFirstly = computed(() => store.state.payment.payDepositFirstly);
let payInsuranceData = computed(() => store.state.payment.payInsuranceData);

</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item">
                <router-link :to="{name: 'orders'}" v-text="$t('message.myOrders')"></router-link>
            </li>
            <li class="breadcrumb-item active">
                <router-link :to="$route.name" v-text="$t('message.orderNo', {id: order.order_no})"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content" class="cart-fill complete-order my-orders-details">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9">
                        <!-- order info -->
                        <div id="order-info" class="order-info">
                            <div class="row gy-2 justify-content-center justify-content-md-start align-items-center mb-3">
<!--                                <div class="col-auto"><h6 v-text="$t('message.chooseHowToGetTheProduct')"></h6></div>-->
<!--                                <div class="col-auto"><div class="deliver-way-display" v-text="getDeliveryType(order.delivery_type)"></div></div>-->
                                <div class="col-auto" v-if="order.order_status === 'pending'">
                                    <a href="javascript:void(0);" @click="store.commit('setOrderAddressDeliveryType', order)" data-bs-toggle="modal" data-bs-target="#editDeliverWayModal" class="edit-link">
                                        <i class="fa-solid fa-pen me-1"></i><span class="edit-deliver-way" v-text="$t('message.edit')"></span>
                                    </a>
                                </div>
                            </div>

                            <h6 class="mb-2" v-text="getDeliveryTitle(order.delivery_type)"></h6>

                            <template v-if="order.delivery_type === 'location'" v-for="userOrderAddress in order.addresses">
                                <div class="address-info mb-3">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <div class="ms-3">
                                        <span v-text="userOrderAddress.address"></span>
                                        <div class="d-flex align-items-baseline mt-2">
                                            <span class="phone-title" v-text="$t('message.mobile')"></span>
                                            <span class="phone-value" v-text="userOrderAddress.phone"></span>
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template v-if="order.delivery_type === 'address' && order.address">
                                <div class="address-info mb-3">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <div class="ms-3">
                                        <span v-text="order.address.address"></span>
                                        <div class="d-flex align-items-baseline mt-2">
                                            <span class="phone-title" v-text="$t('message.mobile')"></span>
                                            <span class="phone-value" v-text="order.address.phone"></span>
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <h6 class="mb-2" v-text="$t('message.orderPaymentStatus')"></h6>
                            <span v-text="$t('message.' + order.payment_status)"></span>

                            <h6 class="mt-3 mb-2" v-text="$t('message.orderStatus')"></h6>
                            <div class="row align-items-center gx-5 gy-2 mb-3">
                                <div class="col-auto" v-if="order.summary !== undefined && order.summary.delay_penalty > 0">
                                    <div class="order-status">
                                        <i class="fa-solid fa-circle me-2 custom-gold-color"></i>{{$t('message.lateDelivery')}}
                                        <span class="ms-3 font-size-12 custom-gray-color">{{$t('message.delayDays')}}&nbsp;
                                            <span class="custom-red-color">{{ order.summary.delayed_days }} {{ $t('message.day') }}</span>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-auto" v-if="order.summary !== undefined && order.summary.delay_penalty === 0">
                                    <div class="order-status">
                                        <i class="fa-solid fa-circle me-2" :class="getCurrentStatusClass(order.order_status)"></i>
                                        <span style="padding: 5px;margin-top: 5px;" v-text="getCurrentStatus(order.order_status)"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row gy-2 justify-content-center justify-content-md-start align-items-center buttons-div">
                                <div class="col-auto" v-if="order.order_status !== 'pending'">
                                    <a :href="order.invoice_url" target="_blank" class="btn btn-primary-color" v-text="$t('message.showInvoice')"></a>
                                </div>

                                <div class="col-auto" v-if="order.order_status === 'pending'">
                                    <a href="javascript:void(0);" @click.prevent="store.dispatch('cancelUserOrder', order.id)" class="btn btn-danger2">
                                        <i class="fa fa-times me-2"></i>
                                        <div class="cancel-order-button" v-text="$t('message.cancelOrder')"></div>
                                    </a>
                                </div>

                                <div class="col-auto" v-if="order.order_status === 'delivered'">
                                    <a href="#" class="btn btn-outline-secondary-color" v-text="$t('message.refundRequest')"></a>
                                </div>
                            </div>
                        </div>

                        <!-- payment way -->
                        <div id="payment-way" class="payment-way" v-if="order.order_status === 'accepted'">
                            <h6 class="title" v-text="$t('message.choosePaymentWay')"></h6>
                            <div id="payment-way-options" class="payment-way-options">
<!--                                <div class="form-check form-check-inline checked">-->
<!--                                    <input class="form-check-input" type="radio" v-model="paymentData.payment_method" name="payment_way" id="cash" value="cash" checked>-->
<!--                                    <label class="form-check-label" for="cash">-->
<!--                                        <img class="img-fluid" :src="useGetImage('front/assets/images/icons/cash.png')" alt="cash icon">-->
<!--                                        {{ $t('message.payCashOnDelivery') }}-->
<!--                                    </label>-->
<!--                                </div>-->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="paymentData.payment_method" name="payment_way" id="wallet" value="wallet">
                                    <label class="form-check-label" for="wallet">
                                        <img class="img-fluid" width="26" height="26" :src="useGetImage('front/assets/images/icons/wallet.svg')" alt="wallet icon">
                                        {{ $t('message.payByWallet') }}
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" @click="store.state.errors = {}; store.state.payment.errors = {};" type="radio" v-model="paymentData.payment_method" name="payment_way" id="visa" value="visa">
                                    <label class="form-check-label" for="visa">
                                        <img class="img-fluid" :src="useGetImage('front/assets/images/icons/visa.png')" alt="visa icon">
                                        {{ $t('message.payByVisa') }}
                                    </label>
                                </div>
                            </div>

                            <!-- cash pay way -->
                            <div id="cash-pay-way" class="cash-pay-way">
                                <div class="form-check" v-if="parseInt(order.summary.total_insurance) > 0">
                                    <input class="form-check-input me-2" @click="store.commit('setPayDepositFirstly')" type="checkbox" value="" id="pay-deposit-firstly">
                                    <label class="form-check-label" for="pay-deposit-firstly" v-text="$t('message.payInsuranceFirst')"></label>
                                </div>

                                <form v-if="parseInt(order.summary.total_insurance) > 0" @submit.prevent="store.dispatch('setUserPayInsurance', order.id)">
                                    <div class="row">
                                        <div class="col-md-12" v-show="payDepositFirstly">
                                            <div class="mb-3">
                                                <label for="visa-card-number" class="form-label" v-text="$t('message.cardNumber')"></label>
                                                <input type="text" maxlength="16" v-model="payInsuranceData.card_numbers" :class="{'has-error-custom': payErrors.card_numbers}" class="form-control" id="visa-card-number" placeholder="**** **** **** *** VISA">
                                                <span class="text-danger" v-if="payErrors.card_numbers" v-text="payErrors.card_numbers[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12" v-show="payDepositFirstly">
                                            <div class="mb-3">
                                                <label for="card-holder" class="form-label" v-text="$t('message.cardHolder')"></label>
                                                <input type="text" dir="ltr" v-model="payInsuranceData.card_holder" :class="{'has-error-custom': payErrors.card_holder}" class="form-control" id="card-holder" :placeholder="$t('message.enterVar', {var: $t('message.cardHolder')})">
                                                <span class="text-danger" v-if="payErrors.card_holder" v-text="payErrors.card_holder[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6" v-show="payDepositFirstly">
                                            <div class="mb-3">
                                                <label for="visa-expiration-date" class="form-label" v-text="$t('message.cardDate')"></label>
                                                <input type="month" v-model="payInsuranceData.card_date" :class="{'has-error-custom': payErrors.card_date}" class="form-control" id="visa-expiration-date">
                                                <span class="text-danger" v-if="payErrors.card_date" v-text="payErrors.card_date[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6" v-show="payDepositFirstly">
                                            <div class="mb-3">
                                                <label for="visa-cvv" class="form-label" v-text="$t('message.cardCvv')"></label>
                                                <input type="number" min="0" v-model="payInsuranceData.card_cvv" :class="{'has-error-custom': payErrors.card_cvv}" class="form-control" id="visa-cvv" :placeholder="$t('message.cardCvv')">
                                                <span class="text-danger" v-if="payErrors.card_cvv" v-text="payErrors.card_cvv[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" disabled class="btn btn-primary-color" v-text="$t('message.payInsuranceValue')"></button>
                                        </div>
                                    </div>
                                </form>

                                <button v-else class="btn btn-primary-color" @click.prevent="store.dispatch('setUserOrderPayCash', order.id)" v-text="$t('message.completePayment')"></button>
                            </div>

                            <!-- wallet pay way -->
                            <div id="wallet-pay-way" class="wallet-pay-way d-none">
                                <div class="mb-3">
                                    <span v-text="$t('message.walletBalance')"></span>
                                    <span class="balance-value" v-text="User.auth().wallet_balance"></span>
                                    <span v-text="order.summary.currency"></span>
                                </div>

                                <button @click.prevent="store.dispatch('setUserOrderPayByWallet', order.id)" :disabled="parseInt(order.summary.total) > parseInt(User.auth().wallet_balance)" class="btn btn-primary-color" v-text="$t('message.completePayment')"></button>

                                <div class="mt-2" v-if="parseInt(order.summary.total) > parseInt(User.auth().wallet_balance)">
                                    <span class="custom-red-color" v-text="$t('message.noEnoughBalance')"></span>
                                </div>
                            </div>

                            <!-- visa pay way -->
                            <div id="visa-pay-way" class="visa-pay-way d-none">
                                <form @submit.prevent="store.dispatch('setUserOrderPay', order.id)">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="visa-card-number" class="form-label" v-text="$t('message.cardNumber')"></label>
                                                <input type="text" dir="ltr" maxlength="16" v-model="paymentData.card_numbers" :class="{'has-error-custom': errors.card_numbers}" class="form-control" id="visa-card-number" placeholder="**** **** **** *** VISA">
                                                <span class="text-danger" v-if="errors.card_numbers" v-text="errors.card_numbers[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="card-holder" class="form-label" v-text="$t('message.cardHolder')"></label>
                                                <input type="text" dir="ltr" v-model="paymentData.card_holder" :class="{'has-error-custom': errors.card_holder}" class="form-control" id="card-holder" :placeholder="$t('message.enterVar', {var: $t('message.cardHolder')})">
                                                <span class="text-danger" v-if="errors.card_holder" v-text="errors.card_holder[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="visa-expiration-date" class="form-label" v-text="$t('message.cardDate')"></label>
                                                <input type="month" v-model="paymentData.card_date" :class="{'has-error-custom': errors.card_date}" class="form-control" id="visa-expiration-date">
                                                <span class="text-danger" v-if="errors.card_date" v-text="errors.card_date[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="visa-cvv" class="form-label" v-text="$t('message.cardCvv')"></label>
                                                <input type="number" min="0" v-model="paymentData.card_cvv" :class="{'has-error-custom': errors.card_cvv}" class="form-control" id="visa-cvv" :placeholder="$t('message.cardCvv')">
                                                <span class="text-danger" v-if="errors.card_cvv" v-text="errors.card_cvv[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary-color" v-text="$t('message.completePayment')"></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- delay payment way -->
                        <div id="payment-way" class="payment-way" v-if="order.summary !== undefined && order.summary.delay_penalty > 0 && (order.summary.is_delay_paid === null || order.summary.is_delay_paid === 0)">
                            <h6 class="title" v-text="$t('message.chooseDelayPaymentWay')"></h6>
                            <div id="payment-way-options" class="payment-way-options">
<!--                                <div class="form-check form-check-inline checked">-->
<!--                                    <input class="form-check-input" type="radio" v-model="delayPenaltyData.payment_method" name="delay_payment_way" id="cash" value="cash" checked>-->
<!--                                    <label class="form-check-label" for="cash">-->
<!--                                        <img class="img-fluid" :src="useGetImage('front/assets/images/icons/cash.png')" alt="cash icon">-->
<!--                                        {{ $t('message.payCash') }}-->
<!--                                    </label>-->
<!--                                </div>-->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="delayPenaltyData.payment_method" name="delay_payment_way" id="wallet" value="wallet">
                                    <label class="form-check-label" for="wallet">
                                        <img class="img-fluid" width="26" height="26" :src="useGetImage('front/assets/images/icons/wallet.svg')" alt="wallet icon">
                                        {{ $t('message.payByWallet') }}
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" @click="store.state.errors = {}; store.state.payment.errors = {};" type="radio" v-model="delayPenaltyData.payment_method" name="delay_payment_way" id="visa" value="visa">
                                    <label class="form-check-label" for="visa">
                                        <img class="img-fluid" :src="useGetImage('front/assets/images/icons/visa.png')" alt="visa icon">
                                        {{ $t('message.payByVisa') }}
                                    </label>
                                </div>
                            </div>

                            <!-- cash pay way -->
                            <div id="cash-pay-way" class="cash-pay-way">
                                <button class="btn btn-primary-color" @click.prevent="store.dispatch('setUserDelayPayCash', order.id)" v-text="$t('message.completePayment')"></button>
                            </div>

                            <!-- wallet pay way -->
                            <div id="wallet-pay-way" class="wallet-pay-way d-none">
                                <div class="mb-3">
                                    <span v-text="$t('message.walletBalance')"></span>
                                    <span class="balance-value" v-text="User.auth().wallet_balance"></span>
                                    <span v-text="order.summary.currency"></span>
                                </div>

                                <button @click.prevent="store.dispatch('setUserDelayPayByWallet', order.id)" :disabled="parseInt(order.summary !== undefined ? order.summary.delay_penalty : '0') > parseInt(User.auth().wallet_balance)" class="btn btn-primary-color" v-text="$t('message.completePayment')"></button>

                                <div class="mt-2" v-if="parseInt(order.summary.delay_penalty) > parseInt(User.auth().wallet_balance)">
                                    <span class="custom-red-color" v-text="$t('message.noEnoughBalanceForDelay')"></span>
                                </div>
                            </div>

                            <!-- visa pay way -->
                            <div id="visa-pay-way" class="visa-pay-way d-none">
                                <form @submit.prevent="store.dispatch('setUserDelayPay', order.id)">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="visa-card-number" class="form-label" v-text="$t('message.cardNumber')"></label>
                                                <input type="text" dir="ltr" maxlength="16" v-model="delayPenaltyData.card_numbers" :class="{'has-error-custom': errors.card_numbers}" class="form-control" id="visa-card-number" placeholder="**** **** **** *** VISA">
                                                <span class="text-danger" v-if="errors.card_numbers" v-text="errors.card_numbers[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="card-holder" class="form-label" v-text="$t('message.cardHolder')"></label>
                                                <input type="text" dir="ltr" v-model="delayPenaltyData.card_holder" :class="{'has-error-custom': errors.card_holder}" class="form-control" id="card-holder" :placeholder="$t('message.enterVar', {var: $t('message.cardHolder')})">
                                                <span class="text-danger" v-if="errors.card_holder" v-text="errors.card_holder[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="visa-expiration-date" class="form-label" v-text="$t('message.cardDate')"></label>
                                                <input type="month" v-model="delayPenaltyData.card_date" :class="{'has-error-custom': errors.card_date}" class="form-control" id="visa-expiration-date">
                                                <span class="text-danger" v-if="errors.card_date" v-text="errors.card_date[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="visa-cvv" class="form-label" v-text="$t('message.cardCvv')"></label>
                                                <input type="number" min="0" v-model="delayPenaltyData.card_cvv" :class="{'has-error-custom': errors.card_cvv}" class="form-control" id="visa-cvv" :placeholder="$t('message.cardCvv')">
                                                <span class="text-danger" v-if="errors.card_cvv" v-text="errors.card_cvv[0]"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary-color" v-text="$t('message.completePayment')"></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- your cart products -->
                        <div class="cart-products">
                            <div class="row justify-content-between align-items-center cart-products-title mb-3">
                                <div class="col-auto">
                                    <h1 v-text="$t('message.orderProducts')"></h1>
                                </div>
                            </div>

                            <single-order-product v-for="product in order.products" :product="product" />
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="order-summary" v-if="order.summary">
                            <h1 class="title" v-text="$t('message.orderInfo')"></h1>
                            <div class="data">
                                <ul class="list-unstyled">
                                    <li>
                                        <span v-text="$t('message.orderNumber')"></span>
                                        <span class="float-end">{{ order.order_no }}#</span>
                                    </li>
                                    <li>
                                        <span v-text="$t('message.orderCreated')"></span>
                                        <span class="float-end" v-if="order.summary" v-text="convertDate(order.summary.created_at)"></span>
                                    </li>

                                    <!-- with edit link -->
                                    <li v-if="order.order_status === 'pending'">
                                        <div class="dates-with-edit-link">
                                            <div class="row g-1 justify-content-between align-items-center">
                                                <div class="col-auto"><span v-text="$t('message.receiptDateAndTime')"></span></div>
                                                <div class="col-auto">
                                                    <div class="custom-dir-ltr" v-if="order.summary">{{ convertDate(order.summary.start_date) }} | {{ convertTime(order.summary.start_time) }}</div>
                                                </div>
                                            </div>
                                            <div class="row g-1 justify-content-between align-items-center">
                                                <div class="col-auto">
                                                    <span v-text="$t('message.deliveryDateAndTime')"></span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="custom-dir-ltr" v-if="order.summary">{{ convertDate(order.summary.end_date) }} | {{ convertTime(order.summary.end_time) }}</div>
                                                </div>
                                            </div>
                                            <div class="row g-1 justify-content-between align-items-center">
                                                <div class="col-12">
                                                    <a href="javascript:void(0);" @click="store.commit('setOrderSummaryDates', order)" data-bs-toggle="modal" data-bs-target="#editDatesModal" class="edit-link float-edit-end">
                                                        <i class="fa-solid fa-pen me-1"></i><span class="edit-order-dates" v-text="$t('message.edit')"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- without edit link -->
                                    <template v-else>
                                        <li>
                                            <span v-text="$t('message.receiptDateAndTime')"></span>
                                            <span class="float-end custom-dir-ltr" v-if="order.summary">{{ order.summary.start_date }} | {{ moment(order.summary.start_time).format('h:mm A') }}</span>
                                        </li>
                                        <li>
                                            <span v-text="$t('message.deliveryDateAndTime')"></span>
                                            <span class="float-end custom-dir-ltr" v-if="order.summary">{{ order.summary.end_date }} | {{ moment(order.summary.end_time).format('h:mm A') }}</span>
                                        </li>
                                    </template>

                                    <li v-if="order.summary.coupon">
                                        <span v-text="$t('message.coupon')"></span>
                                        <span class="float-end" v-text="order.summary.coupon"></span>
                                    </li>

                                    <li>
                                        <span v-text="$t('message.orderPaymentMethod')"></span>
                                        <span class="float-end" v-if="order.summary.payment_method" v-text="$t('message.' + order.summary.payment_method)"></span>
                                        <span class="float-end" v-else v-text="$t('message.notSet')"></span>
                                    </li>
                                    <li>
                                        <span v-text="$t('message.orderTotalTax')"></span>
                                        <span class="float-end" v-text="$t('message.shoppingCartTotal', {total: order.summary.tax})"></span>
                                    </li>
                                    <li>
                                        <span v-text="$t('message.orderCost')"></span>
                                        <span class="float-end" v-text="$t('message.shoppingCartTotal', {total: order.summary.total})"></span>
                                    </li>
                                    <li v-if="parseInt(order.summary.discount) > 0">
                                        <span class="custom-dark-purple-color" v-text="$t('message.discountValue')"></span>
                                        <span class="float-end custom-red-color">{{ order.summary.discount }}- {{ order.summary.currency }}</span>
                                    </li>
                                    <li v-if="parseInt(order.summary.total_insurance) > 0">
                                        <span v-text="$t('message.orderTotalInsurance')"></span>
                                        <span class="float-end">{{ order.summary.total_insurance}} {{ order.summary.currency }}</span>
                                    </li>
                                    <li v-if="order.summary.delay_penalty > 0">
                                        <span v-text="$t('message.orderDelayPenalty')"></span>
                                        <span class="float-end custom-red-color">{{ order.summary.delay_penalty }} {{ order.summary.currency }}</span>
                                    </li>
                                    <li v-if="order.summary.type === 'day'">
                                        <span v-text="$t('message.orderTotalDays')"></span>
                                        <span class="float-end" v-text="order.summary.days"></span>
                                    </li>
                                    <li v-else>
                                        <span v-text="$t('message.orderTotalHours')"></span>
                                        <span class="float-end" v-text="order.summary.hours"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- editDatesModal -->
            <div class="modal fade" id="editDatesModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-text="$t('message.editOrderDateAndTime')"></h5>
                            <button type="button" class="btn btn-close2" data-bs-dismiss="modal">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="store.dispatch('changeUserOrderDates', order.order_no)">
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 edit-dates">
                                    <div class="col">
                                        <div class="mb-2">
                                            <label for="start-date" class="form-label" v-text="$t('message.changeTheDateOfReceipt')"></label>
                                            <input type="date" :class="{'has-error-custom': errors.startDate}" v-model="orderSummaryDatesData.startDate" class="form-control" id="start-date">
                                            <span class="text-danger" v-if="errors.startDate" v-text="errors.startDate[0]"></span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-2">
                                            <label for="start-time" class="form-label" v-text="$t('message.changeTimeOfReceipt')"></label>
                                            <input type="time" :class="{'has-error-custom': errors.startTime}" v-model="orderSummaryDatesData.startTime" class="form-control" id="start-time">
                                            <span class="text-danger" v-if="errors.startTime" v-text="errors.startTime[0]"></span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-2">
                                            <label for="end-date" class="form-label" v-text="$t('message.changeTheDateOfDelivery')"></label>
                                            <input type="date" :class="{'has-error-custom': errors.endDate}" v-model="orderSummaryDatesData.endDate" class="form-control" id="end-date">
                                            <span class="text-danger" v-if="errors.endDate" v-text="errors.endDate[0]"></span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-2">
                                            <label for="end-time" class="form-label" v-text="$t('message.changeTimeOfDelivery')"></label>
                                            <input type="time" :class="{'has-error-custom': errors.endTime}" v-model="orderSummaryDatesData.endTime" class="form-control" id="end-time">
                                            <span class="text-danger" v-if="errors.endTime" v-text="errors.endTime[0]"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-end mt-3 action-buttons">
                                    <div class="col-auto">
                                        <a href="javascript:void(0);" data-bs-dismiss="modal" class="cancel-link me-4" v-text="$t('message.cancel')"></a>
                                        <button type="submit" class="btn btn-primary-color" v-text="$t('message.saveAndEdit')"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of editDatesModal -->

            <!-- editDeliverWayModal -->
            <div class="modal fade" id="editDeliverWayModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-text="$t('message.editTheWayToGetProduct')"></h5>
                            <button type="button" class="btn btn-close2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <div class="modal-body">
                            <!-- deliver way -->
                            <div id="deliver-way" class="deliver-way text-center text-sm-start">
<!--                                <div id="deliver-way-options" class="deliver-way-options">-->
<!--                                    <div class="form-check form-check-inline checked">-->
<!--                                        <input class="form-check-input" type="radio" @click="changeFromLocation($event.target.value, order)" name="delivery_type" id="from_location" value="location" :checked="order.delivery_type === 'location'">-->
<!--                                        <label class="form-check-label" for="from_location" v-text="$t('message.receiptFromLocation')"></label>-->
<!--                                    </div>-->
<!--                                    <div class="form-check form-check-inline">-->
<!--                                        <input class="form-check-input" type="radio" @click="changeFromLocation($event.target.value, order)" name="delivery_type" id="deliver" value="address" :checked="order.delivery_type === 'address'">-->
<!--                                        <label class="form-check-label" for="deliver" v-text="$t('message.delivery')"></label>-->
<!--                                    </div>-->
<!--                                </div>-->

                                <!-- from location -->
                                <div id="from-location-div" class="text-start" :class="{'d-none': order.delivery_type !== 'location'}">
                                    <div class="address-title" v-text="$t('message.addressMessage')"></div>
                                    <template v-for="orderAddress in order.addresses">
                                        <div class="address-info">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <div class="ms-3">
                                                <span v-text="orderAddress.address"></span>
                                                <div class="d-flex align-items-baseline mt-2">
                                                    <span class="phone-title" v-text="$t('message.mobile')"></span>
                                                    <span class="phone-value" v-text="orderAddress.phone"></span>
                                                    <i class="fa-solid fa-circle-check"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

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

                                <!-- add address -->
                                <div id="add-address-div" class="d-none">
                                    <form @submit.prevent="store.dispatch('addNewAddress',true)">
                                        <div class="row justify-content-between align-items-center mb-3">
                                            <div class="col-auto">
                                                <h6 v-text="$t('message.addNewAddress')"></h6>
                                            </div>
                                            <div class="col-auto">
                                                <a href="javascript:void(0);" @click="store.state.errors = {};" class="address-cancel" v-text="$t('message.cancel')"></a>
                                                <button type="submit" class="btn btn-primary-color" v-text="$t('message.add')"></button>
                                            </div>
                                        </div>

                                        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 text-start">
                                            <div class="col">
                                                <div class="mb-2">
                                                    <label for="address-recipient-name" class="form-label" v-text="$t('message.recipientName')"></label>
                                                    <input type="text" :class="{'has-error-custom': errors.recipient_name}" v-model="addressDefaultData.recipient_name" class="form-control" id="address-recipient-name" :placeholder="$t('message.enterVar', {var: $t('message.recipientName')})">
                                                </div>
                                                <span class="text-danger" v-if="errors.recipient_name" v-text="errors.recipient_name[0]"></span>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">
                                                    <label for="address-mobile" class="form-label" v-text="$t('message.phone')"></label>
                                                    <input type="number" min="0" :class="{'has-error-custom': errors.phone}" v-model="addressDefaultData.phone" class="form-control" id="address-mobile" :placeholder="$t('message.enterVar', {var: $t('message.phone')})">
                                                </div>
                                                <span class="text-danger" v-if="errors.phone" v-text="errors.phone[0]"></span>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">
                                                    <label for="address-city" class="form-label" v-text="$t('message.city')"></label>
                                                    <select :class="{'has-error-custom': errors.city_id}" class="form-select" v-model="addressDefaultData.city_id" id="address-city">
                                                        <option value="" v-text="$t('message.chooseACity')"></option>
                                                        <option v-for="(city, index) in store.state.getAllCities" :value="city.id" :key="index" v-text="city.text"></option>
                                                    </select>
                                                </div>
                                                <span class="text-danger" v-if="errors.city_id" v-text="errors.city_id[0]"></span>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">
                                                    <label for="address-street-name" class="form-label" v-text="$t('message.streetName')"></label>
                                                    <input type="text" :class="{'has-error-custom': errors.street}" class="form-control" v-model="addressDefaultData.street" id="address-street-name" :placeholder="$t('message.enterVar', {var: $t('message.streetName')})">
                                                </div>
                                                <span class="text-danger" v-if="errors.street" v-text="errors.street[0]"></span>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">
                                                    <label for="address-trademark" class="form-label" v-text="$t('message.specialMarque')"></label>
                                                    <input type="text" :class="{'has-error-custom': errors.special_marque}" class="form-control" v-model="addressDefaultData.special_marque" id="address-trademark" :placeholder="$t('message.enterVar', {var: $t('message.specialMarque')})">
                                                </div>
                                                <span class="text-danger" v-if="errors.special_marque" v-text="errors.special_marque[0]"></span>
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

                                <!-- show addresses -->
                                <div id="show-addresses-div" :class="{'d-none': order.delivery_type !== 'address'}">
                                    <div class="row justify-content-between align-items-center mb-3">
                                        <div class="col-auto">
                                            <h6 v-text="$t('message.selectDeliverAddress')"></h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="javascript:void(0);" @click="showAddAddress" class="add-new-address">
                                                <i class="fa-solid fa-circle-plus"></i>{{ $t('message.addNewAddress') }}
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row gy-3 row-cols-1 row-cols-lg-2">
                                        <div class="col" v-for="(userAddress, index) in addresses" :key="index" :id="'address-id-'+userAddress.id">
                                            <div class="address-item">
                                                <div class="row justify-content-between align-items-center address-item-title">
                                                    <div class="col-auto">
                                                        <div class="form-check" style="position: relative;">
                                                            <input class="form-check-input" type="radio" @click="store.dispatch('setOrderAddress', userAddress.id)" name="address_id" :value="userAddress.id" :id="'address-'+userAddress.id">
                                                            <span :id="'custom-check-icon-js-' + userAddress.id"></span>
                                                            <label class="form-check-label" :for="'address-' + userAddress.id">
                                                                <i class="fa-solid fa-location-dot me-2"></i> {{$t('message.addressNo', {num: index+1})}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
<!--                                                        <a href="javascript:void(0);" @click.prevent="showEditAddress(userAddress)" class="address-actions edit-address">-->
<!--                                                            <i class="fa-solid fa-pen"></i>-->
<!--                                                        </a>-->
                                                        <a href="javascript:void(0);" @click.prevent="store.dispatch('deleteUserAddress', userAddress.id)" class="address-actions remove-address">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="row gy-3 align-items-center address-item-body">
                                                    <div class="col-3"><span class="title" v-text="$t('message.address')"></span></div>
                                                    <div class="col-9"><span class="value" v-text="userAddress.full_address"></span></div>
                                                    <div class="col-3"><span class="title" v-text="$t('message.phone')"></span></div>
                                                    <div class="col-9">
                                                        <span class="value" v-text="userAddress.phone"></span>
                                                        <i class="fa-solid fa-circle-check ms-3"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- the form -->
                            <form>
                                <div class="row justify-content-end mt-3 action-buttons">
                                    <div class="col-auto">
                                        <a href="javascript:void(0);" data-bs-dismiss="modal" class="cancel-link me-4" v-text="$t('message.cancel')"></a>
                                        <button type="button" @click.prevent="store.dispatch('changeUserOrderAddress')" class="bn btn-primary-color" v-text="$t('message.saveAndEdit')"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of editDeliverWayModal -->
        </section>
    </app-layout>
</template>
