!function ($) {
    "use strict";

    var Dashboard = function () {
    };
    var token   = $('meta[name="csrf-token"]').attr('content'),
        request = dashboard.request.replace(/&amp;/g, '&');


    Dashboard.prototype.initEditor       = function () {
        tinymce.init(
            {
                selector: '.textarea',
                skin: 'custom',
                branding: false,
                menubar: false,
                content_css: ['/modules/dashboard/css/custom/dashboard.css'],
                language: 'pt_BR',
                entity_encoding: "raw",
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                    "searchreplace visualblocks visualchars fullscreen insertdatetime media nonbreaking",
                    "table directionality emoticons template textcolor paste textcolor colorpicker textpattern autoresize imagetools code"
                ],
                toolbar1: 'manager bold italic strikethrough numlist bullist blockquote hr alignleft aligncenter alignright link unlink image media',
                toolbar2: 'formatselect underline alignjustify forecolor paste searchreplace removeformat charmap outdent indent undo redo print fullscreen code',

                // Upload files
                relative_urls: false,
                remove_script_host: false,

                setup: function (editor) {
                    editor.addButton('manager', {
                        text: 'Adicionar Mídia',
                        icon: 'browse',
                        tooltip: 'Adicionar Mídia',
                        shortcut: "Ctrl+E",
                        onclick: this.modalEditor
                    }),

                        editor.addShortcut("Ctrl+E", "", this.modalEditor), editor.addMenuItem("manager", {
                        text: 'Adicionar Mídia',
                        icon: 'browse',
                        tooltip: 'Adicionar Mídia',
                        onclick: this.modalEditor,
                        context: "insert"
                    });
                },

                file_picker_callback: function (callback, value, meta) {
                    this.modalEditor('insert', callback, value, meta);
                }

            });
    }
    Dashboard.prototype.initAjaxAciton   = function () {
        $(".ajax-action").on("click", function (e) {

            e.preventDefault();

            var c      = confirm('Deseja mesmo executar essa ação?'),
                method = $(this).data('method') ? $(this).data('method') : 'post',
                url    = $(this).attr("href"),
                data   = $(this).data();

            if (c == true) {
                $.post(
                    {
                        url: url,
                        method: method,
                        headers: {'X-CSRF-TOKEN': token}
                    }, data, function (data) {
                        location.reload();
                    });
            }
        });
    }
    Dashboard.prototype.initAjaxActions  = function () {
        $(".ajax-actions").on("submit", function (e) {

            e.preventDefault();

            var checks    = [],
                method    = $(this).attr('method') ? $(this).attr('method') : 'post',
                url       = $(this).attr('href'),
                serialize = $(this).serialize();

            $('[data-check="single"]').each(function (index, val) {
                if ($(this).is(':checked')) {
                    checks.push($(this).val());
                }
            });

            if (checks.length) {
                $.post({
                           url: url,
                           method: 'post',
                       }, serialize, function (data) {
                    // location.reload();
                });
            }

            console.log(serialize);

        });
    }
    Dashboard.prototype.initAjaxModules  = function () {
        $(".ajax-module").on("click", function (e) {

            e.preventDefault();

            var $this  = $(this),
                status = $(this).is(":checked"),
                module = $(this).val(),
                url    = $(this).closest('table').data("href");

            $.post({
                       url: url,
                       headers: {'X-CSRF-TOKEN': token}
                   }, {status: status, module: module}, function (data) {

                if (data.status == false && status == false) {
                    $this.prop('checked', true);
                    alert(data.msg);
                } else {
                    location.reload();
                }
            });
        });
    }
    Dashboard.prototype.initCustomTable  = function () {
        var table = $('.table');

        $.each(table.find('th[data-sort]'), function (index, val) {

            var object = this.parseParamns(request),
                data   = $(this).data();

            if (!$(this).attr('data-order')) {
                $(this).attr('data-order', '');
            }

            if (data.sort == object.sort) {
                $(this).attr('data-order', object.order);
            }
        });

        table.on('click', 'th[data-sort]', function (e) {

            var sort     = $(this).attr('data-sort'),
                order    = $(this).attr('data-order') ? $(this).attr('data-order') : 'desc',
                newOrder = (order === 'desc' ? 'asc' : 'desc'),
                object   = this.parseParamns(request);

            $(this).attr('data-order', newOrder);

            object.order = newOrder;
            object.sort  = sort;

            delete object.page;

            location.href = '?' + $.param(object);

            e.preventDefault();
        });
    }
    Dashboard.prototype.initGrid         = function () {
        var grid        = $(".grid"),
            ordering    = $('.ordering'),
            order       = [],
            imagesInput = $(".images-input");

        imagesInput.find('option').attr('selected', 'selected');

        grid.on('click', '.item .delete-image', function (e) {
            var image = $(this).closest('.item').data('image');
            $(this).closest('.item').remove();
            imagesInput.find('option[value="' + image + '"]').remove();
        });

        $(window).on("resize load", function () {
            var w = $('.box').width();
            if (w >= 1920) {
                grid.attr('data-columns', 10);
            } else if (w >= 1680 && w < 1920) {
                grid.attr('data-columns', 9);
            } else if (w >= 1480 && w < 1680) {
                grid.attr('data-columns', 8);
            } else if (w >= 1280 && w < 1460) {
                grid.attr('data-columns', 7);
            } else if (w >= 1080 && w < 1280) {
                grid.attr('data-columns', 6);
            } else if (w >= 880 && w < 1080) {
                grid.attr('data-columns', 5);
            } else if (w >= 680 && w < 880) {
                grid.attr('data-columns', 4);
            } else if (w >= 480 && w < 680) {
                grid.attr('data-columns', 3);
            } else {
                grid.attr('data-columns', 2);
            }
        });

        grid.sortable(
            {
                items: "> .sortable",
                update: function (event, ui) {
                    ordering.removeClass('disabled');
                    order = $(this).sortable('toArray');
                }
            });
        grid.disableSelection();

        ordering.on("click", function (e) {

            var url = $(this).attr("href");
            $.post({
                       url: url,
                       headers: {'X-CSRF-TOKEN': token},
                       method: 'put'
                   }, {order: order}, function () {
                ordering.addClass('disabled');
                alert("Ordenação alterada");
            });

            e.preventDefault();

        });
    }
    Dashboard.prototype.initCheckbox     = function () {
        $('[data-check="all"]').on("click", function () {
            $('[data-check="single"]').not(this).prop('checked', this.checked);
        });
    }
    Dashboard.prototype.parseParamns     = function (str) {
        if (str) {
            return str.split('&').reduce(function (params, param) {
                var paramSplit        = param.split('=').map(function (value) {
                    return decodeURIComponent(value.replace(/\+/g, ' '));
                });
                params[paramSplit[0]] = paramSplit[1];
                return params;
            }, {});
        } else {
            return {};
        }
    }
    Dashboard.prototype.imageOrientation = function (src) {
        var orientation,
            img = new Image();

        img.src = src;

        if (img.naturalWidth > img.naturalHeight) {
            orientation = 'landscape';
        } else if (img.naturalWidth < img.naturalHeight) {
            orientation = 'portrait';
        } else {
            orientation = 'even';
        }

        return orientation;
    }
    Dashboard.prototype.modalEditor      = function (type, callback, value, meta) {
        if (type == 'insert') {

            $(this).manager(
                {
                    manager: dashboard.urlManager,
                    tools: true,
                    multiple: false,
                    dataFile: value,
                    data: {type: meta.filetype},
                    complete: function (data) {
                        if (data.length) {
                            $.each(data, function (index, val) {
                                callback(val.url);
                            });
                        }
                    }
                });

        } else {

            $(this).manager(
                {
                    manager: dashboard.urlManager,
                    tools: true,
                    multiple: true,
                    complete: function (data) {
                        if (data.length) {
                            $.each(data, function (index, val) {
                                tinymce.activeEditor.execCommand('mceInsertContent', false, val.html);
                            });
                        }
                    }
                });
        }
    }
    Dashboard.prototype.nl2br            = function (varTest) {
        if (varTest)
            return varTest.replace(/(\r\n|\n\r|\r|\n)/g, "<p>");
    };
    Dashboard.prototype.br2nl            = function (varTest) {
        if (varTest)
            return varTest.replace(/<br>/g, "\r");
    };

    Dashboard.prototype.init = function () {

        $(".textarea").val(this.br2nl($(".textarea").val()));
        $(".textarea").val(this.nl2br($(".textarea").val()));

        this.initEditor();
        this.initAjaxAciton();
        this.initAjaxActions();
        this.initAjaxModules();
        this.initCustomTable();
        this.initGrid();
        this.initCheckbox();
    }

    //init
    $.Dashboard = new Dashboard, $.Dashboard.Constructor = Dashboard
}(window.jQuery),

    //initializing
    function ($) {
        "use strict";
        $.Dashboard.init();
    }(window.jQuery);