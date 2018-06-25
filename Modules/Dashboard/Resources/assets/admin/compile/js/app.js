!function ($) {
    "use strict";

    var App = function () {
        },
        $self;

    App.prototype.initEditor = function () {
        tinymce.init(
            {
                selector: '.textarea',
                skin: 'custom',
                branding: false,
                menubar: false,
                content_css: ['/Themes/fonik/assets/css/theme.css'],
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
                        onclick: $self.modalEditor
                    }),

                        editor.addShortcut("Ctrl+E", "", $self.modalEditor), editor.addMenuItem("manager", {
                        text: 'Adicionar Mídia',
                        icon: 'browse',
                        tooltip: 'Adicionar Mídia',
                        onclick: $self.modalEditor,
                        context: "insert"
                    });
                },

                file_picker_callback: function (callback, value, meta) {
                    $self.modalEditor('insert', callback, value, meta);
                }

            });
    }

    App.prototype.initAjaxAciton = function () {
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
                        headers: {'X-CSRF-TOKEN': app.token}
                    }, data, function (data) {
                        location.reload();
                    });
            }
        });
    }

    App.prototype.initAjaxModules = function () {
        $(".ajax-module").on("click", function (e) {

            e.preventDefault();

            var $this  = $(this),
                status = $(this).is(":checked"),
                module = $(this).val(),
                url    = $(this).closest('table').data("href");

            $.post({
                       url: url,
                       headers: {'X-CSRF-TOKEN': app.token}
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

    App.prototype.initCustomTable = function () {
        var table = $('.table');

        $.each(table.find('th[data-sort]'), function (index, val) {

            var object = $self.parseParamns($self.request),
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
                object   = $self.parseParamns($self.request);

            $(this).attr('data-order', newOrder);

            object.order = newOrder;
            object.sort  = sort;

            delete object.page;

            location.href = '?' + $.param(object);

            e.preventDefault();
        });
    }

    App.prototype.initGrid = function () {

        var grid       = $self.grid,
            filesInput = $self.filesInput,
            ordering   = $self.ordering,
            order      = $self.order;

        filesInput.find('option').attr('selected', 'selected');

        grid.on('click', '.item .delete-image', function (e) {
            var image = $(this).closest('.item').data('image');
            $(this).closest('.item').remove();
            filesInput.find('option[value="' + image + '"]').remove();
            $self.gridItemsData();
        });

        grid.sortable(
            {
                items: "> .sortable",
                update: function (event, ui) {
                    ordering.removeClass('disabled');
                    order = $(this).sortable('toArray');
                    $self.gridItemsData();
                }
            });
        grid.disableSelection();

        ordering.on("click", function (e) {

            var url = $(this).attr("href");
            $.post({
                       url: url,
                       headers: {'X-CSRF-TOKEN': app.token},
                       method: 'put'
                   }, {order: order}, function () {
                ordering.addClass('disabled');
                alert("Ordenação alterada");
            });

            e.preventDefault();

        });

        $self.gridResize();

    }

    App.prototype.gridResize = function () {

        var grid = $self.grid;

        $(window).on("resize load", function () {
            var w = $('body').width();
            if (w >= 1920) {
                grid.attr('data-columns', 6);
            } else if (w >= 1780 && w < 1920) {
                grid.attr('data-columns', 5);
            } else if (w >= 1480 && w < 1780) {
                grid.attr('data-columns', 4);
            } else if (w >= 1080 && w < 1480) {
                grid.attr('data-columns', 3);
            } else if (w >= 880 && w < 1080) {
                grid.attr('data-columns', 2);
            } else {
                grid.attr('data-columns', 1);
            }
        });
    }

    App.prototype.gridItemsData = function () {
        $self.jsonInput = [];
        $.each($self.grid.find('.item .item-content'), function (index, val) {
            $self.jsonInput.push(this.dataset);
        });
        $self.filesInput.val(JSON.stringify($self.jsonInput));
    }

    App.prototype.initCheckbox = function () {
        $('[data-check="all"]').on("click", function () {
            $('[data-check="single"]').not(this).prop('checked', this.checked);
        });
    }

    App.prototype.parseParamns = function (str) {
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

    App.prototype.imageOrientation = function (src) {
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

    App.prototype.modalEditor = function (type, callback, value, meta) {
        if (type == 'insert') {

            $(this).manager(
                {
                    manager: app.urlManager,
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
                    manager: app.urlManager,
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

    App.prototype.fileManager = function (callback) {
        $(this).manager(
            {
                manager: manager,
                tools: true,
                multiple: false,
                data: {type: 'image'},
                complete: function (data) {
                    callback(data);
                }
            }
        );
    }

    App.prototype.changeImage = function () {

        $('.change-image').on('click', function (e) {
            e.preventDefault();
            $self.fileManager(function (data) {
                $('.single-image').val(data[0].path);
                $('.content-image').empty().html(data[0].html);
            });
        });

        $('.remove-image').on('click', function (e) {
            $('.single-image').val('');
            $('.content-image').empty();
        });

    }

    App.prototype.nl2br = function (value) {
        if (value) {
            value = value.trim();
            return value.replace(/(\r\n|\n\r|\r|\n)/g, "<p>");
        }
    }

    App.prototype.br2nl = function (value) {
        if (value) {
            value = value.trim();
            return value.replace(/<br>/g, "\r");
        }
    }

    App.prototype.init = function () {

        $(".textarea").val(this.br2nl($(".textarea").val()));
        $(".textarea").val(this.nl2br($(".textarea").val()));

        $self = this;

        this.grid       = $('.grid');
        this.ordering   = $('.ordering');
        this.order      = [];
        this.filesInput = $('.files-input');
        this.jsonInput  = [];
        this.request    = app.request.replace(/&amp;/g, '&');

        this.initEditor();
        this.initAjaxAciton();
        this.initAjaxModules();
        this.initCustomTable();
        this.initGrid();
        this.initCheckbox();
    }

    //init
    $.App = new App, $.App.Constructor = App
}(window.jQuery),

    //initializing
    function ($) {
        "use strict";
        $.App.init();
    }(window.jQuery);