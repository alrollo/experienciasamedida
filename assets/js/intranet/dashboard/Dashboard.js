import { Alert, AlertType} from '../../common/Alert.js'

export class DashboardModule {
    constructor() {
        this.#events();
    }

    #events() {
        $('#btnVaciarCacheVistas').on('click', async (e) => {
            const request = await fetch('/intranet/utils/clear-views-cache');

            if (request.status === 200) {
                const response = await request.json();
                new Alert(AlertType.Success, 'Información', response.message);
                return;
            }

            new Alert(AlertType.Danger, 'Error', 'No se ha podido completar la acción');
        });

        $('#btnVaciarCache').on('click', async (e) => {
            const request = await fetch('/intranet/utils/clear-cache');

            if (request.status === 200) {
                const response = await request.json();
                new Alert(AlertType.Success, 'Información', response.message);
                return;
            }

            new Alert(AlertType.Danger, 'Error', 'No se ha podido completar la acción');
        });

        $('#btnCrearLinkStorage').on('click', async (e) => {
            const request = await fetch('/intranet/utils/create-link-storage');

            if (request.status === 200) {
                const response = await request.json();
                new Alert(AlertType.Success, 'Información', response.message);
                return;
            }

            new Alert(AlertType.Danger, 'Error', 'No se ha podido completar la acción');
        });

        $('#btnEmptyTempFolder').on('click', async (e) => {
            if (confirm('¿Quieres elimnar los archivos de las carpetas temporales?')) {
                const request = await fetch('/intranet/utils/empty-temp-folders');

                if (request.status === 200) {
                    const response = await request.json();
                    new Alert(AlertType.Success, 'Información', response.message);
                    return;
                }

                new Alert(AlertType.Danger, 'Error', 'No se ha podido completar la acción');
            }
        })
    }
}

export const dashboardModuleInstance = new DashboardModule();
