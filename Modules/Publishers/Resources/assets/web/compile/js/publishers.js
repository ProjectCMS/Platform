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

                if (adsJson.wide.length) {
                    if ($(this).data('ads') == 'wide') {
                        $self.setHtmlAds($(this), adsJson.wide[count.wide]);
                        count.wide++;
                    }
                }

                if (adsJson.box.length) {
                    if ($(this).data('ads') == 'box') {
                        $self.setHtmlAds($(this), adsJson.box[count.box]);
                        count.box++;
                    }
                }
            });
        });
    }

    Publishers.prototype.setHtmlAds = function (ads, item) {

        if (item.image != null) {
            ads.html('<img src="' + item.image + '" title="' + item.title + '">');
            if (item.url != null) {
                ads.wrap('<a href="' + item.url + '" target="_blank"></a>');
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
