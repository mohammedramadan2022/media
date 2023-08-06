<script setup>
import {useGetImage} from "@/composables/useHelper";
import {useStore} from "vuex";
import {computed} from "vue";

const store = useStore();

let errors = computed(() => store.state.errors);
let loginData = computed(() => store.state.auth.loginData);
</script>

<template>
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-close2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <div class="modal-body">
                    <router-link :to="{name: 'home'}">
                        <img class="img-fluid" :src="useGetImage('front/assets/images/rental-dark.svg')" alt="logo">
                    </router-link>

                    <h1 v-text="$t('message.email')"></h1>

                    <span v-text="$t('message.loginMessage')"></span>

                    <form @submit.prevent="store.dispatch('login')">
                        <!-- email -->
                        <div class="form-group mb-3">
                            <label class="form-label" v-text="$t('message.email')"></label>
                            <div class="input-group" :class="{'has-error-custom': errors.email}">
                                <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                <input type="email" name="email" dir="ltr" v-model="loginData.email" class="form-control" :placeholder="$t('message.email')">
                            </div>
                            <span class="text-danger" v-if="errors.email" v-text="errors.email[0]"></span>
                        </div>

                        <!-- password -->
                        <div class="form-group mb-3">
                            <label class="form-label" v-text="$t('message.password')"></label>
                            <div class="input-group" :class="{'has-error-custom': errors.password}">
                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password" dir="ltr" v-model="loginData.password" class="form-control" :placeholder="$t('message.password')">
                            </div>
                            <span class="text-danger" v-if="errors.password" v-text="errors.password[0]"></span>
                        </div>

                        <div class="text-center">
                            <a href="javascript:void(0);" @click="store.state.errors = {};" data-bs-target="#forgetPasswordModal" data-bs-toggle="modal" class="font-tajawal-bold d-inline-block mb-3" v-text="$t('message.forgetPasswordLink')"></a>
                            <button type="submit" class="btn btn-primary-color" v-text="$t('message.login')"></button>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <div class="other-options">
                        <span class="me-2" v-text="$t('message.notHaveAccount')"></span>
                        <a href="javascript:void(0);" @click="store.state.errors = {};" data-bs-target="#registerModal" data-bs-toggle="modal" class="new-account" v-text="$t('message.registerNewAccount')"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
