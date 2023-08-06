import {getCustomKey} from "@/composables/useStorage";

export default {
    lang: getCustomKey('lang'),
    home: {
        banners: [],
        sections: [],
        cities: [],
        previews: [],
        features: [],
        stores: [],
        popular: []
    },
    footerData: {
        location: {
            lat: '',
            lng: ''
        },
        work_times: '',
        customer_service: '',
        footer_logo: '',
        contact_section_status: false,
    },
    newsletter: {
        email: ''
    },
    isLoading: true,
    countDown: 60,
    getAboutUsPage: '',
    getTermsPage: '',
    termsPdfFile: '',
    getPolicyPage: '',
    policyPdfFile: '',
    whatWeProvide: '',
    contractTermsPage: '',
    getFaqsPage: [],
    getAllCities: [],
    getCitiesHasProducts: [],
    getAllSections: [],
    getMetaInfo: {
        author: '',
        description: '',
        twitter_title: '',
        twitter_site: '',
        twitter_creator: '',
        keywords: '',
        image: '',
        name: '',
    },
    errors: {},
    joinRentalRequestData: {
        name: '',
        store_name: '',
        email: '',
        phone: '',
        identity: '',
        city_id: '',
        terms: 0,
        logo: null
    },
    formData: [],
    responseMessage: '',
    sectionId: '',
    searchResult: [],
};
