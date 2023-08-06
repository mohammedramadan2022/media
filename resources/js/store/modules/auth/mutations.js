export default {
    async setIdentityImageFile(state, e) {
        state.profileData.identity = e;
    },
    resetDigits(state){
        state.digits.one = '';
        state.digits.two = '';
        state.digits.three = '';
        state.digits.four = '';
    },
}
