import { Uploader } from "../../common/Uploader.js";

export class UsuarioFormModule {

    constructor() {
        this.#events();
        this.#plugins();
    }

    #events() {
    }

    #plugins() {
        console.log('init plugins');
        this.#initImageProfile();
    }

    #initImageProfile() {
        let imageUploadDefaults = {};
        imageUploadDefaults['browse_button'] = 'btnAddImageProfile';
        imageUploadDefaults['container'] = 'imageProfileContainer';
        imageUploadDefaults['resize.width'] = 640;
        imageUploadDefaults['resize.height'] = 640;
        imageUploadDefaults['init.FilesAdded'] = (up, files) => { up.start(); }
        imageUploadDefaults['init.UploadComplete'] = (up, files) => { }
        imageUploadDefaults['init.FileUploaded'] = (up, file, info) => {
            if (info.status != 200)
                return;

            let response = JSON.parse(info.response);
            $('#imageProfile').val(response.data.name);
            $('#imageProfileImg').attr('src', response.data.url);
        };


        let imageUpload = new Uploader(imageUploadDefaults);
        imageUpload.init();
    }
}

const usuarioFormModuleInstance = new UsuarioFormModule();
