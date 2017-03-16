
window._ = require('lodash');

//load Jquery & bootstrap
window.$ = window.jQuery = require('jquery');
require('vue-resource');
//load bootstrap
require('bootstrap-sass');
//load custom js
require('./navbar-autohide');
require('./alert-autohide');
require('./indent-textarea-by-tab');
require('./script');
