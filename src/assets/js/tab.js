jQuery(document).ready(function($) {
    

function Plugin(option) {
return this.each(function() {
var $this = $(this);
var data = $this.data("bs.tab");
if (!data) {
$this.data("bs.tab", data = new Tab(this));
}
if (typeof option == "string") {
data[option]();
}
});
}
var Tab = function(element) {
this.element = $(element);
};
Tab.VERSION = "3.2.0";
Tab.prototype.show = function() {
var $this = this.element;
var $ul = $this.closest("ul:not(.dropdown-menu)");
var selector = $this.data("target");
if (!selector) {
selector = $this.attr("href");
selector = selector && selector.replace(/.*(?=#[^\s]*$)/, "");
}
if ($this.parent("li").hasClass("active")) {
return;
}
var previous = $ul.find(".active:last a")[0];
var e = $.Event("show.bs.tab", {
relatedTarget : previous
});
$this.trigger(e);
if (e.isDefaultPrevented()) {
return;
}
var $target = $(selector);
this.activate($this.closest("li"), $ul);
this.activate($target, $target.parent(), function() {
$this.trigger({
type : "shown.bs.tab",
relatedTarget : previous
});
});
};
Tab.prototype.activate = function(element, container, callback) {
function next() {
$active.removeClass("active").find("> .dropdown-menu > .active").removeClass("active");
element.addClass("active");
if (transition) {
element[0].offsetWidth;
element.addClass("in");
} else {
element.removeClass("fade");
}
if (element.parent(".dropdown-menu")) {
element.closest("li.dropdown").addClass("active");
}
if (callback) {
callback();
}
}
var $active = container.find("> .active");
var transition = callback && ($.support.transition && $active.hasClass("fade"));
if (transition) {
$active.one("bsTransitionEnd", next).emulateTransitionEnd(150);
} else {
next();
}
$active.removeClass("in");
};
var old = $.fn.tab;
$.fn.tab = Plugin;
$.fn.tab.Constructor = Tab;
$.fn.tab.noConflict = function() {
$.fn.tab = old;
return this;
};
$(document).on("click.bs.tab.data-api", '[data-toggle="tab"], [data-toggle="pill"]', function(e) {
e.preventDefault();
Plugin.call($(this), "show");
});

});