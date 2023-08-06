<script setup>
import {useGetImage} from "@/composables/useHelper";
import {computed} from "vue";
import {useStore} from "vuex";

const store = useStore();

let digits = computed(() => store.state.auth.digits);
let errors = computed(() => store.state.errors);
let countDown = computed(() => store.state.countDown);

</script>

<template>
    <div class="modal fade" id="checkResetCodeModal" tabindex="-1">
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

                    <h1 v-text="$t('message.checkResetCode')"></h1>

                    <span>{{$t('message.resetCodeMessage')}}</span>

                    <form @submit.prevent="store.dispatch('checkResetCode')">
                        <!-- mobile -->
                        <div class="form-group mb-3 text-center">
                            <label class="form-label"></label>
                            <div class="row row-cols-4 justify-content-center otp-code-div">
                                <div class="col">
                                    <input type="text" v-model="digits.four" :class="{'has-error-custom': errors.four}" name="four" class="form-control" id="digit-04" data-next="digit-05" data-previous="digit-03">
                                </div>
                                <div class="col">
                                    <input type="text" v-model="digits.three" :class="{'has-error-custom': errors.three}" name="three" class="form-control" id="digit-03" data-next="digit-04" data-previous="digit-02">
                                </div>
                                <div class="col">
                                    <input type="text" v-model="digits.two" :class="{'has-error-custom': errors.two}" name="two" class="form-control" id="digit-02" data-next="digit-03" data-previous="digit-01">
                                </div>
                                <div class="col">
                                    <input type="text" v-model="digits.one" :class="{'has-error-custom': errors.one}" name="one" class="form-control" id="digit-01" data-next="digit-02">
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary-color" v-text="$t('message.confirm')"></button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="other-options">
                        <a href="#" @click="store.dispatch('resendResetCode')" class="resend" v-if="countDown === 0">
                            <i class="fa-solid fa-rotate-right"></i>&nbsp;&nbsp;{{$t('message.resendActiveCode')}}
                        </a>
                        <span class="ms-2 timer"> {{$t('message.after')}} <span>00:{{countDown >= 10 ? countDown : '0' + countDown}}</span>{{$t('message.second')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
