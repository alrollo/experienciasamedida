class GyACookiesManager {
    constructor() {
    }

    SetCookie(name, value) {
        document.cookie = `${name}=${value}; path=/`;
    }

    GetCookie(name) {
        const cookies = document.cookie.split('; ');
        let value = null;

        for (let i = 0; i < cookies.length; i++) {
            const parts = cookies[i].split('=');
            if (parts[0] === name) {
                value = decodeURIComponent(parts[1]);
                break;
            }
        }

        return value;
    }
}

window.gyaCookiesManager = new GyACookiesManager();