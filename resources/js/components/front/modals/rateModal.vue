<script setup>
import {useStore} from "vuex";
import {computed} from "vue";

const store = useStore();
const props = defineProps(['product']);

let rateData = computed(() => store.state.product.rateData);
let errors = computed(() => store.state.errors);
</script>

<template>
    <div class="modal fade" id="rateModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-close2" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <h1 v-text="$t('message.rateProduct')"></h1>

                    <form @submit.prevent="store.dispatch('setUserProductRate', product.id)">
                        <div class="form-group mb-3">
                            <label class="form-label" v-text="$t('message.userName')"></label>
                            <div class="input-group" :class="{'has-error-custom': errors.name}">
                                <input type="text" v-model="rateData.name" class="form-control" :placeholder="$t('message.userName')">
                            </div>
                            <span class="text-danger" v-if="errors.name" v-text="errors.name[0]"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" v-text="$t('message.writeYourComment')"></label>
                            <div class="input-group" :class="{'has-error-custom': errors.comment}">
                                <textarea class="form-control" v-model="rateData.comment" :placeholder="$t('message.writeYourComment')" rows="4"></textarea>
                            </div>
                            <span class="text-danger" v-if="errors.comment" v-text="errors.comment[0]"></span>
                        </div>

                        <div class="rate-section">
                            <div class="row gy-4 align-items-center">
                                <div class="col-6 col-sm-4">
                                    <p v-text="$t('message.selectYourRate')"></p>
                                </div>
                                <div class="col-6 col-sm-8">
                                    <div class="rates-input-div">
                                        <input type="hidden" name="rate" class="rate-input">
                                        <i class="fa-regular fa-star rate-event" data-count="1"></i>
                                        <i class="fa-regular fa-star rate-event" data-count="2"></i>
                                        <i class="fa-regular fa-star rate-event" data-count="3"></i>
                                        <i class="fa-regular fa-star rate-event" data-count="4"></i>
                                        <i class="fa-regular fa-star rate-event" data-count="5"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger" v-if="errors.rate" v-text="errors.rate[0]"></span>
                        </div>

                        <div class="row g-4 row-cols-auto justify-content-center align-items-center mb-3">
                            <div class="col">
                                <button type="submit" class="btn btn-primary-color" v-text="$t('message.addNewTheReview')"></button>
                            </div>
                            <div class="col">
                                <a href="javascript:void(0);" class="btn btn-outline-primary-color" data-bs-dismiss="modal" v-text="$t('message.close')"></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
