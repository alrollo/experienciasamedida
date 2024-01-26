
class GyAHotKeys {
    #hotkeys = [];

    constructor() {
        this.#init();
        this.#events();
    }

    #init() {
        // get list of hotkeys
        const hotkeys = document.querySelectorAll("a[data-hotkey]");
        hotkeys.forEach((hotkey) => {
            let keys = hotkey.dataset.hotkey.split(';')
            keys.forEach((key) => {
                let hotKeyToAdd = {
                    key: key,
                    href: hotkey.href
                }
                this.#hotkeys.push(hotKeyToAdd);
            });
        });
    }

    #events() {
        document.addEventListener("keydown", (event) => {
            if (this.#hotkeys.length == 0)
                return;

            let keys = this.#hotkeys.map(a => a.key);
            if (event.altKey && keys.includes(event.key)) {
                let hotkeyPressed = this.#hotkeys.find(x => x.key == event.key);
                if (hotkeyPressed)
                    window.location = hotkeyPressed.href;
            }
        });
    }
}

new GyAHotKeys();