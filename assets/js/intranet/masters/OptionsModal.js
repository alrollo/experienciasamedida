const optionsModalId = 'modalEditMasterTable';

export class OptionsModal {
    #masterId = 0;
    #masterName = '';
    #modal = null;
    #options = null;
    #selectorToRefresh = null;

    constructor(masterId, masterName, selectorToRefresh) {
        this.#masterId = masterId;
        this.#masterName = masterName;

        if (selectorToRefresh != null)
            this.#selectorToRefresh = selectorToRefresh;

        this.#init();
    }

    async #init() {
        try {
            this.#options = await this.#getOptions(this.#masterId);
        } catch (e) {
            alert(e.message);
            return;
        }

        this.#modal = $(`#${optionsModalId}`);
        this.#events();
        this.#showModal();
        this.#showReorderScreen();
    }

    async #events() {
        this.#modal.off('click', '#btnAddOption');
        this.#modal.on('click', '#btnAddOption', (e) => {
            e.preventDefault();
            this.#showEditOptionScreen();
        });

        this.#modal.off('click', '.btnEditOption');
        this.#modal.on('click', '.btnEditOption', (e) => {
            e.preventDefault();
            let id = e.currentTarget.dataset.id;
            let option = this.#options.filter((x) => x.id == id);
            if (option.length > 0)
                this.#showEditOptionScreen(option[0]);
        });

        this.#modal.off('click', '#btnBackOption');
        this.#modal.on('click', '#btnBackOption', (e) => {
            e.preventDefault();
            this.#showReorderScreen();
        });

        this.#modal.off('click', '#btnSaveOption');
        this.#modal.on('click', '#btnSaveOption', (e) => {
            e.preventDefault();
            this.#saveOption();
        });

        this.#modal.off('click', '.btnDeleteOption');
        this.#modal.on('click', '.btnDeleteOption', (e) => {
            e.preventDefault();

            if (confirm('¿Quieres borrar el elemento? \r\nLa acción no podrá deshacerse') == false)
                return;

            let id = e.currentTarget.dataset.id;
            if (id != null)
                this.#deleteOption(id);
        });
    }

    async #getOptions() {
        const request = await fetch(`/intranet/masters/${this.#masterId}/options`, {
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

    async #saveOption() {
        let data = {};
        data.id = this.#modal.find('#id').val();
        data.option = {};
        common.Languages.forEach((lang) => {
            data.option[lang] = this.#modal.find(`#option_${lang}`).val();
        })

        const request = await fetch(`/intranet/masters/${this.#masterId}/options`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });

        if (request.status === 200) {
            try {
                this.#options = await this.#getOptions(this.#masterId);
                this.#checkRefresh();

                this.#showReorderScreen();
                return;
            } catch (e) {
                throw 'Ha ocurrido un error al guardar la información de la Tabla Maestra, contacta con el administrador'
            }
        }
        throw 'Ha ocurrido un error al guardar la información de la Tabla Maestra, contacta con el administrador'
    }

    async #deleteOption(id) {
        const request = await fetch(`/intranet/masters/${this.#masterId}/options/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (request.status === 200) {
            try {
                this.#options = await this.#getOptions(this.#masterId);

                this.#checkRefresh();
                this.#showReorderScreen();
                return;
            } catch (e) {
                throw 'Ha ocurrido un error al guardar la información de la Tabla Maestra, contacta con el administrador'
            }
        }
        throw 'Ha ocurrido un error al guardar la información de la Tabla Maestra, contacta con el administrador'
    }

    async #setOrder(order) {
        let data = {};
        data.order = order

        const request = await fetch(`/intranet/masters/${this.#masterId}/options/order`, {
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

        this.#options = await this.#getOptions(this.#masterId);
        this.#showReorderScreen();
        throw 'Ha ocurrido un error al guardar la información de la Tabla Maestra, contacta con el administrador'
    }

    #checkRefresh() {
        if (this.#selectorToRefresh == null)
            return;

        $(document).find(this.#selectorToRefresh).each((index, item) => {
            let value = $(item).val();
            $(item).find('option:not(:first)').remove();
            this.#options.forEach(x => {
                $(item).append($('<option>', {
                    value: x.id,
                    text: x.option.es
                }));
            })
            $(item).val(value);
        })

        console.log('actualizamos');
    }

    #showEditOptionScreen(option) {
        if (option == null) {
            option = {};
            option.id = 0;
            option.option = {};

            common.Languages.forEach((lang) => {
                option.option[lang] = '';
            })
        }

        let html = $('#handlebars-TablaMaestraEditOption').html();
        var template = Handlebars.compile(html);

        this.#modal.find('.modal-body').html(template(option));
    }

    #showReorderScreen() {
        let html = $('#handlerbas-TablaMestraMain').html();
        let template = Handlebars.compile(html);
        let model = {};
        model.name = this.#masterName;
        model.options = this.#options || [];

        this.#modal.find('.modal-body').html(template(model));

        sortable('#optionsContainer', {
            forcePlaceholderSize: true,
            placeholder: '<div style="text-align:center; line-height: 38px; background: #efefef;">Arrastra para reordenar las opciones</div>',
            handle: '.moveable'
        })[0].addEventListener('sortupdate', (e) => {
            var order = sortable('#optionsContainer', 'serialize')[0].items.map(function (val) {
                return $(val.html).data('id');
            });

            this.#setOrder(order);
        })
    }

    #showModal() {
        this.#modal.modal('show');
    }
}
