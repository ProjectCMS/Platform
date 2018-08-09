!function ($) {
    "use strict";
    var Theme = function () {
        },
        $self,
        $plugins;

    Theme.prototype.initAjax = function () {
        var formAjax = $('.form-ajax');
        formAjax.on('submit', function (e) {
            e.preventDefault();
            var url       = $(this).attr('action'),
                serialize = $(this).serialize(),
                formGroup = $(this).find('.form-group');

            formGroup.removeClass('has-error');
            formGroup.find('.text-danger').empty();

            $.post({
                       url: url,
                       headers: {'X-CSRF-TOKEN': $self.token},
                       method: 'POST',
                   }, serialize, function (data) {

                if(data.auth){
                    location.href = data.intended;
                }else{
                    $plugins.loadButton('stop');
                    // $plugins.waitMe('hide', '.form-ajax');
                }

            }).fail(function (data, status, error) {

                $plugins.loadButton('stop');

                var responde = data.responseJSON;
                $.each(responde.errors, function (index, val) {
                    var form = formGroup.filter('[data-form="' + index + '"]');
                    form.addClass('has-error');
                    form.find('.text-danger').text(val[0]);
                });
            });

        });

    }

    Theme.prototype.init = function () {

        $self      = this;
        $plugins   = $.Plugins;
        this.token = $('meta[name="csrf-token"]').attr('content');

        this.initAjax();

    }

    //init
    $.Theme = new Theme, $.Theme.Constructor = Theme
}(window.jQuery),

    //initializing
    function ($) {
        "use strict";
        $.Theme.init();
    }(window.jQuery);
