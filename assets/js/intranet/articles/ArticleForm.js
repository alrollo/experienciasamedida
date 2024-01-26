import {UploadModal} from "../../common/UploadModal.js";

export class ArticleFormModule {
    #id = 0;

    constructor() {
        this.#events();
        this.#plugins();

        this.#id = $('#id').val();
    }

    #events() {
        $(document).on('click', '.btnUploadImages', (e) => {
            e.preventDefault();
            let id = this.#id;
            let model = 'Article';
            let options = {
                type: 'image',
                id: this.#id,
                model: 'Article',
                mime_types: [
                    { title: 'Imágenes', extensions: 'jpg' }
                ]
            };

            let uploadModal = new UploadModal(id, model, options, this.#imageUploaded);
        });

        $(document).on('click', '.btnUploadFiles', (e) => {
            e.preventDefault();
            let id = this.#id;
            let model = 'Article';
            let options = {
                type: 'doc',
                id: this.#id,
                model: 'Article',
                mime_types: [
                    { title: 'Documentos', extensions: 'doc,docx,pdf,zip,rar' }
                ]
            };

            let uploadModal = new UploadModal(id, model, options, this.#fileUploaded);
        });

    }

    #plugins() {
        sortable('#imagesContainer', {
            forcePlaceholderSize: true,
            placeholder: '<div class="col-12 col-md-2 imagesContainerMoving"><div>Arrastra</div></div>',
            handle: '.moveable'
        })[0].addEventListener('sortupdate', (e) => {
            var order = sortable('#imagesContainer', 'serialize')[0].items.map(function (val) {
                return $(val.html).data('id');
            });

            this.#setFileOrder(order);
        });

        sortable('#filesContainer', {
            forcePlaceholderSize: true,
            placeholder: '<tr class="file-entity filesContainerMoving"><td colspan="4" class="text-center align-middle">Arrastra</td></tr>',
            handle: '.moveable'
        })[0].addEventListener('sortupdate', (e) => {
            var order = sortable('#filesContainer', 'serialize')[0].items.map(function (val) {
                return $(val.html).data('id');
            });

            this.#setFileOrder(order);
        });
    }

    async #setFileOrder(order) {
        let data = {};
        data.order = order

        const request = await fetch(`/intranet/files/${this.#id}/order`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });

        if (request.status === 200) {
            return;
        }

        throw 'Ha ocurrido un error al guardar la información de la Tabla Maestra, contacta con el administrador'
    }

    #imageUploaded(data) {
        let templateHtml = $('#handlerbas-ImageUploadedTemplate').html();
        let template = Handlebars.compile(templateHtml);
        $('#imagesContainer').append(template(data));
    }

    #fileUploaded(data) {
        debugger;
        let templateHtml = $('#handlerbas-FileUploadedTemplate').html();
        let template = Handlebars.compile(templateHtml);
        $('#filesContainer').append(template(data));
    }
}

export const articleFormModuleInstance = new ArticleFormModule();

