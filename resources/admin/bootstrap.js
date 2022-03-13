window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('datatables.net-bs4');

    require('bootstrap-4');
} catch (e) {}