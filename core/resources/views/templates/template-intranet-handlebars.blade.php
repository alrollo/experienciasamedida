<!-- REGION TABLAS MAESTRAS -->
<script type="text/x-handlebars-template" id="handlerbas-TablaMestraMain">
    <div class="d-inline-block w-100">
        <div class="float-left">@{{ this.name }}</div>
        <div class="float-right"><a href="#" id="btnAddOption" class="btn btn-outline-secondary"><i class="fas fa-plus"></i> Añadir Opción</a></div>
    </div>
    <div id="optionsContainer">
        @{{#each this.options}}
        <div class="moduleItem" data-id="@{{ this.id }}">
            <div class="input-group mb-1">
                <div class="input-group-prepend moveable">
                    <span class="input-group-text"><i class="fa fa-bars"></i></span>
                </div>
                <span class="form-control">@{{ this.option.es }}</span>
                <div class="input-group-append">
                    <a class="btn btn-outline-secondary btnEditOption" href="#" data-id="@{{ this.id }}"><i class="fas fa-pencil-alt"></i></a>
                    <a class="btn btn-outline-secondary btnDeleteOption" href="#" data-id="@{{ this.id }}"><i class="far fa-trash-alt"></i></a>
                </div>
            </div>
        </div>
        @{{/each}}
    </div>
</script>

<script type="text/x-handlebars-template" id="handlebars-TablaMaestraEditOption">
    <input type="hidden" id="id" value="@{{ this.id}}"/>

    @foreach(Language::GetArray() as $language)
    <div class="moduleItem">
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text"><div class="fflag fflag-{{ strtoupper($language) }} ff-sm" title="{{ $language }}"></div></span>
            </div>
            <input type="text" class="form-control" id="option_{{ $language }}" value='@{{lookup this.option @json($language)}}' placeholder="Opción..."/>
        </div>
    </div>
    @endforeach

    <div class="text-right">
        <a class="btn btn-secondary" id="btnBackOption" href="#">Volver</a>
        <a class="btn btn-primary" id="btnSaveOption" href="#" data-id="@{{ this.id }}">Guardar</a>
    </div>
</script>
<!-- REGION TABLAS MAESTRAS -->

<!-- REGION UPLOADER -->
<script type="text/x-handlebars-template" id="handlerbas-ImageUploadedTemplate">
    <div class="col-12 col-md-2 file-entity">
        <div class="image-entity">
            <div class="image-container">
                <a href="{{ asset('storage') }}/@{{ model }}/@{{ attachable_id }}/@{{ file_name }}" target="_blank"><img src="{{ asset('storage') }}/@{{ model }}/@{{ attachable_id }}/@{{ file_name }}" class="img-fluid"></a>
            </div>
            <div class="buttons-container">
                <a href="#" clasS="btn btn-default btn-flat pull-left moveable"><i class="fa fa-bars"></i></a>
                <a href="#" class="btn btn-default btn-flat" data-toggle="popover" title="Información" data-content="@{{ file_name }} (@{{ file_size }})" data-trigger="focus"><i class="fas fa-fw fa-info"></i></a>
                @can(['general.edit_files'])
                    <a href="#" class="btn btn-default btn-flat btnEditFile" data-id="@{{ id }}"><i class="far fa-fw fa-edit"></i></a>
                @endcan
                @can(['general.delete_files'])
                    <a href="#" class="btn btn-default btn-flat btnDeleteImageFromGallery" data-id="@{{ id }}"><i class="far fa-fw fa-trash-alt"></i></a>
                @endcan
            </div>
        </div>
    </div>
</script>

<script type="text/x-handlebars-template" id="handlerbas-FileUploadedTemplate">
    <tr class="file-entity">
        <td><a href="#" clasS="btn btn-default btn-flat pull-left moveable"><i class="fa fa-bars"></i></a></td>
        <td>@{{ file_name }}</td>
        <td>@{{ file_size }}</td>
        <td>
            @can(['general.edit_files'])
                <a href="#" class="btn btn-default btn-flat btnEditFile" data-id="@{{ id }}"><i class="far fa-fw fa-edit"></i></a>
            @endcan
            @can(['general.delete_files'])
                <a href="#" class="btn btn-default btn-flat btnDeleteFile" data-id="@{{ id }}"><i class="far fa-fw fa-trash-alt"></i></a>
            @endcan
        </td>
    </tr>
</script>
<!-- REGION UPLOADER -->

<!-- REGION EDIT FILE -->
<script type="text/x-handlebars-template" id="handlerbas-EditFileTemplate">
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTabFileModal" role="tablist">
                @foreach(Language::GetArray() as $language)
                <li class="nav-item">
                    <a class="nav-link @if($loop->first) active @endif" id="contenidoFileModal-{{ $language }}-tab" data-toggle="tab" href="#contenidoFileModal-{{ $language }}" role="tab">
                        <div class="fflag fflag-{{ strtoupper($language) }} ff-sm" title="{{ $language }}"></div>
                    </a>
                </li>
                @endforeach
            </ul>
            <div class="tab-content" id="myTabFileModalContent">
                @foreach(Language::GetArray() as $language)
                <div class="tab-pane tab-pane-bordered fade @if($loop->first) active show @endif" id="contenidoFileModal-{{ $language }}" role="tabpanel">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" id="name_{{ $language }}" class="form-control" placeholder="Título" value="@{{lookup this.name @json($language)}}">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label>Descripción </label>
                            <textarea id="description_{{ $language }}" class="form-control" rows="4" placeholder="Título">@{{lookup this.description @json($language)}}</textarea>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="text-right mt-3">
                <a class="btn btn-primary" id="btnSave" href="#">Guardar</a>
            </div>
        </div>
    </div>
</script>
<!-- REGION EDIT FILE -->

<!-- REGION FTP -->
<script type="text/x-handlebars-template" id="handlerbas-FtpFileList">
    <tr>
        <td><a href="#">@{{ this.file_name }}</a></td>
        <td>@{{ this.file_type }}</td>
        <td>@{{ this.file_size }}</td>
        <td>
            <div class="btn-group btn-group-sm" role="group">
                <button class="btn btn-light btnCopy" data-id="@{{ this.id }}"><i class="fas fa-copy"></i></button>
                <button class="btn btn-light btnPaste" data-id="@{{ this.id }}"><i class="fas fa-paste"></i></button>
                @can(['ftp.delete'])
                    <button class="btn btn-light btnDelete" data-id="@{{ this.id }}"><i class="fas fa-trash"></i></button>
                @endcan
            </div>
        </td>
    </tr>
</script>
<!-- REGION FTP -->
