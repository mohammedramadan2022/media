export default {
    location(state) {
        let loc = '';

        loc += "https://maps.google.com/maps?q=";
        loc += state.footerData.location.lat;
        loc += ",";
        loc += state.footerData.location.lng;
        loc += "&hl=es&z=14&output=embed";

        return loc;
    },
}
