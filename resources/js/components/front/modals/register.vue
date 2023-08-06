<script setup>
import {useGetImage} from "@/composables/useHelper";
import {useStore} from "vuex";
import {computed} from "vue";

const store = useStore();

let errors = computed(() => store.state.errors);
let registerData = computed(() => store.state.auth.registerData);
</script>

<template>
    <div class="modal fade" id="registerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-close2" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <router-link :to="{name: 'home'}">
                        <img class="img-fluid" :src="useGetImage('front/assets/images/rental-dark.svg')" alt="logo">
                    </router-link>

                    <h1 v-text="$t('message.createNewAccount')"></h1>

                    <form @submit.prevent="store.dispatch('register')">
                        <div class="row">
                            <!-- first name -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" v-text="$t('message.firstName')"></label>
                                    <div class="input-group" :class="{'has-error-custom': errors.first_name}">
                                        <span class="input-group-text">
                                            <i class="fa-regular fa-user"></i>
                                        </span>
                                        <input type="text" v-model="registerData.first_name" name="first_name" class="form-control" :placeholder="$t('message.firstName')">
                                    </div>
                                    <span class="text-danger" v-if="errors.first_name" v-text="errors.first_name[0]"></span>
                                </div>
                            </div>

                            <!-- last name -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" v-text="$t('message.lastName')"></label>
                                    <div class="input-group" :class="{'has-error-custom': errors.last_name}">
                                        <span class="input-group-text">
                                            <i class="fa-regular fa-user"></i>
                                        </span>
                                        <input type="text" v-model="registerData.last_name" name="last_name" class="form-control" :placeholder="$t('message.lastName')">
                                    </div>
                                    <span class="text-danger" v-if="errors.last_name" v-text="errors.last_name[0]"></span>
                                </div>
                            </div>

                            <!-- email -->
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" v-text="$t('message.email')"></label>
                                    <div class="input-group" :class="{'has-error-custom': errors.email}">
                                        <span class="input-group-text">
                                            <i class="fa-regular fa-envelope"></i>
                                        </span>
                                        <input type="email" dir="ltr" v-model="registerData.email" name="email" class="form-control" :placeholder="$t('message.email')">
                                    </div>
                                    <span class="text-danger" v-if="errors.email" v-text="errors.email[0]"></span>
                                </div>
                            </div>

                            <!-- mobile -->
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" v-text="$t('message.phone')"></label>
                                    <div class="input-group" :class="{'has-error-custom': errors.phone}">
                                        <span class="input-group-text">
                                            <i class="fa-solid fa-mobile-screen-button"></i>
                                        </span>
                                        <input type="text" dir="ltr" v-model="registerData.phone" maxlength="9" name="phone" min="0" class="form-control custom-mobile" :placeholder="$t('message.phone')">
                                        <span class="input-group-text input-group-text2">
                                            <span>+966</span>
                                            <img class="img-fluid" :src="useGetImage('front/assets/images/icons/saudi2.svg')" alt="saudi icon">
                                        </span>
                                    </div>
                                    <span class="text-danger" v-if="errors.phone" v-text="errors.phone[0]"></span>
                                </div>
                            </div>

                            <!-- marketing code -->
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">
                                        {{ $t('message.ownAccessCode') }}
                                        <span class="ms-2">({{ $t('message.optional') }})</span>
                                    </label>
                                    <div class="input-group" :class="{'has-error-custom': errors.own_access_code}">
                                        <span class="input-group-text">
                                            <i class="fa-solid fa-barcode"></i>
                                        </span>
                                        <input type="text" dir="ltr" v-model="registerData.own_access_code" name="own_access_code" class="form-control" :placeholder="$t('message.ownAccessCode')">
                                    </div>
                                    <span class="text-danger" v-if="errors.own_access_code" v-text="errors.own_access_code[0]"></span>
                                </div>
                            </div>

                            <!-- whatsapp -->
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" v-text="$t('message.whatsapp')"></label>
                                    <div class="input-group" :class="{'has-error-custom': errors.whatsapp}">
                                        <span class="input-group-text">
                                            <i class="fa-solid fa-mobile-screen-button"></i>
                                        </span>
                                        <input type="text" dir="ltr" v-model="registerData.whatsapp" maxlength="9" name="whatsapp" min="0" class="form-control custom-mobile" :placeholder="$t('message.whatsapp')">
                                        <span class="input-group-text input-group-text2">
                                        <span>+966</span>
                                            <img class="img-fluid" :src="useGetImage('front/assets/images/icons/saudi2.svg')" alt="saudi icon">
                                        </span>
                                    </div>
                                    <span class="text-danger" v-if="errors.whatsapp" v-text="errors.whatsapp[0]"></span>
                                </div>
                            </div>

                            <!-- password -->
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" v-text="$t('message.password')"></label>
                                    <div class="input-group" :class="{'has-error-custom': errors.password}">
                                        <span class="input-group-text">
                                            <i class="fa-solid fa-lock"></i>
                                        </span>
                                        <input type="password" dir="ltr" v-model="registerData.password" name="password" class="form-control" :placeholder="$t('message.password')">
                                    </div>
                                    <span class="text-danger" v-if="errors.password" v-text="errors.password[0]"></span>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" @click="store.dispatch('setCountDown')" class="btn btn-primary-color" v-text="$t('message.confirmRegisterNewAccount')"></button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="other-options">
                        <span class="me-2" v-text="$t('message.haveAnAccount')"></span>
                        <a href="javascript:void(0);" @click="store.state.errors = {};" data-bs-target="#loginModal" data-bs-toggle="modal" class="new-account" v-text="$t('message.login')"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
