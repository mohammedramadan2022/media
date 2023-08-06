export function useGetHeaders(other = {}){
    const main = {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'lang': localStorage.getItem('lang'),
        }
    };

    return Object.assign({}, main, other);
}
