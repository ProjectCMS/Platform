!function ($) {
    "use strict";
    var Menus     = function () {
        },
        $self,
        $app,
        dd        = $('.dd'),
        menuItems = $('.menu-items'),
        $menu     = [];

    Menus.prototype.initManagerMenu = function () {

        var btn     = $('.add-item-menu'),
            btnLink = $('.add-item-menu-link');

        // Adicionar itens de categoria e páginas
        btn.on('click', function (e) {

            e.preventDefault();

            var checks = $('.parent-menu').find('[type="checkbox"]:checked'),
                tmp    = [];

            if (checks.length >= 1) {

                $.each(checks, function (index, val) {

                    var type = $(this).closest('.parent-menu').data('type'),
                        json = {provider_type: type, item: $(this).val()};

                    tmp.push(json);
                });

                $self.postMenu(tmp, true, function (data) {
                    checks.prop('checked', false);
                    btn.prop('disabled', false);
                    dd.find('#dd-main').append(data);
                    $self.getNestableMenu();
                });
            }

        });

        btnLink.on('click', function (e) {

            e.preventDefault();

            var items   = $('.parent-link').find('input'),
                tmp     = [],
                $return = false;

            $.each(items, function (index, val) {
                var dataLink = $(this).data('link'),
                    value    = $(this).val();

                if (dataLink == 'url' && $self.checkUrl(value) == false) {
                    alert("URL digitada é inválida!");
                    $return = false;
                    return false;
                } else if (value == '') {
                    alert("Preencha todos os campos do link personalizado!");
                    $return = false;
                    return false;
                } else {
                    $return       = true;
                    tmp[dataLink] = value;
                }

            });

            tmp = $.extend({}, tmp);

            if ($return) {
                $self.postMenu(tmp, false, function (data) {
                    dd.find('#dd-main').append(data);
                    $self.getNestableMenu();
                    items.val('');
                });
            }

        });

    }

    Menus.prototype.postMenu = function (tmp, array, callback) {

        var serialize;

        if (array == true) {
            serialize = {items: tmp};
        } else {
            serialize = tmp;
        }

        $.post({
                   url: app.urlMenuItem,
                   headers: {'X-CSRF-TOKEN': app.token}
               }, serialize, function (data) {
            callback(data);

        });

    }

    Menus.prototype.getNestableMenu = function () {

        var serialize = dd.nestable('toArray'),
            tmp       = [];

        if (serialize.length) {
            $.each(serialize, function (index, val) {

                var item    = dd.find('.dd-item').filter('[data-id="' + val.id + '"]'),
                    inputs  = item.find('#cl-' + val.id + ' input'),
                    objects = [];

                val.elements = [];

                $.each(inputs, function () {
                    var dataLink = $(this).data('link'),
                        value    = $(this).val();

                    var obj       = {};
                    obj[dataLink] = value;

                    objects = $.extend(objects, obj);
                });

                objects      = $.extend({}, objects);
                val.elements = objects;

                tmp.push(val);
            });

            menuItems.val(JSON.stringify(tmp));
        }

    }

    Menus.prototype.checkUrl = function (url) {
        var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
        if (!regex.test(url)) {
            return false;
        } else {
            return true;
        }
    }

    Menus.prototype.removeItem = function () {
        var remove = $('.remove-item');

        remove.on('click', function (e) {

            e.preventDefault();

            var elem = $(this).closest('.dd-item');

            elem.remove();

            $self.getNestableMenu();

        });

    }

    Menus.prototype.setMenu = function () {
        var select = $('.set-menu'),
            url    = select.closest('.form').data('url'),
            btn    = select.closest('.form').find('.btn');

        btn.on('click', function () {
            var val = select.val();
            if (val != '') {
                location.href = url + '/' + val;
            }
        });
    }

    Menus.prototype.getInputValue = function () {
        var input = dd.find('input');
        input.on('keyup', function () {
            $self.getNestableMenu();
        });
    }

    Menus.prototype.initNestableMenu = function () {
        dd.nestable(
            {
                callback: function () {
                    $self.getNestableMenu();
                }
            });

    }

    Menus.prototype.init = function () {

        $self = this;
        $app  = $.App;

        this.initManagerMenu();
        this.initNestableMenu();
        this.getNestableMenu();
        this.removeItem();
        this.setMenu();
        this.getInputValue();
    }

    //init
    $.Menus = new Menus, $.Menus.Constructor = Menus
}(window.jQuery),

    //initializing
    function ($) {
        "use strict";
        $.Menus.init();
    }(window.jQuery);
