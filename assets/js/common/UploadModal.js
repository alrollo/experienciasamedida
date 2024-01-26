const uploadModalId = 'modalUploadImages';


export class UploadModal {
    #modal = null;
    #uploader = null;

    #id = 0;
    #model = null;
    #options = null;
    #callback = null;

    constructor(id, model, options, callback) {
        if (model == null || id == null)
            throw "`model` or `id` are null or empty";

        this.#id = id;
        this.#model = model;
        this.#options = this.#setOptions(options);
        this.#callback = callback;

        this.#init();
    }

    async #init() {
        this.#modal = $(`#${uploadModalId}`);
        this.#modal.find('#filesAttached tbody').html('');

        this.#events();
        this.#initUploader();
        this.#showModal();
    }

    async #events() {
        this.#modal.off('hidden.bs.modal')
        this.#modal.on('hidden.bs.modal', (e) => {
            if (this.#uploader)
               this.#uploader.destroy();
        });
    }

    #setOptions(options) {
        const defaultOptions = {
            resize: {
                quality: 90,
                width: 1600,
                height: 1600,
                enabled: true
            }
        }

        return {...defaultOptions, ...options};
    }

    async #initUploader() {
        this.#uploader = new plupload.Uploader({
            runtimes: 'html5',
            browse_button: 'btnAddFiles',
            container: document.getElementById(`${uploadModalId}`),
            url: '/common/upload-file',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            chunk_size: '2mb',
            filters: {
                max_file_size: '10mb',
                mime_types: this.#options.mime_types,
            },
            multipart_params: {
                'type': this.#options.type,
                'id': this.#options.id,
                'model': this.#options.model
            },
            init: {
                Init: (up) => { },
                FilesAdded: (up, files) => {
                    files.forEach((file) => {
                        this.#modal.find('#filesAttached tbody').append(`<tr data-id="${file.id}"><td>${file.name} - <span id="${file.id}_percent" class="text-bold">0 %</span></td></tr>`);
                    });

                    this.#uploader.start();
                },
                QueueChanged: (up) => { },
                Browse: (up) => { },
                BeforeUpload: (up, files) => {
                    // Añadimos la redimension si está configurada
                    if (this.#options.resize != null)
                        up.setOption('resize', this.#options.resize);
                },
                UploadProgress: (up, file) => {
                    this.#modal.find(`#${file.id}_percent`).text(`${file.percent} %`);
                },
                UploadComplete: (up, files) => { },
                FileUploaded: (up, file, result) => {
                    if (result.status === 200) {
                        let response = JSON.parse(result.response).data;

                        // Add `model` attribute to object
                        const modelArray = response.attachable_type.split("\\");
                        response.model = modelArray.pop().toLowerCase();

                        this.#callback(response);
                    }
                },
                Error: (up, err) =>  {
                    let response = JSON.parse(err.response);
                    this.#modal.find(`#${err.file.id}_percent`).addClass('text-danger');
                    this.#modal.find(`#${err.file.id}_percent`).html(response.message);
                }
            }
        });
        this.#uploader.init();
        console.log(this.#uploader);
    }

    #showModal() {
        this.#modal.modal('show');
    }
}
