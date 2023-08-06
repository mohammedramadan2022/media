<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import ProfileSideMenu from "@/components/front/includes/ProfileSideMenu";
import {computed} from "vue";
import {useStore} from "vuex";
import User from "@/libs/User";

const store = useStore();
let auth = User.auth();

store.dispatch('getAllAddresses');

let addresses = computed(() => store.state.address.addresses);

let address_icon_el = $('span#custom-address-check-icon-js-' + User.auth().address_id);

$('#deliver-way #show-addresses-div .address-item .address-item-title .form-check ' + '#address-' + User.auth().address_id + ' .form-check-input:checked').removeAttr('checked');
address_icon_el.append(``);
address_icon_el.append(`<i class="fa-solid fa-circle-check" style=" color: #8c9173; font-size: 22px; margin: auto; position: absolute; top: 2px; left: 0; bottom: 0; right: 0; "></i>`);

store.commit('setAddressItemStyle', User.auth().address_id);
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item active"><router-link :to="{name: 'addresses'}" v-text="$t('message.myAddresses')"></router-link></li>
        </template>

        <!-- content -->
        <section id="content" class="my-account" :class="{'my-addresses': addresses.length === 0, 'my-addresses-data': addresses.length > 0}">
            <div class="container">
                <div class="row gy-3 gy-lg-0">
                    <!-- menu -->
                    <div class="col-lg-3"><profile-side-menu/></div>

                    <!-- data -->
                    <div class="col-lg-9">
                        <div class="data" v-if="addresses.length === 0">
                            <h6 v-text="$t('message.noAddresses')"></h6>
                            <router-link :to="{name: 'add-new-address'}" class="add-address-big-link">
                                <div>
                                    <i class="fa-solid fa-circle-plus"></i>
                                    <span class="ms-2" v-text="$t('message.addNewAddress')"></span>
                                </div>
                            </router-link>
                        </div>
                        <div class="data" v-else>
                            <div class="row justify-content-between align-items-center mb-3">
                                <div class="col-auto">
                                    <h6 v-text="$t('message.selectDeliverAddress')"></h6>
                                </div>
                                <div class="col-auto">
                                    <router-link :to="{name: 'add-new-address'}" class="add-new-address">
                                        <i class="fa-solid fa-circle-plus"></i>{{$t('message.addNewAddress')}}
                                    </router-link>
                                </div>
                            </div>

                            <div class="row gy-3 row-cols-1 row-cols-lg-2">
                                <div class="col" v-for="(address, index) in addresses" :key="index" :id="'address-id-'+address.id">
                                    <div class="address-item">
                                        <div class="row justify-content-between align-items-center address-item-title">
                                            <div class="col-auto">
                                                <div class="form-check" style="position: relative;">
                                                    <input class="form-check-input" type="radio" @click="store.dispatch('setDefaultAddress', address)" :checked="parseInt(User.auth().address_id) === address.id" name="address_id" :value="address.id" :id="'address-'+address.id">
                                                    <span :id="'custom-address-check-icon-js-' + address.id">
                                                        <template v-if="User.auth().address_id === address.id">
                                                            <i class="fa-solid fa-circle-check" style=" color: #8c9173; font-size: 22px; margin: auto; position: absolute; top: 2px; left: 0; bottom: 0; right: 0; "></i>
                                                        </template>
                                                    </span>
                                                    <label class="form-check-label" :for="'address-'+address.id">
                                                        <i class="fa-solid fa-location-dot me-2"></i> {{ $t('message.addressNo', { num: index + 1 }) }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <router-link :to="{name: 'edit-address', params: {id: address.id}}" @click="store.dispatch('getAddressById', address.id);" class="address-actions edit-address">
                                                    <i class="fa-solid fa-pen"></i>
                                                </router-link>
                                                <a href="javascript:void(0);" @click.prevent="store.dispatch('deleteUserAddress', address.id)" class="address-actions remove-address">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row gy-3 align-items-center address-item-body">
                                            <div class="col-3"><span class="title" v-text="$t('message.address')"></span></div>
                                            <div class="col-9"><span class="value" v-text="address.full_address"></span></div>
                                            <div class="col-3"><span class="title" v-text="$t('message.phone')"></span></div>
                                            <div class="col-9">
                                                <span class="value" v-text="address.phone"></span>
                                                <i class="fa-solid fa-circle-check ms-3"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </app-layout>
</template>
