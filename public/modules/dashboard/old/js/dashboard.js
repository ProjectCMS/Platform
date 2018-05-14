var token   = $('meta[name="csrf-token"]').attr('content'),
    request = request = request.replace(/&amp;/g, '&'),
    table = $('.table');

var grid        = $(".grid"),
    ordering    = $('.ordering'),
    order       = [],
    imagesInput = $(".images-input");


jQuery.nl2br = function (varTest) {
    if (varTest)
        return varTest.replace(/(\r\n|\n\r|\r|\n)/g, "<p>");
};
jQuery.br2nl = function (varTest) {
    if (varTest)
        return varTest.replace(/<br>/g, "\r");
};

$(".textarea").val($.br2nl($(".textarea").val()));
$(".textarea").val($.nl2br($(".textarea").val()));


//***** SELECT 2 *****//
$('.select2').select2();

//***** EDITOR *****//
tinymce.init(
    {
        selector: '.textarea',
        skin: 'custom',
        branding: false,
        menubar: false,
        content_css: ['/modules/dashboard/css/dashboard.css'],
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
                onclick: modal_tinyMCE
            }),

                editor.addShortcut("Ctrl+E", "", modal_tinyMCE), editor.addMenuItem("manager", {
                text: 'Adicionar Mídia',
                icon: 'browse',
                tooltip: 'Adicionar Mídia',
                onclick: modal_tinyMCE,
                context: "insert"
            });
        },

        file_picker_callback: function (callback, value, meta) {
            modal_tinyMCE('insert', callback, value, meta);
        }

    });

function modal_tinyMCE (type, callback, value, meta) {
    if (type == 'insert') {

        $(this).manager(
            {
                manager: manager,
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
                manager: manager,
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

//***** NESTABLE *****//
$('.nestable').nestable(
    {
        dropCallback: function (details) {
            var order = new Array();

            $("li[data-id='" + details.destId + "']").find('ol:first').children().each(function (index, elem) {
                order[index] = $(elem).attr('data-id');
            });

            if (order.length === 0) {
                var rootOrder = new Array();
                $(".dd > ol > li").each(function (index, elem) {
                    rootOrder[index] = $(elem).attr('data-id');
                });
            }

            var data = {
                source: details.sourceId,
                destination: details.destId,
                order: JSON.stringify(order),
                rootOrder: JSON.stringify(rootOrder)
            }

            $.post({
                       url: this.el.data('url'),
                       method: 'PUT',
                       headers: {'X-CSRF-TOKEN': token}
                   }, data, function (data) {
            });

        },
        expandBtnHTML: '<button class="dd-expand" data-action="expand" type="button"></button>',
        collapseBtnHTML: '<button class="dd-collapse" data-action="collapse" type="button"></button>',
    }).nestable('collapseAll');


//***** AJAX ACTION *****//
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

//***** AJAX MODULE *****//
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

//***** AJAX ACTIONS *****//
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

//***** FILEMANAGER *****//
$('[data-manager="editor"]').on("click", function (e) {
    e.preventDefault();

    $(this).manager(
        {
            manager: manager,
            tools: true,
            multiple: true,
            complete: function (data) {
                if (data.length) {
                    $.each(data, function (index, val) {
                        tinymce.activeEditor.execCommand('mceInsertContent', false, val);
                    });
                }
            }
        }
    );
});

//***** DATATABLE *****//
$.each(table.find('th[data-sort]'), function (index, val) {

    var object = parseParams(request),
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
        object   = parseParams(request);

    $(this).attr('data-order', newOrder);

    object.order = newOrder;
    object.sort  = sort;

    delete object.page;

    location.href = '?' + $.param(object);

    e.preventDefault();
});


function parseParams (str) {
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

//***** CHECKBOX *****//
$('[data-check="all"]').on("click", function () {
    $('[data-check="single"]').not(this).prop('checked', this.checked);
});

//***** GRID/IMAGES *****//
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


function image_orientation (src) {

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

