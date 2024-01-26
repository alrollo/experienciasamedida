
class GyAAccesibility {
    #cookieName = 'gya_accesibility';

    #cookieContent = {
        highcontrast: false,
        zoom: false,
        underline: false,
        grayscale: false
    }

    constructor() {
        if (window.gyaCookiesManager == null)
            throw new Error('`GyaCookiesManager` is undefined or null');

        this.#addCss();

        this.#init();
        this.#showManager();
        this.#events();
    }

    #init() {
        const cookie = gyaCookiesManager.GetCookie('gya_accessibility');

        if (cookie) {
            this.#cookieContent = JSON.parse(cookie);
        }

        for (var key in this.#cookieContent) {
            if (this.#cookieContent.hasOwnProperty(key)) {
                var value = this.#cookieContent[key];
                if (value) {
                    document.body.classList.add(`gya-accessibility-${key}`);
                }
            }
        }
    }

    #events() {
        const botones = document.querySelectorAll('.btnAccessibility');
        botones.forEach((boton) => {
            boton.addEventListener('click', (event) => {
                event.preventDefault();
                event.currentTarget.dataset.toggle = event.currentTarget.dataset.toggle != "true";
                let accessibilityPlugin = event.currentTarget.dataset.accessibility;

                if (accessibilityPlugin == null)
                    return;

                if (event.currentTarget.dataset.toggle == "true") {
                    this.#cookieContent[accessibilityPlugin] = true;
                    document.body.classList.add(`gya-accessibility-${accessibilityPlugin}`);
                } else {
                    this.#cookieContent[accessibilityPlugin] = false;
                    document.body.classList.remove(`gya-accessibility-${accessibilityPlugin}`);
                }

                window.gyaCookiesManager.SetCookie('gya_accessibility', JSON.stringify(this.#cookieContent));
            });
        });

        const btnReset = document.getElementById('btnAccessibilityReset');
        btnReset.addEventListener('click', (event) => {
            event.preventDefault();
            for (var key in this.#cookieContent) {
                this.#cookieContent[key] = false;
                document.body.classList.remove(`gya-accessibility-${key}`);

                const botones = document.querySelectorAll('.btnAccessibility');
                botones.forEach((boton) => {
                    boton.dataset.toggle = false;
                });
            }

            window.gyaCookiesManager.SetCookie('gya_accessibility', JSON.stringify(this.#cookieContent));
        });
    }

    #showManager() {
        const template = `<div id="gya_accesibilityContainer">
            <div><a href="#" data-accessibility="highcontrast" data-toggle="${this.#cookieContent.highcontrast ? 'true' : 'false'}" title="Establecer alto contraste" aria-label="Establecer alto contraste" class="btnAccessibility"><i class="fa fa-fw fa-adjust"></i></a></div>
            <div><a href="#" data-accessibility="zoom" data-toggle="${this.#cookieContent.zoom ? 'true' : 'false'}" id="btnToggleZoom" title="Aumentar tamaño de letra" aria-label="Aumentar tamaño de letra" class="btnAccessibility"><i class="fa fa-fw fa-text-height"></i></a></div>
            <div><a href="#" data-accessibility="underline" data-toggle="${this.#cookieContent.underline ? 'true' : 'false'}" title="Subrayar enlaces" aria-label="Subrayar enlaces" class="btnAccessibility"><i class="fa fa-fw fa-underline"></i></a></div>
            <div><a href="#" data-accessibility="grayscale" data-toggle="${this.#cookieContent.grayscale ? 'true' : 'false'}" title="Establecer escala de grises" aria-label="Establecer escala de grises" class="btnAccessibility"><i class="fa fa-fw fa-barcode"></i></a></div>
            <div><a href="#" title="Restablecer las opciones" aria-label="Restablecer las opciones" id="btnAccessibilityReset"><i class="fa fa-undo"></i></a></div>
        </div>`;

        document.body.insertAdjacentHTML('beforeend', template);
    }

    #addCss() {
        var linkElement = document.createElement("link");
        linkElement.rel = "stylesheet";
        linkElement.type = "text/css";
        linkElement.href = "/assets/plugins/gya_accessibility/accessibility.css";

        document.head.appendChild(linkElement);
    }
}

new GyAAccesibility();