export default {
    state: {
        getAllSections: [],
        pagination: {
            last_page: 0,
            currentPage: 0
        },
        has_section_pagination: false,
    },
    mutations: {},
    actions: {
        async getAllSections({state}) {
            let {data} = await axios.get('/getAllSections?page=1');
            state.getAllSections = data.data;
        },
    },
    getters: {},
}
