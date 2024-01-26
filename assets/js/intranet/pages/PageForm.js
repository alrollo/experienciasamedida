import { Alert, AlertType } from "../../common/Alert.js";

export class PageFormModule {

    #id = 0;

    constructor() {
        this.#events();
        this.#plugins();

        this.#id = $('#id').val();
    }

    #events() {
        $(document).on('click', '#btnAddUrl', (e) => {
            e.preventDefault();
            this.#addUrl();
        })

        $(document).on('click', '.btnDeleteUrl', (e) => {
            e.preventDefault();
            $(e.currentTarget).parents('.urlContainer').remove();
        });
        document.getElementById('modulesContainer').addEventListener('sortupdate', async (e, ui) => {
            let order = [];
            for (let i = 0; i < e.target.children.length; i++) {
                order.push(e.target.children[i].dataset.id);
            }

            let data = {};
            data.order = order

            const request = await fetch(`/intranet/pages/${this.#id}/modules/sort`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });

            if (request.status === 200) {
                const response = await request.json();
                new Alert(AlertType.Success, 'Información', response.message);
                return;
            }

            new Alert(AlertType.Danger, 'Error', 'No se ha podido estblecer el orden indicado');
        });
    }

    #plugins() {

    }

    #addUrl() {
        const template = `
            <div class="input-group mb-3 urlContainer">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">${core.Host}</span>
                </div>
                <input type="text" name="url[]" class="form-control" id="roleInput" placeholder="URL" value="">
                <div class="input-group-append">
                    <a class="btn btn-outline-secondary btnDeleteUrl" href="#" ><i class="far fa-trash-alt"></i></a>
                </div>
            </div>`;

        $(document).find('#urlsContainer').append(template);
    }
}

export const pageFormModuleInstance = new PageFormModule();
