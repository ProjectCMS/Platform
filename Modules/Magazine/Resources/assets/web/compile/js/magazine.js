!function ($) {
    "use strict";
    var Magazine = function () {
        },
        $self;

    Magazine.prototype.initMagazine = function () {
        $('.manager-magazine').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);
            $this.magazine(
                {
                    data: $this.data(),
                    headers: {'X-CSRF-TOKEN': $self.token},
                    url: 'magazine/show',
                    urlPremium: 'magazine/premium',
                });
        });
    }

    Magazine.prototype.init = function () {
        $self = this;
        this.token = $('meta[name="csrf-token"]').attr('content');
        this.initMagazine();
    }

    //init
    $.Magazine = new Magazine, $.Magazine.Constructor = Magazine
}(window.jQuery),

    //initializing
    function ($) {
        "use strict";
        $.Magazine.init();
    }(window.jQuery);
