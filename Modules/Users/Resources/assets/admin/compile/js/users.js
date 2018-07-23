!function ($) {
    "use strict";
    var Users = function () {
        },
        $self;

    Users.prototype.initCheckBox = function () {
        var checkAll       = $('.input-check-all'),
            checkboxsRoute = $('.checkboxs-route');

        checkAll.on('click', function (e) {
            var item  = $(this).closest('.item'),
                items = item.find('.checkboxs-route');
            items.prop('checked', $(this).prop('checked'));
        });

        checkboxsRoute.on('change', function () {
            if (!$(this).prop("checked")) {
                var checkAll = $(this).closest('.item').find('.input-check-all');
                checkAll.prop("checked", false);
            }
        });

        checkAll.closest('.item').each(function () {
            var items = $(this).find('.checkboxs-route');

            if (items.length == items.filter(':checked').length) {
                $(this).find('.input-check-all').prop("checked", true);
            }
        });
    }

    Users.prototype.init = function () {
        $self = this;
        this.initCheckBox();
    }

    //init
    $.Users = new Users, $.Users.Constructor = Users
}(window.jQuery),

    //initializing
    function ($) {
        "use strict";
        $.Users.init();
    }(window.jQuery);
