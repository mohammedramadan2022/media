import {useSuccessSwal} from "@/composables/useSwal";
import {storeCustomKey} from "@/composables/useStorage";

export default {
    async setCountDown({state, rootState, dispatch}){
        if (rootState.countDown > 0) {
            let callback = () => {
                rootState.countDown = rootState.countDown > 0 ? (rootState.countDown - 1) : rootState.countDown;
                dispatch('setCountDown');
            };

            setTimeout(callback,1000);
        }
    },
    async getHomePage({commit, state}) {
        state.isLoading = true;
        let response = await axios.get('/user/getHomePage');
        commit('fillHome', response);
        state.isLoading = false;
    },
    async fetchFooter({state}) {
        let response = await axios.get('/getContactUsInfo');
        state.footerData = response.data.data;
    },
    async getAboutUsPage({state}) {
        state.isLoading = true;
        let {data} = await axios.get('/getAboutUsPage');
        state.getAboutUsPage = data.data.content;
        state.isLoading = false;
    },
    async getTermsPage({state}) {
        state.isLoading = true;
        let {data} = await axios.get('/getTermsPage');
        state.getTermsPage = data.data.content
        state.termsPdfFile = data.data.file;
        state.isLoading = false;
    },
    async getPrivacyPage({state}) {
        state.isLoading = true;
        let {data} = await axios.get('/getPrivacyPage');
        state.getPolicyPage = data.data.content
        state.policyPdfFile = data.data.file;
        state.isLoading = false;
    },
    async getContractTermsPage({state}) {
        state.isLoading = true;
        let {data} = await axios.get('/getContractTermsPage');
        state.contractTermsPage = data.data.content;
        state.isLoading = false;
    },
    async whatWeProvide({state}) {
        state.isLoading = true;
        let {data} = await axios.get('/getWhatWeProvideForYou');
        state.whatWeProvide = data.data;
        state.isLoading = false;
    },
    async getFaqsPage({state}) {
        state.isLoading = true;
        let {data} = await axios.get('/getFaqsPage');
        state.getFaqsPage = data.data;
        state.isLoading = false;
    },
    async getAllCities({state}) {
        let {data} = await axios.get('/getAllCities');
        state.getAllCities = data.data;
    },
    async getCitiesHasProducts({state}) {
        let {data} = await axios.get('/getCitiesHasProducts');
        state.getCitiesHasProducts = data.data;
    },
    async getMetaInfo({state}) {
        let {data} = await axios.get('/getMetaInfo');
        state.getMetaInfo = data.data;
    },
    async newsletterSubscription({state}) {
        let {data} = await axios.post('/newsletterSubscription', {email: state.newsletter.email});
        state.newsletter.email = '';
        await useSuccessSwal(data.message);
    },
    async setUserJoinRequest({state, dispatch, rootState, commit}){
        try {
            rootState.isLoading = true;
            commit('fillFormData');

            let response = await axios.post('/setUserJoinRequest', state.formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });

            if (response.status === 200) storeCustomKey('userPhone', state.joinRentalRequestData.phone);

            state.responseMessage = response.data.message;
            state.errors = {};

            rootState.isLoading = false;

            $('.select2-selection.select2-selection--single').css('border-color', '');
            $('input#join-rental-business-agree').closest('form').find('#btn-send-request').attr('disabled', false);

            let callback = () => {
                state.responseMessage = '';
                $('#joinRentalBusinessModal').modal('hide');
                $('#confirmJoinModal').modal('show');
                rootState.countDown = 60;
                dispatch('setCountDown');
            };

            setTimeout(callback,1000);

            state.joinRentalRequestData = {};
        } catch (e) {
            if (e.response.status === 422) {
                $('.select2-selection.select2-selection--single').css('border-color', e.response.data.data.city_id ? 'red' : '');
            }
        }
    },
    async searchByKey({state, rootState}, value) {
        let response = await axios.post('/filterProducts', {term: value, section_id: rootState.sectionId});
        state.searchResult = response.data.data.data;
    },
    async cleanSearchResult({state}) {
        state.searchResult = [];
    }
}
