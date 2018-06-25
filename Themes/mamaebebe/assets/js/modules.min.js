!function ($) {
    "use strict";
    var Users = function () {
        },
        $self,
        $plugins;

    Users.prototype.initAjax = function () {
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

    Users.prototype.init = function () {

        $self      = this;
        $plugins   = $.Plugins;
        this.token = $('meta[name="csrf-token"]').attr('content');

        this.initAjax();
    }

    //init
    $.Users = new Users, $.Users.Constructor = Users
}(window.jQuery),

    //initializing
    function ($) {
        "use strict";
        $.Users.init();
    }(window.jQuery);



