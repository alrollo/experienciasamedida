<!-- REGION TABLAS MAESTRAS -->
<div class="modal fade" id="modalEditMasterTable" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Editar tabla maestra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!-- REGION TABLAS MAESTRAS -->

<!-- REGION TRANSLATIONS -->
<div class="modal fade" id="modalEditTranslation" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="translationForm">
                @foreach(Language::GetArray() as $lang)
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><div class="fflag fflag-{{ strtoupper($lang) }} ff-sm" title="{{ $lang }}"></div></span>
                            </div>

                            <textarea id="translation_{{$lang}}" name="translation[{{$lang}}]" class="form-control" id="titleInput" placeholder="Traducción" rows="3"></textarea>
                        </div>
                    </div>
                @endforeach
                </form>

                <div class="text-right">
                    <a class="btn btn-primary" id="btnSaveTranslation" href="#">Guardar</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- REGION TRANSLATIONS -->

<!-- REGION UPDATE FILES -->
<div class="modal fade" id="modalUploadImages" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="text-left">
                    <a href="#" class="btn btn-outline-secondary" id="btnAddFiles"><i class="fas fa-plus"></i> Añadir Archivos</a>
                </div>
                <hr>
                <div>
                    <table class="table table-bordered" id="filesAttached">
                        <thead>
                        <tr>
                            <th>Archivo</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- REGION UPDATE FILES -->

<!-- REGION EDIT FILE -->
<div class="modal fade" id="modalEditFile" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Editar información</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!-- REGION EDIT FILE -->

<!-- REGION FTP -->
<div class="modal fade" id="modalAdminFiles" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Administrar archivos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-4">
                        <button type="button" id="btnAddFilesFtp" class="btn btn-primary">Subir archivos</button>
                    </div>
                    <div class="col-8">
                        <div class="input-group">
                            <input type="text" id="query" class="form-control" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="buttonBuscar">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="btnSearch"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">

                        <table id="tableFiles" class="table table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>Archivo</th>
                                <th style="width: 150px">Tipo</th>
                                <th style="width: 100px">Tamaño</th>
                                <th style="width: 100px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><a href="#" class="fileSelectable">mifoto.jpg</a></td>
                                <td>image/jpeg</td>
                                <td>231 kb</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-light btnCopy"><i class="fas fa-copy"></i></button>
                                        <button class="btn btn-light btnPaste"><i class="fas fa-paste"></i></button>
                                        <button class="btn btn-light btnDelete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- REGION FTP -->
