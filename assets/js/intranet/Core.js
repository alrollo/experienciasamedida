import {OptionsModal} from "./masters/OptionsModal.js";
import {EditFileModal} from "../common/EditFileModal.js";
import {Ftp} from "./ftp/Ftp.js";

export class Core {
    constructor() {
        this.#events();

        this.#plugins();
    }

    get Host() { return `${window.location.protocol}//${window.location.host}/`};

    #events() {
        $(document).on('change', '#selectAll', (e) => {
            if (e.currentTarget.checked) {
                $(e.currentTarget).parents('table').find('.selectOne').prop('checked', true)
            } else {
                $(e.currentTarget).parents('table').find('.selectOne').prop('checked', false)
            }
        })

        $(document).on('click', '.btnDelete', (e) => {
           return confirm('¿Quieres borrar el elemento? \r\nLa acción no podrá deshacerse')
        });

        $(document).on('click', '.btnAdminMasterOptions', (e) => {
            e.preventDefault();
            let id = e.currentTarget.dataset.id;
            let name = e.currentTarget.dataset.name;
            let selectorToRefresh = e.currentTarget.dataset.selectortorefresh;
            let optionsModal = new OptionsModal(id, name, selectorToRefresh);
        })

        $(document).on('click', '.btnEditImage', (e) => {
            e.preventDefault();
            let id = e.currentTarget.dataset.id;
            new EditFileModal(e.currentTarget, {});
        });

