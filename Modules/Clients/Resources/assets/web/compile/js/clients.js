!function ($) {
    "use strict";
    var Clients = function () {
        },
        $self;

    Clients.prototype.init = function () {
        $self      = this;
    }

    //init
    $.Clients = new Clients, $.Clients.Constructor = Clients
}(window.jQuery),

    //initializing
    function ($) {
        "use strict";
        $.Clients.init();
    }(window.jQuery);



