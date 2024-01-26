export class ModuleFormModule {
    #id = 0;

    constructor() {
        this.#initSummernote();
        this.#id = $('#id').val();
    }


    #initSummernote() {
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
        $('.summernote').summernote({
            height: 150,   //set editable area's height
            codemirror: { // codemirror options
                theme: 'monokai'
            },
            toolbar: [
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
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

        $('.summernote').on('summernote.paste', function(e) {

        });
    }
}

export const moduleFormModuleInstance = new ModuleFormModule();
