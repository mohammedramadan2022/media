<script setup>
import {useGetImage} from "@/composables/useHelper";
import {computed} from "vue";
import {useStore} from "vuex";

const store = useStore();

let countDown = computed(() => store.state.countDown);
let digits = computed(() => store.state.auth.digits);
</script>

<template>
    <div class="modal fade" id="confirmMobileModal" tabindex="-1">
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

                    <h1 v-text="$t('message.confirmPhoneNumber')"></h1>

                    <span v-text="$t('message.confirmMobileMessage')"></span>

                    <form @submit.prevent="store.dispatch('confirmMobilePhone')">
                        <!-- mobile -->
                        <div class="form-group mb-3 text-center">
                            <label class="form-label" v-text="$t('message.resetCode')"></label>
                            <div class="row row-cols-4 justify-content-center otp-code-div">
                                <div class="col"><input type="text" required v-model="digits.four" name="four" class="form-control" id="digit-4" data-next="digit-5" data-previous="digit-3"></div>
                                <div class="col"><input type="text" required v-model="digits.three" name="three" class="form-control" id="digit-3" data-next="digit-4" data-previous="digit-2"></div>
                                <div class="col"><input type="text" required v-model="digits.two" name="two" class="form-control" id="digit-2" data-next="digit-3" data-previous="digit-1"></div>
                                <div class="col"><input type="text" required v-model="digits.one" name="one" class="form-control" id="digit-1" data-next="digit-2"></div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary-color" v-text="$t('message.confirm')"></button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="other-options">
                        <a href="#" @click="store.dispatch('resendActiveCode')" class="resend" v-if="countDown === 0">
                            <i class="fa-solid fa-rotate-right"></i>&nbsp;&nbsp;{{$t('message.resendActiveCode')}}
                        </a>
                        <span class="ms-2 timer"> {{$t('message.after')}} <span>00:{{countDown >= 10 ? countDown : '0' + countDown}}</span>{{$t('message.second')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
