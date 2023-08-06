export default {
    allStores: [],
    allProducts: [],
    allStoreSpecs: [],
    options: [],
    copyProducts: [],
    categoryProductsFilterData: {
        city_id: '',
        term: '',
        has_offer: false,
        type: 'stores'
    },
    sections: {
        all: 0,
        sections: [],
        offers_count: 0
    },
    pagination: {},
    has_pagination: false,
    is_exists: null,
    has_options_pagination: false,
    currentPage: 1,
    category_id: 0,
    getSingleProvider: {
        city: {
            id: 0,
            image: '',
            products: '',
            text: '',
        },
        store_name: '',
        created_date: '',
        id: 0,
        is_rated: false,
        logo: '',
        name: '',
        rate: '',
        rate_count: '',
        rates: [],
    },
    filterData: {
        city_id: '',
        term: '',
        has_offer: false,
        created_date: ''
    },
    rateData: {
        store_id: 0,
        name: '',
        comment: '',
        rate: '1',
    },
    digits: {
        one: '',
        two: '',
        three: '',
        four: ''
    },
};
