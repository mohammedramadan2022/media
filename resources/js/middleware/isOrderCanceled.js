export async function isOrderCanceled(to, form, next) {
    try {
        let order_no = parseInt(to.fullPath.split("/")[3]);
        let response = await axios.post('/user/getOrderById', {order_no});
        if (response.data.status) return next();
        else return next({name: 'orders'});
    } catch (e) {
        if (e.response && e.response.status === 400 || e.response && e.response.status === 422) {
            return next({name: 'orders'});
        }
    }
}
