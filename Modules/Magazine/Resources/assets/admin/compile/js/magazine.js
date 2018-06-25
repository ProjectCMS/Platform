var listPDF = $(".grid")
!function ($) {
    "use strict";
    var Magazine = function () {
        },
        $self,
        $app;

    Magazine.prototype.initFilesManager = function () {
        $app.jsonInput = ($app.filesInput.val() ? $app.filesInput.val() : null);
        if ($app.jsonInput != null && $app.filesInput.data('input') == 'pdf') {
            $app.jsonInput = JSON.parse($app.filesInput.val());
            $.each($app.jsonInput, function (index, value) {
                $self.pngToPDF(index, value);
            });
        }
    }

    Magazine.prototype.managerPDF = function () {
        $('.manager-pdf').on("click", function (e) {
            e.preventDefault();
            $(this).manager(
                {
                    manager: manager,
                    tools: true,
                    multiple: false,
                    url: 'revistas',
                    complete: function (data) {
                        var storage = data[0].storage;

                        $.post({
                                   url: urlMagazine,
                                   headers: {'X-CSRF-TOKEN': app.token}
                               }, {storage: storage}, function (data) {

                            $app.initGrid();

                            $.each(data, function (index, value) {
                                $self.pngToPDF(index, value);
                            });
                            $self.actionItems();
                            $app.gridItemsData('magazine');
                        });
                    }
                }
            );
        });
    }

    Magazine.prototype.pngToPDF = function (index, item) {
        pdfjsLib.disableStream = true;
        var loadingTask        = pdfjsLib.getDocument(item.url);

        var list    = $app.grid.append('<div class="item sortable" id="' + item.id + '">' +
            '<div class="pdf-content item-content" data-id="' + item.id + '" data-path="' + item.path + '" data-subscriber="' + item.subscriber + '">\n' +
            '<div id="dropdown" class="btn-group-sm">\n' +
            '<button class="dripicons-gear btn btn-primary" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>\n' +
            '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">\n' +
            '<a class="dropdown-item text-muted item-subscriber" href="#"><i class="ti-medall text-warning"></i> Apenas inscritos</a>\n' +
            '<div class="dropdown-divider"></div>\n' +
            '<a class="dropdown-item text-muted item-delete" href="#"><i class="ti-trash text-danger"></i> Deletar</a>\n' +
            '</div>\n' +
            '</div>\n' +
            '<div class="load"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i>\n' +
            '<span>Carregando...</span></div>' +
            '</div>' +
            '</div>'),
            content = list.find('#' + item.id);

        loadingTask.promise.then(function (pdf) {

            // Fetch the first page
            var pageNumber = 1;
            pdf.getPage(pageNumber).then(function (page) {

                var viewport  = page.getViewport(1),
                    canvas    = document.createElement('canvas'),
                    context   = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width  = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext).then(function () {
                    content.find('.pdf-content').append('<img src="' + canvas.toDataURL('image/jpeg', 1.0) + '">');
                });

            });
        }, function (reason) {
            console.error(reason);
        });
    }

    Magazine.prototype.actionItems = function () {
        var itemPremium = $app.grid.find('.item .item-subscriber'),
            itemDelete  = $app.grid.find('.item .item-delete');

        // Item Premium
        itemPremium.on('click', function (e) {
            e.preventDefault();
            var item       = $(this).closest('.pdf-content'),
                subscriber = item.attr('data-subscriber');

            if (subscriber == 0) {
                item.attr('data-subscriber', 1);
            } else {
                item.attr('data-subscriber', 0);
            }

            $app.gridItemsData('magazine');

        });

        // Item Delete
        itemDelete.on('click', function (e) {
            e.preventDefault();
            var c = confirm('Tem certeza que deseja deletar está página?');

            if (c == true) {
                $(this).closest('.item').remove();
            }

            $app.gridItemsData('magazine');

        });


    }

    Magazine.prototype.init = function () {

        $self = this;
        $app  = $.App;

        this.initFilesManager();
        this.managerPDF();
        this.actionItems();
    }

    //init
    $.Magazine = new Magazine, $.Magazine.Constructor = Magazine
}
(window.jQuery),

    //initializing
    function ($) {
        "use strict";
        $.Magazine.init();
    }(window.jQuery);

