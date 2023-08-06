<script setup>
import {useStore} from "vuex";
import {computed} from "vue";
import Select2 from "vue3-select2-component";

const store = useStore();

store.dispatch('getAllCities');

let fetchFooter = computed(() => store.state.footerData);
let joinRentalRequestData = computed(() => store.state.joinRentalRequestData);
let cities = computed(() => store.state.getAllCities);
let errors = computed(() => store.state.errors);
</script>

<template>
    <!-- registerModal -->
    <div class="modal fade" id="joinRentalBusinessModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-close2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <router-link :to="{name: 'home'}"><img class="img-fluid" :src="fetchFooter.logo" alt="logo"></router-link>

                    <h1 v-text="$t('message.joinRental')"></h1>

                    <div class="alert alert-success" v-text="store.state.responseMessage" v-show="store.state.responseMessage !== ''" role="alert"></div>

                    <form @submit.prevent="store.dispatch('setUserJoinRequest')">
                        <div class="row align-items-center">
                            <!-- name -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" v-text="$t('message.name')"></label>
                                    <div class="input-group" :class="{'has-error-custom': errors.name}">
                                        <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                                        <input type="text" v-model="joinRentalRequestData.name" class="form-control" :placeholder="$t('message.name')">
                                    </div>
                                    <span class="text-danger" v-if="errors.name" v-text="errors.name[0]"></span>
                                </div>
                            </div>

                            <!-- id number -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" v-text="$t('message.identityNumber')"></label>
                                    <div class="input-group" :class="{'has-error-custom': errors.identity}">
                                        <span class="input-group-text"><i class="fa-solid fa-fingerprint"></i></span>
                                        <input type="text" maxlength="10" v-model="joinRentalRequestData.identity" class="form-control" :placeholder="$t('message.identityNumber')">
                                    </div>
                                    <span class="text-danger" v-if="errors.identity" v-text="errors.identity[0]"></span>
                                </div>
                            </div>

                            <!-- store name -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" v-text="$t('message.storeName')"></label>
                                    <div class="input-group" :class="{'has-error-custom': errors.name}">
                                        <span class="input-group-text"><i class="fa-solid fa-store"></i></span>
                                        <input type="text" v-model="joinRentalRequestData.store_name" class="form-control" :placeholder="$t('message.storeName')">
                                    </div>
                                    <span class="text-danger" v-if="errors.store_name" v-text="errors.store_name[0]"></span>
                                </div>
                            </div>

                            <!-- city -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" v-text="$t('message.city')"></label>
                                    <select2 v-model="joinRentalRequestData.city_id" :options="cities" :settings="{width: '100%', placeholder: $t('message.chooseACity')}"></select2>
                                    <span class="text-danger" v-if="errors.city_id" v-text="errors.city_id[0]"></span>
                                </div>
                            </div>

                            <!-- email -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" v-text="$t('message.correspondenceEmail')"></label>
                                    <div class="input-group" :class="{'has-error-custom': errors.email}">
                                        <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                        <input type="email" dir="ltr" v-model="joinRentalRequestData.email" class="form-control" :placeholder="$t('message.correspondenceEmail')">
                                    </div>
                                    <span class="text-danger" v-if="errors.email" v-text="errors.email[0]"></span>
                                </div>
                            </div>

                            <!-- phone -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" v-text="$t('message.phone')"></label>
                                    <div class="input-group" :class="{'has-error-custom': errors.phone}">
                                        <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                        <input type="tel" maxlength="9" dir="ltr" v-model="joinRentalRequestData.phone" class="form-control" placeholder="5XxXxXxXxX">
                                    </div>
                                    <span class="text-danger" v-if="errors.phone" v-text="errors.phone[0]"></span>
                                </div>
                            </div>

                            <!-- store address -->
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" v-text="$t('message.address')"></label>
                                    <div class="input-group" :class="{'has-error-custom': errors.address}">
                                        <span class="input-group-text"><i class="fa-solid fa-location-arrow"></i></span>
                                        <input type="text" v-model="joinRentalRequestData.address" class="form-control" :placeholder="$t('message.address')">
                                    </div>
                                    <span class="text-danger" v-if="errors.address" v-text="errors.address[0]"></span>
                                </div>
                            </div>

                            <!-- logo -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" v-text="$t('message.storeLogo')"></label>
                                    <input type="file" :class="{'has-error-custom': errors.logo}" @change="store.commit('setFile', $event.target.files[0])" id="join-rental-business-logo" class="form-control" accept="image/*">
                                </div>
                                <span class="text-danger" v-if="errors.logo" v-text="errors.logo[0]"></span>
                            </div>

                            <div class="col-sm-6">
                                <img src="" class="img-fluid d-none" id="join-rental-business-logo-display" alt="store logo">
                            </div>

                            <div class="col-sm-12">
                                <div class="row gy-3 align-items-center mt-4 mb-5">
                                    <!-- agree rules -->
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" v-model="joinRentalRequestData.terms" type="checkbox" id="join-rental-business-agree">
                                            <label class="form-check-label" for="join-rental-business-agree">
                                                {{$t('message.iAgreeTo')}} <router-link :to="{name: 'contact-terms'}" class="text-decoration-underline" target="_blank" v-text="$t('message.contractTerms')"></router-link>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- submit btn -->
                                    <div class="col-sm-6">
                                        <button type="submit" @click="store.dispatch('setCountDown')" disabled id="btn-send-request" class="btn btn-primary-color" v-text="$t('message.sendRequest')"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end of registerModal -->
</template>
