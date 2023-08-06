<script setup>
import {useGetImage} from "@/composables/useHelper";
import {useStore} from "vuex";
import {computed} from "vue";

const store = useStore();

let newPassword = computed(() => store.state.auth.newPassword);
let errors = computed(() => store.state.errors);
</script>

<template>
    <div class="modal fade" id="newPasswordModal" tabindex="-1">
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

                    <h1 v-text="$t('message.newPassword')"></h1>

                    <span v-text="$t('message.newPasswordMessage')"></span>

                    <form @submit.prevent="store.dispatch('newPasswordSubmit')">
                        <!-- password -->
                        <div class="form-group mb-3">
                            <label class="form-label" v-text="$t('message.newPassword')"></label>
                            <div class="input-group" :class="{'has-error-custom': errors.password}">
                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" dir="ltr" v-model="newPassword.password" name="password" class="form-control" :placeholder="$t('message.newPassword')">
                            </div>
                            <span class="text-danger" v-if="errors.password" v-text="errors.password"></span>
                        </div>

                        <!-- confirm password -->
                        <div class="form-group mb-3">
                            <label class="form-label" v-text="$t('message.confirmNewPassword')"></label>
                            <div class="input-group" :class="{'has-error-custom': errors.password_confirmation}">
                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" dir="ltr" v-model="newPassword.password_confirmation" name="password_confirmation" class="form-control" :placeholder="$t('message.confirmNewPassword')">
                            </div>
                            <span class="text-danger" v-if="errors.password_confirmation" v-text="errors.password_confirmation"></span>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary-color" v-text="$t('message.confirm')"></button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="other-options">
                        <a href="javascript:void(0);" data-bs-target="#loginModal" data-bs-toggle="modal" v-text="$t('message.cancel')"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
