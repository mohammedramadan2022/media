<script setup>
import {useStore} from "vuex";

const store = useStore();
const props = defineProps(['product']);

function checkUserAuth() {
    $('#ratesDisplayModal').modal('hide');
    $('#rateModal').modal('show');
}
</script>

<template>
    <div class="modal fade" id="ratesDisplayModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-close2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <h1 v-text="$t('message.theRates')"></h1>

                    <div class="rate-unit" v-if="product.rates" v-for="(review, index) in product.rates.slice(0,4)" :key="index">
                        <p v-text="review.name"></p>
                        <div>
                            <template v-for="(n, i) in 5" :key="i">
                                <template v-if="review.rate >= n"><i class="fa-solid fa-star text-warning"></i></template>
                                <template v-else><i class="fa-solid fa-star text-secondary"></i></template>
                            </template>
                        </div>
                        <span v-if="review.comment !== ''" v-text="review.comment"></span>
                        <small v-text="review.since"></small>
                    </div>

                    <div class="row row-cols-auto justify-content-center align-items-center mb-3">
                        <div class="col">
                            <a
                                href="javascript:void(0);"
                                class="btn btn-primary-color"
                                v-if="!product.is_rated"
                                @click="checkUserAuth"
                                v-text="$t('message.addNewReview')"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
