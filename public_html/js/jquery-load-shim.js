// Restores jQuery 1.x .load(fn) event shorthand for jQuery 3 compatibility.
// Required by waypoints-min.js v2.x which uses $(window).load(fn).
(function ($) {
    var originalLoad = $.fn.load;
    $.fn.load = function (url, params, callback) {
        if (typeof url === 'function') {
            return this.on('load', url);
        }
        return originalLoad.apply(this, arguments);
    };
}(jQuery));
