<script setup>
import {useGetImage} from "@/composables/useHelper";
import {useStore} from "vuex";
import {computed} from "vue";

const store = useStore();

let forgetPasswordData = computed(() => store.state.auth.forgetPasswordData);
let errors = computed(() => store.state.errors);

</script>

<template>
    <div class="modal fade" id="forgetPasswordModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-close2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <router-link :to="{name: 'home'}">
                        <img class="img-fluid" :src="useGetImage('front/assets/images/rental-dark.svg')" alt="logo">
                    </router-link>

                    <h1 v-text="$t('message.forgetPassword')"></h1>

                    <span v-text="$t('message.forgetPasswordTitle')"></span>

                    <form @submit.prevent="store.dispatch('forgetPasswordSubmit')">
                        <!-- mobile -->
                        <div class="form-group mb-3">
                            <label class="form-label" v-text="$t('message.phone')"></label>
                            <div class="input-group" :class="{'has-error-custom': errors.phone}">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-mobile-screen-button"></i>
                                </span>
                                <input type="text" maxlength="9" dir="ltr" v-model="forgetPasswordData.phone" min="0" class="form-control custom-mobile" :placeholder="$t('message.enterMobilePhone')">
                                <span class="input-group-text input-group-text2">
                                <span>+966</span>
                                    <img class="img-fluid" :src="useGetImage('front/assets/images/icons/saudi2.svg')" alt="saudi icon">
                                </span>
                            </div>
                            <span class="text-danger" v-if="errors.phone" v-text="errors.phone[0]"></span>
                        </div>

                        <div class="text-center">
                            <button type="submit" @click="store.dispatch('setCountDown')" class="btn btn-primary-color" v-text="$t('message.confirm')"></button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="other-options">
                        <a href="javascript:void(0);" @click="store.state.errors = {};" data-bs-target="#loginModal" data-bs-toggle="modal" v-text="$t('message.cancel')"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
