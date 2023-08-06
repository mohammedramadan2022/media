<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";
import User from "@/libs/User";

const store = useStore();
let auth = ref({});

onMounted(() => {
    store.dispatch('getUpdatedProfile');
    auth.value = User.auth();
});

let errors = computed(() => store.state.errors);
let profileData = computed(() => store.state.auth.profileData);
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item"><router-link :to="{name: 'profile'}" v-text="$t('message.personalInfo')"></router-link></li>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'edit-profile'}" v-text="$t('message.edit')"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content" class="my-account personal-info-edit">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-9">
                        <div class="data">
                            <form @submit.prevent="store.dispatch('updateUserProfile')">
                                <div class="row gy-2 gy-sm-0 justify-content-center justify-content-sm-between align-items-center top-title-div">
                                    <div class="col-auto">
                                        <h6 v-text="$t('message.editPersonalInformation')"></h6>
                                    </div>
                                    <div class="col-auto">
                                        <router-link :to="{name: 'profile'}" class="cancel-link" v-text="$t('message.cancel')"></router-link>
                                        <button type="submit" class="btn btn-primary-color ms-2" v-text="$t('message.save')"></button>
                                    </div>
                                </div>

                                <div class="col row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label class="form-label" v-text="$t('message.identityImage')"></label>
                                            <input type="file" @change="store.commit('setIdentityImageFile', $event.target.files[0])" id="join-rental-business-logo" class="form-control" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <img :src="User.auth().identity" style="width: 200px;height: 200px;" :class="{'d-none': !User.auth().identity}" class="img-fluid" id="join-rental-business-logo-display" alt="identity image">
                                    </div>
                                </div>

                                <div class="row gy-3 row-cols-1 row-cols-md-2">
                                    <div class="col">
                                        <label for="identity-number" class="form-label" v-text="$t('message.identityNumber')"></label>
                                        <input type="text" v-model="profileData.identity_number" class="form-control" id="identity-number" :placeholder="$t('message.identityNumber')">
                                    </div>

                                    <div class="col">
                                        <label for="first-name" class="form-label" v-text="$t('message.firstName')"></label>
                                        <input type="text" v-model="profileData.first_name" class="form-control" id="first-name" :placeholder="$t('message.firstName')">
                                    </div>

                                    <div class="col">
                                        <label for="last-name" class="form-label" v-text="$t('message.lastName')"></label>
                                        <input type="text" v-model="profileData.last_name" class="form-control" id="last-name" :placeholder="$t('message.lastName')">
                                    </div>

                                    <div class="col">
                                        <label for="email" class="form-label" v-text="$t('message.email')"></label>
                                        <input type="email" v-model="profileData.email" class="form-control" id="email" :placeholder="$t('message.email')">
                                    </div>

                                    <div class="col">
                                        <label for="mobile" class="form-label" v-text="$t('message.phone')"></label>
                                        <input type="text" dir="ltr" v-model="profileData.phone" class="form-control" id="mobile" :placeholder="$t('message.phone')">
                                    </div>

                                    <div class="col">
                                        <label for="mobile" class="form-label" v-text="$t('message.whatsapp')"></label>
                                        <input type="text" dir="ltr" v-model="profileData.whatsapp" class="form-control" id="whatsapp" :placeholder="$t('message.whatsapp')">
                                    </div>

                                    <div class="col">
                                        <label for="city" class="form-label" v-text="$t('message.city')"></label>
                                        <select class="form-select" id="city" v-model="profileData.city_id">
                                            <option selected disabled value="" v-text="$t('message.chooseACity')"></option>
                                            <option
                                                v-for="(city, index) in store.state.getAllCities"
                                                :selected="auth.city ? (auth.city.id === city.id) : false"
                                                :value="city.id"
                                                :key="index" v-text="city.text"></option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </app-layout>
</template>
