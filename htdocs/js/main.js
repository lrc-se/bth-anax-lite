(function(win, doc) {
    
    "use strict";
    
    function forEach(sel, func) {
        Array.prototype.forEach.call(doc.querySelectorAll(sel), func);
    }
    
    function toggleMenu(e) {
        e.preventDefault();
        e.stopPropagation();
        var li = e.target.parentElement;
        var isOpen = li.classList.contains("open");
        var level = +li.getAttribute("data-level");
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
            li.classList.add("open");
        }
    }
    
    forEach(".navbar .sub > a, .navbar .sub > span", function(el) {
        el.addEventListener("click", toggleMenu);
    });
    doc.addEventListener("click", function() {
        forEach(".navbar .sub", function(el) {
            el.classList.remove("open");
        });
    });
    
})(window, document);
