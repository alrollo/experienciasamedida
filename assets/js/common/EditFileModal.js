const editFileModalId = 'modalEditFile';

export class EditFileModal {
    #modal = null;

    #el = null;
    #id = 0;
    #options = null;
    #callback = null;

    constructor(el, options, callback) {
        if (el == null)
            throw "`el` is null or empty";

        this.#el = el;

        this.#id = this.#el.dataset.id;
        if (this.#id == null)
            throw "`data-id` is null or empty"

        this.#options = this.#setOptions(options);
        this.#callback = callback;

        this.#init();
    }

    async #init() {
        this.#modal = $(`#${editFileModalId}`);
        this.#events();

        this.#showModal();
    }

    async #events() {
        this.#modal.off('click', '#btnSave');
        this.#modal.on('click', '#btnSave', (e) => {
            e.preventDefault();
            this.#saveInfo();
        });
    }

    #setOptions(options) {
        const defaultOptions = {
        }

        return {...defaultOptions, ...options};
    }

    async #showModal() {
        let file = null;
        try {
            file = await this.#getFileInfo();
        } catch (e) {
            alert(e.message);
            return;
        }

        if (file == null)
            return;

        let html = $('#handlerbas-EditFileTemplate').html();
        let template = Handlebars.compile(html);

        let data = file;

        this.#modal.find('.modal-body').html(template(data));

        this.#modal.modal('show');
    }

    async #getFileInfo() {
        const request = await fetch(`/intranet/files/${this.#id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (request.status === 200)
            return await request.json();

        throw 'Ha ocurrido un error al obtener la información, contacta con el administrador'
    }

    async #saveInfo() {
        let data = {};
        data.id = this.#id;
        data.name = {};
        data.description = {};
        common.Languages.forEach((lang) => {
            data.name[lang] = this.#modal.find(`#name_${lang}`).val() ?? '';
            data.description[lang] = this.#modal.find(`#description_${lang}`).val() ?? '';
        })

        const request = await fetch(`/intranet/files`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });

        if (request.status === 200) {
            let response = await request.json();
            this.#modal.modal('hide');



            if (this.#callback)
                this.#callback(this.#el.closest('.file-entity'), response);

            return;
        }
        throw 'Ha ocurrido un error al guardar la información, contacta con el administrador'
    }
}

