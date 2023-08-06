import moment from "moment/moment";

export default {
    async nextOrdersPage(state) {
        state.pagination.currentPage += 1;
    },
    async setOrderPaginated(state, response) {
        state.pagination = response.data.data.pagination;
    },
    async setPaginationOrdersToMain(state) {
        state.has_order_filter_pagination = false;
        state.has_pagination = state.pagination.last_page !== state.pagination.currentPage;
    },
    async setPaginationOrdersToFilter(state) {
        state.has_pagination = false;
        state.has_order_filter_pagination = state.pagination.last_page !== state.pagination.currentPage;
    },
    async setOrderSummaryDates(state, order) {
        state.orderSummaryDatesData.startDate = moment(order.summary.start_date).format('YYYY-MM-DD');
        state.orderSummaryDatesData.startTime = moment(order.summary.start_time).format('H:mm');
        state.orderSummaryDatesData.endDate = moment(order.summary.end_date).format('YYYY-MM-DD');
        state.orderSummaryDatesData.endTime = moment(order.summary.end_time).format('H:mm');
    },
};
