@extends('emails.template-email')

@section('subject', 'Recuperar la contraseña.')
@section('summary', 'Si has perdido la contraseña, y has solicitado el envío de una nueva a tu email sigua las instrucciones indicadas')

@section('contenido')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td style="padding: 20px; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px; color: #555555;">
                <h1 style="margin: 0 0 10px 0; font-family: Arial, sans-serif; font-size: 25px; line-height: 30px; color: #333333; font-weight: normal;">¿Has perdido la contraseña?</h1>
                <p style="margin: 0;">Si has perdido la contraseña, y has solicitado el envío de una nueva a tu email, por favor haz click en el botón "Resetear contraseña" o
                    bien copia y pega el siguiente enlace en una ventana de su navegador. El enlace estará disponible durante 60 minutos.
                </p>
                <p style="word-break:break-all;">{{url('/auth/forgot-password/'.$password->token.'/'.$password->email)}}</p>

                <!-- Button : BEGIN -->
                <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                    <tr>
                        <td class="button-td button-td-primary" style="border-radius: 4px; background: #222222;">
                            <a class="button-a button-a-primary" href="{{url('/auth/reset/'.$password->token.'/'.$password->email)}}" style="background: #222222; border: 1px solid #000000; font-family: sans-serif; font-size: 15px; line-height: 15px; text-decoration: none; padding: 13px 17px; color: #ffffff; display: block; border-radius: 4px;">Resetear contraseña</a>
                        </td>
                    </tr>
                </table>
                <!-- Button : END -->

                <p>Si por el contrario no has solicitado recuperar la contraseña, por favor elimina este email y no hagas nada.<br><br>Muchas gracias!</p>
            </td>
        </tr>
    </table>
@stop
