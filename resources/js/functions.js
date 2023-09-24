export function setCookie (name, value, options) {

  if (options.expires instanceof Date) {
    options.expires = options.expires.toUTCString();
  }
    let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);
    for (let optionKey in options) {
        updatedCookie += "; " + optionKey;
        let optionValue = options[optionKey];
        if (optionValue !== true) {
            updatedCookie += "=" + optionValue;
        }
    }
    document.cookie = updatedCookie;
};
export function getCookie  (name) {
  let matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : null;
}
export function getKeyPlus(){
    return new Date().valueOf() + Math.random();
};
export function reloadPage(){
    document.getElementById('spinner').classList.remove('hidden');
    window.location.reload();
};

export const timeCookieLife = 60 * 20; //second * minutes

export function back() {
    window.history.back();
}

export function reFormat(num) {
    return ('' + num).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1&nbsp;')
};

export const arrPagination = [4, 8, 16, 40, 60, 80, 100];
