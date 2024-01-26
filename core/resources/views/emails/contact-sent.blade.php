@extends('emails.template-email')

@section('subject', 'Contacto desde la web')
@section('summary', 'Se ha enviado un nuevo contacto desde la web')

@section('contenido')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td style="padding: 20px; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px; color: #555555;">
                <h1 style="margin: 0 0 10px 0; font-family: Arial, sans-serif; font-size: 25px; line-height: 30px; color: #333333; font-weight: normal;">Nuevo contacto desde la web</h1>
                <p>
                    Nombre: {{ $data->name }}<br>
                    Email: {{ $data->email }}<br>
                    Teléfono: {{ $data->phone }}<br><br>
                    Mensaje: <br>
                    {!!  nl2br($data->message)  !!}
                </p>
            </td>
        </tr>
    </table>
@stop
