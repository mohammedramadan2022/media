<script setup>
import ProfileSideMenu from "@/components/front/includes/ProfileSideMenu";
import AppLayout from "@/components/front/layout/AppLayout";
import {useGetImage, getWalletClass} from "@/composables/useHelper";
import {computed} from "vue";
import {useStore} from "vuex";
import {useRoute} from "vue-router";

const store = useStore();
const route = useRoute();

store.dispatch('getUserWallet');

let wallet = computed(() => store.state.wallet.getWallet);
let chargeWalletData = computed(() => store.state.wallet.chargeWalletData);
let errors = computed(() => store.state.errors);
let message = '';

if(route.query.status) {
    message = route.query.message;
}
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'wallet'}" v-text="$t('message.myWallet')"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content" class="my-account my-wallet">
            <div class="container">
                <div class="row gy-3 gy-lg-0">
                    <!-- menu -->
                    <div class="col-lg-3"><profile-side-menu/></div>
                    <!-- data -->
                    <div class="col-lg-9">
                        <div v-if="route.query.status && route.query.status === 'failed'" class="alert alert-warning text-center" v-text="route.query.message"></div>
                        <div v-if="route.query.status && route.query.status === 'paid'" class="alert alert-success text-center" v-text="route.query.message"></div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="my-wallet-item balance-display">
                                    <h6 v-text="$t('message.myWallet')"></h6>
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <img class="img-fluid" :src="useGetImage('front/assets/images/icons/wallet.svg')" alt="wallet logo">
                                        </div>
                                        <div class="col-auto">
                                            <sup v-text="$t('message.myBalance')"></sup>
                                            <span v-text="wallet.balance"></span>
                                            <sub v-text="wallet.currency"></sub>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="my-wallet-item balance-charge">
                                    <h6 v-text="$t('message.walletCharge')"></h6>
                                    <div class="row">
                                        <div class="col-12">
                                            <form @submit.prevent="store.dispatch('chargeWallet')">
                                                <div class="mb-2">
                                                    <label for="charge-amount" class="form-label" v-text="$t('message.enterChargeAmount')"></label>
                                                    <input type="number" min="1" dir="ltr" :class="{'has-error-custom': errors.amount}" v-model="chargeWalletData.amount" class="form-control" id="charge-amount" :placeholder="$t('message.enterVar', {var: $t('message.enterChargeAmount')})">
                                                    <span class="text-danger" v-if="errors.amount" v-text="errors.amount[0]"></span>
                                                </div>

                                                <div class="mb-2">
                                                    <label for="visa-card-number" class="form-label" v-text="$t('message.cardNumber')"></label>
                                                    <input type="text" maxlength="16" dir="ltr" v-model="chargeWalletData.card_numbers" :class="{'has-error-custom': errors.card_numbers}" class="form-control" id="visa-card-number" placeholder="**** **** **** *** VISA">
                                                    <span class="text-danger" v-if="errors.card_numbers" v-text="errors.card_numbers[0]"></span>
                                                </div>

                                                <div class="mb-2">
                                                    <label for="card-holder" class="form-label" v-text="$t('message.cardHolder')"></label>
                                                    <input type="text" dir="ltr" v-model="chargeWalletData.card_holder" :class="{'has-error-custom': errors.card_holder}" class="form-control" id="card-holder" :placeholder="$t('message.enterVar', {var: $t('message.cardHolder')})">
                                                    <span class="text-danger" v-if="errors.card_holder" v-text="errors.card_holder[0]"></span>
                                                </div>

                                                <div class="mb-2">
                                                    <label for="visa-expiration-date" class="form-label" v-text="$t('message.cardDate')"></label>
                                                    <input type="month" v-model="chargeWalletData.card_date" :class="{'has-error-custom': errors.card_date}" class="form-control" id="visa-expiration-date">
                                                    <span class="text-danger" v-if="errors.card_date" v-text="errors.card_date[0]"></span>
                                                </div>

                                                <div class="mb-2">
                                                    <label for="visa-cvv" class="form-label" v-text="$t('message.cardCvv')"></label>
                                                    <input type="number" min="0" dir="ltr" v-model="chargeWalletData.card_cvv" :class="{'has-error-custom': errors.card_cvv}" class="form-control" id="visa-cvv" :placeholder="$t('message.cardCvv')">
                                                    <span class="text-danger" v-if="errors.card_cvv" v-text="errors.card_cvv[0]"></span>
                                                </div>

                                                <button type="submit" class="btn btn-primary-color" v-text="$t('message.chargeWaller')"></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="my-wallet-item balance-transactions">
                                    <h6 v-text="$t('message.transactionsList')"></h6>

                                    <template v-for="transaction in wallet.transactions">
                                        <div class="row text-center text-md-start justify-content-md-between align-items-center">
                                            <div class="col-md-auto">
                                                <i class="fa-solid fa-arrow-up" :class="getWalletClass(transaction.type)"></i>
                                                <span class="ms-2" v-text="transaction.message"></span>
                                            </div>
                                            <div class="col-md-auto">
                                                <span v-text="transaction.created_at"></span>
                                            </div>
                                        </div>
                                    </template>

                                    <template v-if="wallet.transactions.length === 0">
                                        <div class="alert alert-info text-center">
                                             {{ $t('message.noVar', {var: $t('message.aTransactions')}) }}
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </app-layout>
</template>
