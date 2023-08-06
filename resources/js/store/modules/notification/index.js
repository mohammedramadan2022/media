import {useConfirmDeleteSwal, useSuccessSwal} from "@/composables/useSwal";

export default {
    state: {
        pagination: {
            last_page: 0,
            currentPage: 0
        },
        notifications: [],
        count: 0,
        hasNotifications: false,
        has_pagination: false,
    },
    mutations: {
        async nextNotificationsPage(state) {
            state.pagination.currentPage += 1;
        },
        async setNotificationsPaginated(state, response) {
            state.pagination = response.data.data.pagination;
            state.has_pagination = state.pagination.last_page !== state.pagination.currentPage;
        },
    },
    actions: {
        async getNotificationsPage({state, rootState, commit}) {
            rootState.isLoading = true;
            let response = await axios.get('/user/getUserNotifications?page=1');
            state.notifications = response.data.data.data;
            commit('setNotificationsPaginated', response);
            rootState.isLoading = false;
        },
        async getNotificationsNextPage({state, rootState, commit}) {
            rootState.isLoading = true;
            commit('nextNotificationsPage');
            let response = await axios.get('/user/getUserNotifications?page=' + state.pagination.currentPage);
            state.notifications = state.notifications.concat(response.data.data.data);
            commit('setNotificationsPaginated', response);
            rootState.isLoading = false;
        },
        async removeUserNotification({state, rootState}, notification_id) {
            let response = await axios.post('/user/removeUserNotification',{notification_id});
            $('#notification-id-' + notification_id).fadeOut();
            if(response.data.status) await useSuccessSwal(response.data.message);
        },
        async deleteUserNotifications(context) {
            let confirm = await useConfirmDeleteSwal(trans('message.notificationsDeleteWarning'));
            if(!confirm.isConfirmed) return;
            let response = await axios.post('/user/deleteUserNotifications');
            if(response.data.status) await useSuccessSwal(response.data.message);
            window.location.reload();
        },
        async getUserNewNotificationsCount({state}){
            let response = await axios.get('/user/getUserNewNotificationsCount');
            state.count = response.data.data.count;
        }
    },
    getters: {},
}
