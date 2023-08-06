export default {
    allProducts: [],
    allPopular: [],
    allSpecs: [],
    pagination: {
        last_page: 0,
        currentPage: 0,
        total: 0
    },
    productsFilterData: {
        city_id: '',
        term: '',
        startDate: '',
        endDate: '',
        type: 'general',
        has_offer: null
    },
    has_pagination: false,
    has_filter_pagination: false,
    has_category_pagination: false,
    has_popular_pagination: false,
    has_section_pagination: false,
    has_offers_pagination: false,
    sections: {
        all: 0,
        sections: [],
        offers_count: 0
    },
    getProduct: {
        id: 0,
        is_fave: false,
        name: '',
        images: [],
        offer: '',
        has_offer: false,
        description: '',
        usage_instructions: '',
        rental_terms: '',
        product_code: '',
        owner: {
            id: 0,
            name: ''
        },
        city: {
            id: '',
            text: ''
        },
        section: {
            id: 0,
            icon: '',
            name: ''
        },
        qty: 1,
        cart_qty: 1,
        price: '',
        hour_price: '',
        rate: 0,
        is_rated: false,
        rate_count: 0,
        offer_value: 0,
        is_in_cart: false
    },
    similar: [],
    rateData: {
        product_id: 0,
        name: '',
        comment: '',
        rate: '1',
    },
    byCategory: false,
    category_id: 0,
    options: [],
};
