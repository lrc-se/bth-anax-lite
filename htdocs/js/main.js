(function(win, doc) {
    
    "use strict";
    
    var toggle = doc.getElementById("menu-toggle");
    
    function forEach(sel, func) {
        Array.prototype.forEach.call(doc.querySelectorAll(sel), func);
    }
    
    function toggleMenu(e) {
        e.preventDefault();
        e.stopPropagation();
        var item = e.target.parentElement;
        var isOpen = item.classList.contains("open");
        var level = +item.getAttribute("data-level");
        console.log(level);
        if(level == 1) {
            forEach(".navbar .sub", function(el) {
                el.classList.remove("open");
            });
        } else {
            forEach(".navbar .sub", function(el) {
                if(+el.getAttribute("data-level") >= level) {
                    el.classList.remove("open");
                }
            });
        }
        if(!isOpen) {
            item.classList.add("open");
        }
    }
    
    forEach(".navbar .sub > a, .navbar .sub > span", function(el) {
        el.addEventListener("click", toggleMenu);
    });
    doc.addEventListener("click", function() {
        forEach(".navbar .sub", function(el) {
            el.classList.remove("open");
        });
        if(toggle.classList.contains("open")) {
            toggle.classList.toggle("open");
        }
    });
    toggle.addEventListener("click", function(e) {
        e.stopPropagation();
        toggle.classList.toggle("open");
    });
    
})(window, document);
