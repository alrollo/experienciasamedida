/*! gya_cookies.js
* ================
* Plugin para gestionar el consentimiento de cookies RGPD 2020
*
* @author GyA Studio
* @version v2.0.0
*/
(function gya_cookies($) {
    // Leemos la cookie
    let gya_cookies = getCookie('gya_cookies');

    if (gya_cookies == '') {
        showCookiesModal();
    }

    /*
    EVENTO
    */
    $(document).on('click', '.gya_cookies_open_modal', function(e) {
        e.preventDefault();
        showCookiesModal();
    });

    $('#gya_cookies').on('click', '#gya_btn_aceptar', function(e) {
        e.preventDefault();

        let cvalue = {};
        cvalue.aceptada = true;
        cvalue.cookies = ['analiticas', 'marketing'];
        setCookie('gya_cookies', JSON.stringify(cvalue), 7);

        hideCookiesModal();
        location.reload();
    });

    $('#gya_cookies').on('click', '#gya_btn_guardar', function(e) {
        e.preventDefault();

        let cvalue = {};
        cvalue.aceptada = true;
        cvalue.cookies = [];
        if ($('#gya_cookies #gya_cookies_analiticas').is(':checked'))
            cvalue.cookies.push('analiticas');
        if ($('#gya_cookies #gya_cookies_marketing').is(':checked'))
            cvalue.cookies.push('marketing');
        setCookie('gya_cookies', JSON.stringify(cvalue), 7);

        hideCookiesModal();
        location.reload();
    });

    $('#gya_cookies').on('click', '#gya_btn_configurar', function(e) {
        e.preventDefault();
        $('#gya_cookies #gya_body_1').fadeOut(200, function() { $('#gya_cookies #gya_body_2').fadeIn(200); });
    });

    $('#gya_cookies').on('click', '#gya_btn_volver', function(e) {
        e.preventDefault();
        $('#gya_cookies #gya_body_2').fadeOut(200, function() { $('#gya_cookies #gya_body_1').fadeIn(200); });
    });

    $('#gya_cookies').on('click', '#gya_btn_aceptar_todas', function(e) {
        e.preventDefault();
        $('#gya_cookies #gya_cookies_analiticas').prop('checked', true);
        $('#gya_cookies #gya_cookies_marketing').prop('checked', true);
    });

    $('#gya_cookies').on('click', '#gya_btn_rechazar_todas', function(e) {
        e.preventDefault();
        $('#gya_cookies #gya_cookies_analiticas').prop('checked', false);
        $('#gya_cookies #gya_cookies_marketing').prop('checked', false);
    });

    /*
    FUNCIONES AUXILIARES
    */
    function showCookiesModal() {
        if (gya_cookies != '') {
            cvalue = JSON.parse(gya_cookies);
            if (cvalue != null && cvalue.cookies.length > 0) {
                if (cvalue.cookies.includes('analiticas'))
                    $('#gya_cookies #gya_cookies_analiticas').prop('checked', true);

                if (cvalue.cookies.includes('marketing'))
                    $('#gya_cookies #gya_cookies_marketing').prop('checked', true);
            }
        }

        $('html, body').css('overflow', 'hidden');
        $('#gya_cookies').fadeIn(200);
    }

    function hideCookiesModal() {
        $('html, body').css('overflow', 'initial');
        $('#gya_cookies').fadeOut(200);
    }

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
})(jQuery);