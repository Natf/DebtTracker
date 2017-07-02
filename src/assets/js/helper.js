function check() {
    "use strict";

    if (typeof Symbol == "undefined") return false;
    try {
        var test = eval('"use strict"; class foo {}');
    } catch (e) {
        return false;
    }
    if (test === "use strict") return false;

    return true;
}

if (check()) {
    console.log('Using es6');
} else {
    console.log('Using es5');
    let imported = document.createElement('script');
    imported.src = '/src/assets/js/main.js';
    document.head.appendChild(imported);
}