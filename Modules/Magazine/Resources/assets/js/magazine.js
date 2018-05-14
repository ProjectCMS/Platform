var listPDF  = $(".grid"),
    pdfjsLib = window['pdfjs-dist/build/pdf'];
$(document).ready(function () {

    //***** IMAGE MANAGER *****//
    $('.manager-image').on("click", function (e) {
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
                               headers: {'X-CSRF-TOKEN': token}
                           }, {storage: storage}, function (data) {
                        $.each(data, function (index, value) {
                            pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';
                            pdfToPNG(index, value);
                        });

                    });

                    // swal({
                    //          title: 'Auto close alert!',
                    //          text: 'I will close in 5 seconds.',
                    //          onOpen: function () {
                    //              swal.showLoading();
                    //          }
                    //      });
                }
            }
        );
    });

});

function pdfToPNG (index, url) {

    var loadingTask = pdfjsLib.getDocument(url.url),
        list        = listPDF.append('<div class="item" id="' + index + '">' +
            '<div class="pdf-content">\n' +
            '<div class="load"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i>\n' +
            '<span>Carregando...</span></div>' +
            '</div>' +
            '</div>');

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
                var content = list.find('#' + index + ' .pdf-content');
                content.append('<img src="' + canvas.toDataURL('image/jpeg', 1.0) + '">');
            });

        });
    }, function (reason) {
        console.error(reason);
    });
}
