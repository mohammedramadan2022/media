<script setup>
import ProfileSideMenu from "@/components/front/includes/ProfileSideMenu";
import AppLayout from "@/components/front/layout/AppLayout";
import {useStore} from "vuex";
import {computed} from "vue";

const store = useStore();

store.dispatch('getCitiesHasProducts');

let addressData = computed(() => store.state.address.addressDefaultData);
let errors = computed(() => store.state.errors);
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item"><router-link :to="{name: 'addresses'}" v-text="$t('message.myAddresses')"></router-link></li>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'add-new-address'}" v-text="$t('message.addNewAddress')"></router-link>
            </li>
        </template>

        <template #default>
            <!-- content -->
            <section id="content" class="my-account my-addresses">
                <div class="container">
                    <div class="row gy-3 gy-lg-0">
                        <!-- menu -->
                        <div class="col-lg-3">
                            <profile-side-menu/>
                        </div>
                        <!-- data -->
                        <div class="col-lg-9">
                            <div class="data">
                                <form @submit.prevent="store.dispatch('addNewAddress')">
                                    <div class="row justify-content-between align-items-center mb-3">
                                        <div class="col-auto">
                                            <h6 v-text="$t('message.addAddress')"></h6>
                                        </div>
                                        <div class="col-auto">
                                            <router-link @click="store.state.errors = {}" :to="{name: 'addresses'}" class="address-cancel" v-text="$t('message.cancel')"></router-link>
                                            <button type="submit" class="btn btn-primary-color" v-text="$t('message.add')"></button>
                                        </div>
                                    </div>

                                    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 text-start">
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
                                                <input type="text"  maxlength="9" :class="{'has-error-custom': errors.phone}" v-model="addressData.phone" class="form-control" id="address-mobile" :placeholder="$t('message.enterVar', {var: $t('message.phone')})">
                                            </div>
                                            <span class="text-danger" v-if="errors.phone" v-text="errors.phone[0]"></span>
                                        </div>
                                        <div class="col">
                                            <div class="mb-2">
                                                <label for="address-city" class="form-label" v-text="$t('message.city')"></label>
                                                <select :class="{'has-error-custom': errors.city_id}" class="form-select" v-model="addressData.city_id" id="address-city">
                                                    <option value="" selected disabled v-text="$t('message.chooseACity')"></option>
                                                    <option v-for="(city, index) in store.state.getCitiesHasProducts" :value="city.id" :key="index" v-text="city.text"></option>
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
                                                <input type="text" :class="{'has-error-custom': errors.special_marque}" class="form-control" v-model="addressData.special_marque" id="address-trademark" :placeholder="$t('message.enterVar', {var: $t('message.tSpecialMarque')})">
                                            </div>
                                            <span class="text-danger" v-if="errors.special_marque" v-text="errors.special_marque[0]"></span>
                                        </div>
                                        <div class="col">
                                            <div class="mb-2">
                                                <label for="address-map-url" class="form-label" v-text="$t('message.mapUrl')"></label>
                                                <input type="text" :class="{'has-error-custom': errors.map_url}" class="form-control" v-model="addressData.map_url" id="address-map-url" :placeholder="$t('message.enterVar', {var: $t('message.mapUrl')})">
                                            </div>
                                            <span class="text-danger" v-if="errors.map_url" v-text="errors.map_url[0]"></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </template>
    </app-layout>
</template>

<style scoped>
a.address-cancel {
    margin: 10px;
}
</style>
