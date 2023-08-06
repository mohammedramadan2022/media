<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import {useGetImage} from "@/composables/useHelper";
import {computed} from "vue";
import {useStore} from "vuex";

const store = useStore();

store.dispatch('getAllSubjects');
store.dispatch('fetchFooter');

let location = computed(() => store.getters.location);
let footerData = computed(() => store.state.footerData);
let errors = computed(() => store.state.errors);
let contactUsData = computed(() => store.state.contacts.contactUsData);
let allSubjects = computed(() => store.state.contacts.allSubjects);
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'contact-us'}" v-text="$t('message.contactUs')"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content" class="contact-us">
            <div class="container">
                <!-- form -->
                <div class="contact-us-form">
                    <div class="row gx-5 gy-2 text-center text-lg-start align-items-center">
                        <div class="col-lg-4">
                            <img class="img-fluid" :src="useGetImage('front/assets/images/contact-us.png')" alt="contact us image">
                        </div>

                        <div class="col-lg-8">
                            <h6 v-text="$t('message.contactWithUs')"></h6>
                            <h1 v-text="$t('message.contactUsMessage')"></h1>

                            <form @submit.prevent="store.dispatch('sendMessage')">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group mb-3" :class="{'has-error-custom': errors.name}">
                                            <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                                            <input type="text" v-model="contactUsData.name" name="name" class="form-control" :placeholder="$t('message.name')">
                                        </div>
                                        <span class="text-danger d-block w-100" v-if="errors.name" v-text="errors.name[0]"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group mb-3" :class="{'has-error-custom': errors.phone}">
                                            <span class="input-group-text">
                                                <i class="fa-solid fa-mobile-screen-button"></i>
                                            </span>
                                            <input type="number" v-model="contactUsData.phone" min="0" name="phone" class="form-control" :placeholder="$t('message.phone')">
                                        </div>
                                        <span class="text-danger d-block w-100" v-if="errors.phone" v-text="errors.phone[0]"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group mb-3" :class="{'has-error-custom': errors.email}">
                                            <span class="input-group-text">
                                                <i class="fa-regular fa-envelope"></i>
                                            </span>
                                            <input type="email" v-model="contactUsData.email" name="email" class="form-control" :placeholder="$t('message.email')">
                                        </div>
                                        <span class="text-danger d-block w-100" v-if="errors.email" v-text="errors.email[0]"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3" :class="{'has-error-custom': errors.subject_id}">
                                            <select class="form-control" v-model="contactUsData.subject_id" name="subject_id">
                                                <option disabled selected value="" v-text="$t('message.subject')"></option>
                                                <option v-for="subject in allSubjects" :value="subject.id" v-text="subject.name"></option>
                                            </select>
                                        </div>
                                        <span class="text-danger d-block w-100" v-if="errors.subject_id" v-text="errors.subject_id[0]"></span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3" :class="{'has-error-custom': errors.message}">
                                            <textarea name="message" v-model="contactUsData.message" class="form-control" rows="5" :placeholder="$t('message.writeYourMessage')"></textarea>
                                        </div>
                                        <span class="text-danger d-block w-100" v-if="errors.message" v-text="errors.message[0]"></span>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary-color" v-text="$t('message.send')"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- address & info -->
                <div class="contact-us-info" v-if="footerData.contact_section_status">
                    <div class="text-center">
                        <h6 v-text="$t('message.address')"></h6>
                        <h1 v-text="$t('message.locationOnMap')"></h1>
                    </div>
                    <div class="row gx-5 gy-3 align-items-center">
                        <div class="col-lg-5">
                            <!-- work times -->
                            <div class="contact-us-info-item row gx-3 align-items-center">
                                <div class="col-auto">
                                    <div class="custom-icon">
                                        <i class="fa-solid fa-clock"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <span v-text="$t('message.workTime')"></span>
                                    <h5 v-text="footerData.work_times"></h5>
                                </div>
                            </div>
                            <!-- phone -->
                            <div class="contact-us-info-item row gx-3 align-items-center mt-4">
                                <div class="col-auto">
                                    <div class="custom-icon">
                                        <i class="fa-solid fa-phone-volume"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <span v-text="$t('message.technicalSupportNumber')"></span>
                                    <h5 v-text="footerData.customer_service"></h5>
                                </div>
                            </div>
                            <!-- address -->
                            <div class="contact-us-info-item row gx-3 align-items-center mt-4">
                                <div class="col-auto">
                                    <div class="custom-icon">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <span v-text="$t('message.mainBranchAddress')"></span>
                                    <h5 v-text="footerData.address"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <!-- Google Map Generator (No API needed) -->
                            <div class="mapouter">
                                <div class="gmap_canvas">
                                    <iframe width="100%" height="300" id="gmap_canvas" :src="location" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                                    <a href="https://2piratebay.org">pirate bay</a><br>
                                    <a href="https://www.embedgooglemap.net"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </app-layout>
</template>

<style>
.mapouter {
    position: relative;
    text-align: right;
    height: 300px;
    width: 100%;
}
.gmap_canvas {
    overflow: hidden;
    background: none !important;
    height: 300px;
    width: 100%;
}
span.text-danger.d-block.w-100 {
    margin-top: -14px;
}
.has-error-custom {
    border: 1px solid red;
    border-radius: 5px;
}
</style>
