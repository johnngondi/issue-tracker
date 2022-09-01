export function ucfirst(string) {
    if (string != null && string !== '' && string !== undefined){
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    return string;

}

export function ucwords(string) {
    if (string != null && string !== '' && string !== undefined) {
        return string.replace(/(?:^|\s)\S/g, function (a) {
            return a.toUpperCase();
        });
    } else {
        return string;
    }
}

export function  hasItemId(items, id) {
    let res = items.filter(item => (item.id === id)).length > 0;
    console.log(res)
    return res;
}

