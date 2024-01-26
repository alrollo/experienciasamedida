export class TranslationGridModule {
    #id = 0;

    constructor() {
        this.#events();
        this.#plugins();
    }

    #events() {
        $(document).on('click', '.btnEditTranslation', (e) => {
            e.preventDefault();
            let id = e.currentTarget.dataset.id;
            this.#editTranslation(id);
        })
    }

    #plugins() {
    }

    async #editTranslation(id) {
        let translation = await this.#getTranslation(id);

        let modal = $(`#modalEditTranslation`);
        modal.modal('show');

        modal.find('textarea').val('');

        if (translation && translation.translation) {
            for (var key in translation.translation) {
                var value = translation.translation[key];

                let inputContainer = modal.find(`#translation_${key}`);
                if (inputContainer.length > 0)
                    inputContainer.val(value);
            }
        }

        $(document).off('click', '#btnSaveTranslation');
        $(document).on('click', '#btnSaveTranslation', async (e) => {
            e.preventDefault();
            const response = await this.#saveTranslation(id);
            if (response) {
                $(`.translation_${response.id}`).html(response.translation.es);
                modal.modal('hide');
            }
        })
    }

    async #saveTranslation(id) {
        const form = document.getElementById('translationForm');
        const formData = new FormData(form);

        formData.append("id", id);
        const request = await fetch(`/intranet/translations/xhr`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        if (request.status === 200) {
            const response = await request.json();

            return response;
        }
    }

    async #getTranslation(id) {
        const request = await fetch(`/intranet/translations/xhr/${id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (request.status === 200)
            return await request.json();

        throw 'Ha ocurrido un error al obtener la información de la Tabla Maestra, contacta con el administrador'
    }
}

export const translateGridModuleInstance = new TranslationGridModule();

