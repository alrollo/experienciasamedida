export class TranslationFormModule {
    #id = 0;

    constructor() {
        this.#events();
        this.#plugins();
        this.#id = $('#id').val();
    }

    #events() {
    }

    #plugins() {
    }
}

export const translateFormModuleInstance = new TranslationFormModule();

