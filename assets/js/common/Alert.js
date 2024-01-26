export class Alert {

    constructor(type, title, content) {
        $(document).Toasts('create', {
            class: `bg-${this.#getTypeClass(type)}`,
            title: title,
            body: content,
            autohide: true,
            delay: 3000
        });
    }

    #getTypeClass(type) {
        switch (type) {
            case AlertType.Success:
                return 'success';
            case AlertType.Danger:
                return 'danger';
            case AlertType.Warning:
                return 'warning';
            default:
            case AlertType.Info:
                return "info";
        }
    }
}

export const AlertType = {
    Success: "success",
    Danger: "danger",
    Warning: "warning",
    Info: "info"
}
