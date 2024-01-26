<div id="seoContainer">
    <div class="container">
        <form id="seoForm">
            <input type="hidden" name="url" value="{{ request()->path() }}">
            <div class="row">
                <div class="col-xs-2">URL Seo: </div>
                <div clasS="col-xs-10">{{ request()->path() }}</div>
            </div>

            <div class="row">
                <div class="col-xs-2">Title Seo:</div>
                <div class="col-xs-10"><input type="text" name="title" class="form-control" placeholder="Title..." value="{{ Seo::Get()->title }}" /></div>
            </div>
            <div class="row">
                <div class="col-xs-2">Description Seo:</div>
                <div class="col-xs-10"><textarea name="description" class="form-control" placeholder="Description...">{{ Seo::Get()->description }}</textarea></div>
            </div>
            <div class="row">
                <div class="col-xs-2">Keywords Seo:</div>
                <div class="col-xs-10"><textarea name="keywords" class="form-control" placeholder="Keywords...">{{ Seo::Get()->keywords }}</textarea></div>
            </div>

            <div class="row">
                <div class="col-xs-12 text-right">

                    <button type="button" id="btnBorrarSeo" class="btn btn-default">Borrar</button>
                    <button type="button" id="btnGuardarSeo" class="btn btn-default">Guardar</button>

                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('btnBorrarSeo').addEventListener('click', function() {
            if (confirm('¿Deseas eliminar la información SEO de esta URL?\r\nLa acción no podrá deshacerse.')) {
                const form = document.getElementById('seoForm');
                const formData = new FormData(form);
                const plainFormData = {};

                for (const [key, value] of formData.entries()) {
                    plainFormData[key] = value;
                }

                const jsonData = JSON.stringify(plainFormData);

                fetch('/intranet/seo', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: jsonData
                })
                    .then(function(response) {
                        if (response.ok) {
                            alert('Información actualizada');
                        } else {
                            alert('No se ha podido realizar la acción');
                        }
                    })
                    .catch(function(error) {
                        console.error(error);
                        alert('No se ha podido realizar la acción');
                    });
            }
        });

        document.getElementById('btnGuardarSeo').addEventListener('click', function() {
            const form = document.getElementById('seoForm');
            const formData = new FormData(form);
            const plainFormData = {};

            for (const [key, value] of formData.entries()) {
                plainFormData[key] = value;
            }

            const jsonData = JSON.stringify(plainFormData)

            fetch('/intranet/seo', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: jsonData
            })
                .then(function(response) {
                    if (response.ok) {
                        alert('Información actualizada');
                    } else {
                        alert('No se ha podido realizar la acción');
                    }
                })
                .catch(function(error) {
                    console.error(error);
                    alert('No se ha podido realizar la acción');
                });
        });
    });
</script>
