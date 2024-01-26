import {UploadModal} from "../../common/UploadModal.js";

export class CustomerFormModule {
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
            let model = 'customer';
            let options = {
                type: 'image',
                id: this.#id,
                model: 'customer',
                mime_types: [
                    { title: 'Imágenes', extensions: 'jpg' }
                ]
            };

            let uploadModal = new UploadModal(id, model, options, this.#imageUploaded);
        });

        $(document).on('click', '.btnUploadFiles', (e) => {
            e.preventDefault();
            let id = this.#id;
            let model = 'customer';
            let options = {
                type: 'doc',
                id: this.#id,
                model: 'customer',
                mime_types: [
                    { title: 'Documentos', extensions: 'doc,docx,pdf,zip,rar' }
                ]
            };

            let uploadModal = new UploadModal(id, model, options, this.#fileUploaded);
        });

        $(document).on('click', '#btnAddPhone', (e) => {
            e.preventDefault();

            let modalAddPhone = new CustomerAddPhone(this.#id);
        });

        $(document).on('click', '.btnDeletePhone', async (e) => {
            e.preventDefault();
            let obj = $(e.currentTarget);

            if (confirm('¿Quieres borrar el elemento? \r\nLa acción no podrá deshacerse') == false)
                return;

            let id = e.currentTarget.dataset.id;
            if (id != null) {
                try {
                    let deleted = await this.#deletePhone(id);
                    if (deleted)
                        obj.parents('tr').remove();
                }
                catch(err) {
                    alert(err);
                }
            }
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

    async #deletePhone(id) {
        const request = await fetch(`/intranet/customers/${this.#id}/delete-phone/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (request.status === 200)
            return true;

        throw 'Ha ocurrido un error al eliminar el teléfono, contacta con el administrador'
    }
}

export const customerFormModuleInstance = new CustomerFormModule();

class CustomerAddPhone {
    #modal = null;
    #customerId = null;

    constructor(customerId) {
        this.#customerId = customerId;
        this.#init();
    }

    async #init() {
        this.#modal = $(`#modalAddPhone`);
        this.#modal.modal('show');
        this.#events();
    }

    async #events() {
        this.#modal.off('click', '#btnSave');
        this.#modal.on('click', '#btnSave', async (e) => {
            e.preventDefault();
            let phone = await this.#savePhone();

            $('#phonesContainer').append(`<tr>
                    <td style="width: 150px;"><a href="tel:">${phone.full_phone}</a></td>
                    <td>${phone.description}</td>
                    <td style="width: 50px;" class="text-right">
                        <button type="button" class="btn btn-default btn-sm btnDeletePhone" data-id="${phone.id}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>`);

            this.#modal.modal('hide');
        });
    }

    async #savePhone() {
        let data = {};
        data.prefix = this.#modal.find('#prefix').val();
        data.phone = this.#modal.find('#phone').val();
        data.description = this.#modal.find('#description').val();

        const request = await fetch(`/intranet/customers/${this.#customerId}/add-phone`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });

        if (request.status === 200) {
            try {
                return await request.json();
            } catch (e) {
                throw 'Ha ocurrido un error al guardar el teléfono, contacta con el administrador'
            }
        }
        throw 'Ha ocurrido un error al guardar el teléfono, contacta con el administrador'
    }
}
