import { Alert, AlertType} from '../../common/Alert.js'

export class Ftp {
    #modal = null;
    #summernote = null;
    #table = null;
    #uploader = null;
    #files = null;

    constructor() {
        this.#modal = $(`#modalAdminFiles`);
        this.#table = this.#modal.find('#tableFiles');

        this.#events();
        this.#initUploader();
    }

    async Show(el) {
        this.#summernote = el;

        this.#listFiles();
        this.#showModal();
    }

    async #events() {
        this.#modal.on('click', '.btnCopy', (e) => {
            e.preventDefault();

            let id = e.currentTarget.dataset.id;
            let file = this.#getLocalFile(id);
            if (file) {
                try {
                    navigator.clipboard.writeText(file.url);
                    new Alert(AlertType.Success, 'Información', 'Link copiad al portapapeles');
                } catch (e) {
                    new Alert(AlertType.Danger, 'Error', 'No se ha podido completar la acción');
                }
            }
        });

        this.#modal.on('click', '.btnPaste', (e) => {
            e.preventDefault();

            let id = e.currentTarget.dataset.id;
            let file = this.#getLocalFile(id);
            if (file) {
                let imageTypes = ['image/jpeg'];

                let strToInclude = '';
                if (imageTypes.includes(file.file_type)) {
                    strToInclude = `<img src="${file.url}" />`;
                } else {
                    strToInclude = `<a href="${file.url}" target="_blank">${file.file_name}</a>`;
                }
                this.#summernote.invoke('editor.pasteHTML', strToInclude);
            }
        });

        this.#modal.on('click', '.btnDelete', (e) => {
            e.preventDefault();

            let id = e.currentTarget.dataset.id;
            if (confirm('¿Deseas borrar el archivo?\r\nLa acción no podrá deshacerse y si está vinculado en alguna entidad dejará de ser accesible.'))
                this.#deleteFile(id);
        });

        this.#modal.on('click', '#btnSearch', (e) => {
            e.preventDefault();
            this.#listFiles();
        });
    }

    async #initUploader() {
        this.#uploader = new plupload.Uploader({
            runtimes: 'html5',
            browse_button: 'btnAddFilesFtp',
            container: document.getElementById('modalAdminFiles'),
            url: '/common/upload-file',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            chunk_size: '2mb',
            filters: {
                max_file_size: '10mb',
                mime_types: [
                    { title: "Imágenes", extensions: "jpg,gif,png" },
                    { title: "Documentos", extensions: "pdf" }
                ],
            },
            resize: {
                quality: 90,
                width: 1600,
                height: 1600,
                enabled: true
            },
            multipart_params: {
                'type': 'image',
                'id': '0',
                'model': 'ftp'
            },
            init: {
                Init: (up) => { },
                FilesAdded: (up, files) => {
                    files.forEach((file) => {
                        this.#table.find('tbody').prepend(`<tr><td colspan="4">${file.name}  <span id="${file.id}_percent" class="text-bold">0 %</span></td><tr>`);
                    });

                    this.#uploader.start();
                },
                QueueChanged: (up) => { },
                Browse: (up) => { },
                BeforeUpload: (up, files) => { },
                UploadProgress: (up, file) => {
                    this.#modal.find(`#${file.id}_percent`).text(`${file.percent} %`);
                },
                UploadComplete: (up, files) => {
                    if (confirm('Se han subido los archivos, ¿Quieres recargar la búsqueda?'))
                        this.#listFiles();
                },
                FileUploaded: (up, file, result) => {
                    if (result.status === 200) {
                        let response = JSON.parse(result.response).data;
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
    }

    async #listFiles() {
        this.#table.find('tbody').html('<tr><td colspan="4" class="text-center">Cargando...</td></tr>');
        this.#files = await this.#getFiles();

        if (this.#files.length === 0) {
            this.#table.find('tbody').html('<tr><td colspan="4" class="text-center">No se han encontrado archivos</td>');
        } else {
            this.#table.find('tbody').html('');
            let html = $('#handlerbas-FtpFileList').html();
            let template = Handlebars.compile(html);
            this.#files.forEach(file => {
                this.#table.find('tbody').append(template(file))
            });
        }
    }

    async #getFiles() {
        let data = {};
        data.query = this.#modal.find('#query').val();

        const request = await fetch(`/intranet/ftp`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });

        if (request.status === 200)
            return await request.json();

        throw 'Ha ocurrido un error al obtener la información, contacta con el administrador'
    }

    #getLocalFile(id) {
        let file = this.#files.find(x => x.id == id);
        return file;
    }

    async #deleteFile(id) {
        let data = {};
        data.id = id;

        const request = await fetch(`/intranet/ftp`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });

        if (request.status === 200) {
            this.#listFiles();
            return await request.json();
        }

        throw 'Ha ocurrido un error al obtener la información, contacta con el administrador'
    }

    async #showModal() {
        this.#modal.modal('show');
    }
}
