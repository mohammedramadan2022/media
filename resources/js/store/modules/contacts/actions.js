import {useSuccessSwal} from "@/composables/useSwal";

export default {
    async sendMessage({state, rootState}) {
        let response = await axios.post('/contactUsMessage', state.contactUsData);
        rootState.errors = {};
        state.contactUsData = {};
        await useSuccessSwal(response.data.message);
    },
    async getAllSubjects({state}) {
        let response = await axios.get('/getAllSubjects');
        state.allSubjects = response.data.data;
    },
};