        $(document).on('click', '.btnEditFile', (e) => {
            e.preventDefault();
            let id = e.currentTarget.dataset.id;
            new EditFileModal(e.currentTarget, {}, this.#updateFileInfo);
        });

        $(document).on('click', '.btnDeleteFile', async (e) => {
            e.preventDefault();
            let id = e.currentTarget.dataset.id;
            let parent = $(e.currentTarget).parents('.file-entity');
            if (id == 0)
                return;

            if (confirm('¿Quieres borrar el archivo? \r\nLa acción no podrá deshacerse')) {
                const request = await fetch(`/intranet/files/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (request.status === 200) {
                    try {
                        $(parent).remove();
                        return;
                    } catch (e) {
                        throw 'Ha ocurrido un error al eliminar, contacta con el administrador'
                    }
                }
                throw 'Ha ocurrido un error al eliminar, contacta con el administrador'
            }
        });

        $(document).on('click', '.btnDeleteImage', async (e) => {
            e.preventDefault();
            let id = e.currentTarget.dataset.id;
            let parent = $(e.currentTarget).parents('.file-entity');

            if (id == 0)
                return;

            if (confirm('¿Quieres borrar el archivo? \r\nLa acción no podrá deshacerse')) {
                const request = await fetch(`/intranet/files/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (request.status === 200) {
                    try {
                        $(parent).find('.btnDeleteImage').attr('data-id', 0);
                        $(parent).find('.btnEditFile').attr('data-id', 0);
                        $(parent).find('.btnDeleteImage').hide();
                        $(parent).find('.btnEditFile').hide();
                        $(parent).find('.btnUploadImage').show();

                        $(parent).find('.image-container').html("");
                        $(parent).find('.image-container').append("<img src='/assets/images/no_photo.png' class='img-fluid'/>");
                        return;
                    } catch (e) {
                        throw 'Ha ocurrido un error al eliminar, contacta con el administrador'
                    }
                }
                throw 'Ha ocurrido un error al eliminar, contacta con el administrador'
            }
        });

        $(document).on('click', '.btnDeleteImageFromGallery', async (e) => {
            e.preventDefault();
            let id = e.currentTarget.dataset.id;
            let parent = $(e.currentTarget).parents('.file-entity');

            if (id == 0)
                return;

            if (confirm('¿Quieres borrar el archivo? \r\nLa acción no podrá deshacerse')) {
                const request = await fetch(`/intranet/files/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (request.status === 200) {
                    try {
                        $(parent).remove();
                        return;
                    } catch (e) {
                        throw 'Ha ocurrido un error al eliminar, contacta con el administrador'
                    }
                }
                throw 'Ha ocurrido un error al eliminar, contacta con el administrador'
            }
        });
    }

    #plugins(){
        // Select2 bootstrap
        if ($('.select2').length > 0)
            $('.select2').select2({
                theme: "bootstrap4"
            });

        // Datetime pickers
        $('.datePicker').datetimepicker({
            locale: 'es',
            format: 'L',
            useCurrent: false,
            ignoreReadonly: true,
        });
        $('.datetimePicker').datetimepicker({
            locale: 'es',
            format: 'DD/MM/YYYY HH:mm',
            sideBySide: true,
            useCurrent: false,
            ignoreReadonly: true,
        });


        // Sidebar calendars
        $('#calendarSidebar').datetimepicker({
            format: 'L',
            inline: true,
            locale: 'es'
         });

        $('[data-toggle="popover"]').popover();

        // UploadImages
        if ($('.UploadImage').length > 0) {
            $('.UploadImage').each((index, item) => {
                this.#initUploaderImage(item);
            });
        }

        // Summernote
        if ($('.summernote').length > 0) {
            $('.summernote').each((index, item) => {
                this.#initSummernote(item);
            });
        }
    }

    #initSummernote(item) {
        var FtpButton = function (context) {
            var ui = $.summernote.ui;

            // create button
            var button = ui.button({
                contents: '<i class="fas fa-cloud-upload-alt"></i>',
                tooltip: 'Subir archivo',
                click: function () {
                    //context.invoke('editor.insertText', 'hello');
                    window.ftp.Show(context);
                }
            });

            return button.render();   // return button as jquery object
        }

        // Summernote
        $(item).summernote({
            height: 150,   //set editable area's height
            codemirror: { // codemirror options
                theme: 'monokai'
            },
            toolbar: [
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['style', ['style', 'strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'picture', 'video']],
                ['mybutton', ['ftp']],
                ['view', ['codeview']],
            ],
            buttons: {
                ftp: FtpButton
            }
        });

        $('.summernote').on('summernote.paste', function(e, ne) {

        });
    }

    #initUploaderImage(item) {
        let width = item.dataset.width || 1280;
        let height = item.dataset.height || 1280;
        let tag = item.dataset.tag;
        let model = item.dataset.model;
        let id = item.dataset.id;

        if (!tag || !model || !id) {
            alert('No se puede incilializar el uploader de fotos');
            return;
        }

        let uploader = new plupload.Uploader({
            runtimes: 'html5',
            browse_button: item.querySelector('.btnUploadImage'),
            container: item,
            filters: {
                max_file_size: '4mb',
                mime_types: [{title: "Image files", extensions: "jpg"}],
            },
            resize: {
                width: width,
                height: height,
            },
            multi_selection: false,
            unique_names: true,
            chunk_size: '500kb',
            url: '/common/upload-file',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            multipart_params: {
                'type': 'image',
                'id': id,
                'model': model,
                'tag': tag
            },
            init: {
                FilesAdded: (up, files) => {
                    up.start();
                },
                UploadComplete: (up, files) => {
                },
                FileUploaded: (up, file, result) => {
                    if (result.status === 200) {
                        let response = JSON.parse(result.response).data;
                        let url = `/storage/${model}/${id}/${response.file_name}`;

                        $(item).find('.image-container > img').attr('src', url);

                        $(item).find('.btnDeleteImage').attr('data-id', response.id);
                        $(item).find('.btnEditFile').attr('data-id', response.id);
                        $(item).find('.btnDeleteImage').show();
                        $(item).find('.btnEditFile').show();

                        $(item).find('.btnUploadImage').hide();
                    }
                },
                Error: (up, err) => {
                    let response = JSON.parse(err.response);
                    alert(response.message);
                }
            }
        });
        uploader.init();
     }

    #updateFileInfo(parent, info) {
        const el_name = parent.querySelector('.file-entity-name');
        const el_file_size = parent.querySelector('.file-entity-file_size');

        el_name.innerHTML = info.name.es;
        el_file_size.innerHTML = info.file_size;
    }
}

window.core = new Core();
window.ftp = new Ftp();


Handlebars.registerHelper('toLowerCase', function(str) {
    return str.toLowerCase();
});

Handlebars.registerHelper('toUpperCase', function(str) {
    return str.toUpperCase();
});
