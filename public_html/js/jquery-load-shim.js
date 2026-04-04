// 1. Restores jQuery 1.x .load(fn) event shorthand for jQuery 3 compatibility.
//    Required by waypoints-min.js v2.x which uses $(window).load(fn).
(function ($) {
    var originalLoad = $.fn.load;
    $.fn.load = function (url, params, callback) {
        if (typeof url === 'function') {
            return this.on('load', url);
        }
        return originalLoad.apply(this, arguments);
    };
}(jQuery));

// 2. Force touch/wheel event listeners to be non-passive so legacy plugins
//    (Revolution Slider, Owl Carousel) can call preventDefault() without
//    browser intervention warnings.
(function () {
    var passiveEvents = ['touchstart', 'touchmove', 'wheel', 'mousewheel'];
    var original = EventTarget.prototype.addEventListener;
    EventTarget.prototype.addEventListener = function (type, fn, options) {
        if (passiveEvents.indexOf(type) !== -1) {
            if (typeof options !== 'object') {
                options = { capture: !!options, passive: false };
            } else if (options.passive !== false) {
                options = Object.assign({}, options, { passive: false });
            }
        }
        return original.call(this, type, fn, options);
    };
}());
