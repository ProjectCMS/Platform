(function ($) {

    $.fn.manager = function (options) {

        var base      = this;
        var serialize = {};

        var settings = $.extend(
            {
                complete: function () {
                },
                multiple: false,
                tools: false,
                manager: '',
                url: '',
                data: '',
                dataFile: '',
            }, options);

        var $selector = $("body");

        this.each(function () {

            serialize = {
                url: (settings.url ? btoa(settings.url) : ''),
                tools: settings.tools,
                dataFile: settings.dataFile,
                multiple: (!settings.file ? settings.multiple : false),
            };

            serialize = $.extend(settings.data, serialize);

            $.get(manager, serialize, function (data) {

                var $manager = document.createElement('div');
                var $rand    = Math.floor(Math.random() * (999999 - 0)) + 0;
                var $content = "content-manager-" + $rand;

                $manager.setAttribute("id", $content);

                $($selector).children("#" + $content).remove();
                $($selector).append($manager);
                $($selector).children("#" + $content).append(data);

                //****** Abrir a modal ******//
                abrir_modal($content);

                //****** Fechar a modal ******//
                fechar_modal($content);

                //****** Selecionar os arquivos ******//
                selecionar_arquivos($content);

            });
        });

        abrir_modal = function ($content) {
            $($selector).find('#' + $content).css('position', 'relative');
            $($selector).find('#' + $content).css('z-index', '999999999');
            $($selector).find('#' + $content).find('.modal-manager').modal({
                                                                               show: true
                                                                           });
            $($selector).find('#' + $content).find('.manager ul li').removeClass('selected');
        }

        fechar_modal = function ($content) {
            $($selector).find('#' + $content).find('.modal-manager').on('hide.bs.modal', function (event) {
                $($selector).children('#' + $content).remove();
            });
        }

        selecionar_arquivos = function ($content) {
            $($selector).children('#' + $content).find('iframe').on("load", function () {
                var $this      = $(this).contents(),
                    btn_insert = $this.find('#insert-item');

                btn_insert.on("click", function () {

                    var val  = [];
                    var item = [];

                    $this.find('.check-item:checkbox:checked').each(function (i, value) {
                        val[i]  = atob($(this).val());
                        item[i] = $(this).closest('.item').data();
                    });

                    if (item) {

                        var data = [];

                        $.each(item, function (index, value) {

                            if (value.type != 'folder') {
                                switch (value.type) {
                                    case 'text':
                                    case 'application':
                                        value.html = '<a href="' + value.url + '">' + value.file + '</a>';
                                        break;
                                    case 'image':
                                        value.html = '<img src="' + value.url + '">';
                                        break;
                                    case 'audio':
                                        value.html = '<audio controls><source src="' + value.url + '"></audio >';
                                        break;
                                    case 'video':
                                        value.html = '<video controls><source src="' + value.url + '"></video>';
                                        break;
                                }

                                value.path = atob(value.path);

                                data[index] = value;
                            }
                        });

                        if ($.isFunction(settings.complete)) {
                            settings.complete.call(base, data);
                        }

                        $($selector).find('#' + $content).find('.modal-manager').modal('hide');
                    }
                });

            });
        }

    }

})(jQuery);
