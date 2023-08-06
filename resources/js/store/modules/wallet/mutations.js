export default {
    resetWalletChargeForm(state) {
        state.chargeWalletData.amount = '';
        state.chargeWalletData.card_holder = '';
        state.chargeWalletData.card_numbers = '';
        state.chargeWalletData.card_date = '';
        state.chargeWalletData.card_cvv = '';
    }
};
