!function ($) {
    "use strict";
    var Tracker = function () {
        },
        $self,
        $app;

    Tracker.prototype.initMainChart = function () {
        //creating bar chart
        var $barData = [
            {y: '2006', a: 100, b: 90},
            {y: '2007', a: 75, b: 65},
            {y: '2008', a: 50, b: 40},
            {y: '2009', a: 75, b: 65},
            {y: '2010', a: 50, b: 40},
            {y: '2011', a: 75, b: 65},
            {y: '2012', a: 100, b: 90},
            {y: '2013', a: 90, b: 75},
            {y: '2014', a: 75, b: 65},
            {y: '2015', a: 50, b: 40},
            {y: '2016', a: 75, b: 65},
            {y: '2017', a: 100, b: 90}
        ];
        $self.createBarChart('morris-bar-example', $barData, 'y', ['a', 'b'], ['Series A', 'Series B'], ['#2f8ee0', '#4bbbce']);

    }

    //creates Bar chart
    Tracker.prototype.createBarChart = function (element, data, xkey, ykeys, labels, lineColors) {
        if (document.getElementById(element) !== null) {
            Morris.Bar({
                           element: element,
                           data: data,
                           xkey: xkey,
                           ykeys: ykeys,
                           labels: labels,
                           gridLineColor: 'rgba(255,255,255,0.1)',
                           gridTextColor: '#98a6ad',
                           barSizeRatio: 0.2,
                           resize: true,
                           hideHover: 'auto',
                           barColors: lineColors
                       });
        }
    }

    Tracker.prototype.init = function () {
        $self = this;
        $app  = $.App;

        $self.initMainChart();

    }

    //init
    $.Tracker = new Tracker, $.Tracker.Constructor = Tracker
}(window.jQuery),

    //initializing
    function ($) {
        "use strict";
        $.Tracker.init();
    }(window.jQuery);
