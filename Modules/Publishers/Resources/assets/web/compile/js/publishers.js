!function ($) {
    "use strict";
    var Publishers = function () {
        },
        $self;

    Publishers.prototype.initAds = function () {

        var adsHtml = $('.ads'),
            adsJson = {},
            count   = {wide: 0, box: 0};

        $self.showAds(function (data) {

            adsJson.wide = data['wide'];
            adsJson.box  = data['box'];

            $.each(adsHtml, function (index, val) {

                if (adsJson.wide) {
                    if ($(this).data('ads') == 'wide') {
                        $self.setHtmlAds($(this), adsJson.wide[count.wide]);
                        count.wide++;
                    }
                }

                if (adsJson.box) {
                    if ($(this).data('ads') == 'box') {
                        $self.setHtmlAds($(this), adsJson.box[count.box]);
                        count.box++;
                    }
                }
            });
        });
    }

    Publishers.prototype.setHtmlAds = function (ads, item) {

        if (item.image_link != null) {
            ads.html('<div class="box-image" style="width: 100%"><img src="' + item.image_link + '" title="' + item.title + '"></div>');
            if (item.url != null) {
                ads.wrap('<a href="' + web.urlPublishersRedirect + '?url=' + item.url + '" target="_blank"></a>');
            }
        }

    }

    Publishers.prototype.showAds = function (callback) {
        $.post({
                   url: web.urlPublishers,
                   headers: {'X-CSRF-TOKEN': web.token}
               }, function (data) {
            callback(data);
        });
    }

    Publishers.prototype.init = function () {
        $self = this;

        this.initAds();

    }

    //init
    $.Publishers = new Publishers, $.Publishers.Constructor = Publishers
}(window.jQuery),

    //initializing
    function ($) {
        "use strict";
        $.Publishers.init();
    }(window.jQuery);
