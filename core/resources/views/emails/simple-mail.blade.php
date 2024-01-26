@extends('templates.template-email')

@section('subject', $email->subject)
@section('summary', $email->subject)

@section('contenido')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td style="padding: 20px; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px; color: #555555;">
                {!! $email->body !!}
            </td>
        </tr>
    </table>
@stop

@section('tracking')
    @if ($tracking)
        <img src="{{ url('/email/'.$email->hash.'/image.png') }}" />
    @endif
@stop
