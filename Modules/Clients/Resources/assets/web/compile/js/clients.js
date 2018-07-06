!function ($) {
    "use strict";
    var Clients = function () {
        },
        $self,
        $plugins;

    Clients.prototype.initAjax = function () {
        var formAjax = $('.form-ajax');
        formAjax.on('submit', function (e) {
            e.preventDefault();
            var url       = $(this).attr('action'),
                serialize = $(this).serialize(),
                formGroup = $(this).find('.form-group');

            formGroup.removeClass('has-error');
            formGroup.find('.text-danger').empty();

            $plugins.waitMe('load', '.item-content', 'stretch');

            $.post({
                       url: url,
                       headers: {'X-CSRF-TOKEN': $self.token},
                       method: 'POST',
                   }, serialize, function (data) {

                if(data.auth){
                    location.href = data.intended;
                }else{
                    $plugins.waitMe('hide', '.item-content');
                }

            }).fail(function (data, status, error) {

                $plugins.waitMe('hide', '.item-content');

                var responde = data.responseJSON;
                $.each(responde.errors, function (index, val) {
                    var form = formGroup.filter('[data-form="' + index + '"]');
                    form.addClass('has-error');
                    form.find('.text-danger').text(val[0]);
                });
            });

        });

    }

    Clients.prototype.init = function () {

        $self      = this;
        $plugins   = $.Plugins;
        this.token = $('meta[name="csrf-token"]').attr('content');

        this.initAjax();
    }

    //init
    $.Clients = new Clients, $.Clients.Constructor = Clients
}(window.jQuery),

    //initializing
    function ($) {
        "use strict";
        $.Clients.init();
    }(window.jQuery);



