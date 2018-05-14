var items = $(".items"),
    request = request.replace(/&amp;/g, '&');

request = unserialize(request);

//***** GET ALL FILES *****//
$.post({
           url: url_items,
           method: 'get',
           headers: {'X-CSRF-TOKEN': token},
       }, request, function (data) {
    items.empty().html(data);
});


//***** UPLOAD *****//
request.dir = current_dir;
$(".upload").uploads(
    {
        url: url_upload,
        data: request,
        headers: {'X-CSRF-TOKEN': token},
        complete: function (data) {
            location.reload();
        }
    }
);

//***** DOWNLOAD *****//
$(".downloads").on("click", function (e) {
    e.preventDefault();

    var val = [];
    $('.check-item:checkbox:checked').each(function (i) {
        val[i] = $(this).val();
    });

    request.data = val;

    if (val.length >= 1) {
        $.post({
                   url: url_download,
                   headers: {'X-CSRF-TOKEN': token},
               }, request, function (data) {
        });
    }
});

//***** DELETE *****//
$(".delete").on("click", function (e) {
    e.preventDefault();

    var c    = confirm('Deseja mesmo executar essa ação?');
    var val  = [];
    var item = [];
    $('.check-item:checkbox:checked').each(function (i, value) {
        val[i]  = $(this).val();
        item[i] = $(this);
    });

    request.data = val;

    if (val.length >= 1 && c == true) {
        $.post({
                   url: url_delete,
                   method: 'delete',
                   headers: {'X-CSRF-TOKEN': token},
               }, request, function (data) {

            location.reload();

            // Remove os itens da lista
            $.each(item, function (i, value) {
                $(this).closest('.item').remove();
                count_check();
            });
        });
    }
});

//***** SAVE FOLDER *****//
$(".save-folder").on("click", function (e) {
    e.preventDefault();

    var form      = document.forms[0],
        serialize = $(form).serialize(),
        url       = $(form).attr("action");

    serialize = unserialize(serialize);
    serialize = $.extend(serialize, request);

    $.post(url, serialize, function (data) {
        location.reload();
    });
});

function unserialize(str) {
    str = decodeURIComponent(str);
    var chunks = str.split('&'),
        obj = {};
    for(var c=0; c < chunks.length; c++) {
        var split = chunks[c].split('=', 2);
        obj[split[0]] = split[1];
    }
    return obj;
}
