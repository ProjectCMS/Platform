!function ($) {
    let Contents = function () {
        },
        $self;

    Contents.prototype.initSubscribeContent = function () {
        let
            tableAddCicle  = $('.table-cicle-content'),
            btnAddCicle    = $('.add-cicle-content'),
            formItems      = $('.form-items').find('[data-item]'),
            serialize      = [];

        btnAddCicle.on('click', function () {
            formItems.each(function (index, value) {
                serialize[$(value).attr('data-item')] = $(value).val();
            });

            serialize = $.extend({}, serialize);

            $.post({
                       url: urlCicleContent,
                       headers: {'X-CSRF-TOKEN': app.token}
                   }, serialize, function (data) {

                let rand = Math.floor((Math.random() * 9999999) + 1),
                    $row = $('<tr data-id="' + rand + '"/>');

                $row.append($("<td/>").html(
                    '<label class="mb-0">' + data.cicle_name + '</label>' +
                    '<input type="hidden" name="cicle[' + rand + '][subscribe_cicle_id]" value="' + data.cicle_id + '">'));


                $row.append($("<td/>").html(
                    '<label class="mb-0">' + data.votes + '</label>' +
                    '<input type="hidden" name="cicle[' + rand + '][votes]" value="' + data.votes + '">'));

                $row.append($("<td/>").html(
                    '<button class="btn btn-danger btn-block remove-cicle-content" type="button"><i class="fa fa-close"></i> Remover</button>' +
                    '<input type="hidden" name="cicle[' + rand + '][id]" value="' + rand + '">'));

                tableAddCicle.append($row);

            }).fail(function () {
                alert("Preencha todos os campos!");
            });
        });


        tableAddCicle.on('click', '.remove-cicle-content', function (){
            $(this).closest('tr').remove();
        })

    }

    Contents.prototype.init = function () {
        $self = this;
        this.initSubscribeContent();
    }

    //init
    $.Contents = new Contents, $.Contents.Constructor = Contents
}(window.jQuery),

    //initializing
    function ($) {
        $.Contents.init();
    }(window.jQuery);
