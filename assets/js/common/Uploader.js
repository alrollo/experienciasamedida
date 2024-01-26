export class Uploader {
    #uploader = null;
    #defaults = null;

    constructor(defaults) {
        this.#defaults = defaults;
        this.#config();
    }

    #getSetting(key, defaultValue) {
        if (this.#defaults == null || this.#defaults[key] == null)
            return defaultValue;

        return this.#defaults[key];
    }

    init() {
        if (this.#uploader == null)
            throw new Error('`uploader` is null or empty');
        this.#uploader.init();

    }

    #config() {
        this.#uploader = new plupload.Uploader({
            runtimes: 'html5',
            browse_button: this.#getSetting('browse_button', 'btnAddImageProfile'),
            container: document.getElementById(this.#getSetting('container', 'imageContainer')),
            filters: {
                max_file_size: this.#getSetting('filters.max_file_size', '4mb'),
                mime_types: this.#getSetting('filters.mime_types', [{ title: "Image files", extensions: "jpg" }]),
            },
            resize: {
                width: this.#getSetting('resize.width', 1280),
                height: this.#getSetting('resize.height', 1280),
            },
            multi_selection: this.#getSetting('multi_selection', false),
            unique_names: this.#getSetting('unique_names', true),
            chunk_size : this.#getSetting('chunk_size', '500kb'),
            url: this.#getSetting('url', '/common/upload-file-temp'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            multipart_params: this.#getSetting('multipart_params', {}),
            init: {
                FilesAdded: this.#getSetting('init.FilesAdded', (up, files) => {}),
                UploadComplete: this.#getSetting('init.UploadComplete', (up, files) => {}),
                FileUploaded: this.#getSetting('init.FileUploaded', (up, file, info) => {}),
                Error: this.#getSetting('init.Error', (up, err) => { console.log(err.code + ":" + err.message); alert(err.message); })
            }
        });
    }
}
