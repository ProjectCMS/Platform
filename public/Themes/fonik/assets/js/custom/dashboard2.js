var token   = $('meta[name="csrf-token"]').attr('content'),
    request = request = request.replace(/&amp;/g, '&'),
    table   = $('.table');

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


function modal_tinyMCE (type, callback, value, meta) {

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


//***** AJAX MODULE *****//


//***** AJAX ACTIONS *****//


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



function parseParams (str) {

}

//***** CHECKBOX *****//


//***** GRID/IMAGES *****//



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

