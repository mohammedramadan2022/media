export async function useFetchFooter() {
    return await axios.get('/getContactUsInfo');
}
