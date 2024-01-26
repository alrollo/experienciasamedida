@extends('emails.template-email')

@section('subject', 'Nueva contraseña de acceso.')
@section('summary', 'Te enviamos la nueva contraseña de acceso a la intranet.')

@section('contenido')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td style="padding: 20px; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px; color: #555555;">
                <h1 style="margin: 0 0 10px 0; font-family: Arial, sans-serif; font-size: 25px; line-height: 30px; color: #333333; font-weight: normal;">Tu nueva contraseña de acceso!</h1>
                <p style="margin: 0;">Te enviamos la nueva contraseña de acceso, puedes cambiarla desde la edición de tu perfil en la intranet.
                    <br><br>
                    Contraseña: <b>{{$password}}</b><br><br>
                    Muchas gracias!
                </p>
            </td>
        </tr>
    </table>
@stop
