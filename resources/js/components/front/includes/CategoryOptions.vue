<script setup>
import {useStore} from "vuex";
import {useRoute} from "vue-router";
import {computed} from "vue";
import {changeSelectedVal} from "@/composables/useHelper";

defineProps(['from', 'currentRoute']);

const store = useStore();
const route = useRoute();

if (!$.isEmptyObject(route.params)) store.dispatch('getDefaultSpecForSection', route.params.id);

else store.dispatch('getAbsoluteSpec');

let specs = computed(() => store.state.product.allSpecs);
let options = computed(() => store.state.product.options);
let category_id = computed(() => store.state.product.category_id);
</script>

<template>
    <div class="row g-3 mt-1 row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-1" v-if="specs.length > 0">
        <template v-for="spec in specs" :key="spec.id">
            <div class="col" v-if="spec.type === 'select' && spec.dropdown === 'color'">
                <div class="sections-div">
                    <h6 v-text="spec.name"></h6>
                    <ul class="list-unstyled sections-data">
                        <template v-for="option in spec.options" :key="option.id">
                            <input type="checkbox" class="btn-check option-filter" :id="'select-input-check-'+option.id" v-model="options" @click.prevent="changeSelectedVal(option,'option','color', category_id, from, currentRoute)" autocomplete="off"/>
                            <label class="btn custom-color-display" :class="['custom-color-display-' + option.id]" :style="{'background-color': option.value}" :for="'select-input-check-'+option.id"></label>
                        </template>
                    </ul>
                </div>
            </div>
            <div class="col" v-else-if="spec.type === 'boolean' && spec.dropdown === null">
                <div class="sections-div">
                    <h6 v-text="spec.name"></h6>
                    <ul class="list-unstyled sections-data">
                        <li>
                            <div class="form-check">
                                <input class="form-check-input me-2" type="checkbox" v-model="options" @click.prevent="changeSelectedVal(spec,'spec','boolean', category_id, from, currentRoute)" :id="'boolean-input-check-' + spec.id"/>
                                <label class="form-check-label mt-2" :for="'boolean-input-check-' + spec.id" v-text="spec.name"></label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col" v-else-if="spec.type === 'text' && spec.dropdown === null">
                <div class="sections-div">
                    <h6 v-text="spec.name"></h6>
                    <ul class="list-unstyled sections-data">
                        <li>
                            <div class="form-check">
                                <input class="form-check-input me-2" @click.prevent="changeSelectedVal(spec,'spec','text', category_id, from, currentRoute)" v-model="options" type="checkbox" :id="'spec-check-input-'+spec.id">
                                <label class="form-check-label mt-2" :for="'spec-check-input-'+spec.id" v-text="spec.name"></label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col" v-else>
                <div class="sections-div">
                    <h6 v-text="spec.name"></h6>
                    <ul class="list-unstyled sections-data">
                        <li v-for="option in spec.options">
                            <div class="form-check">
                                <input class="form-check-input me-2" @click.prevent="changeSelectedVal(option,'option','text', category_id, from, currentRoute)" v-model="options" type="checkbox" :id="'option-check-input-'+option.id">
                                <label class="form-check-label mt-2" :for="'option-check-input-'+option.id" v-text="option.name"></label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </template>
    </div>
</template>
