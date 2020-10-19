require('jquery/dist/jquery.min');
require('jquery-ui-dist/jquery-ui.min');

// Resolve conflict in jQuery UI tooltip with Bootstrap tooltip
$.widget.bridge('uibutton', $.ui.button);

require('bootstrap/dist/js/bootstrap.bundle.min');
//require('chart.js/dist/Chart.bundle.min');
//require('sparklines/source/sparkline');
//require('jqvmap-novulnerability/dist/jquery.vmap.min');
require('jquery-knob-chif/dist/jquery.knob.min');
// require('moment/min/moment-with-locales.min');
// require('daterangepicker/daterangepicker');
// require('tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min');
// require('summernote/dist/summernote');
require('overlayscrollbars/js/OverlayScrollbars.min');
require('./adminlte/adminlte');
// require('./adminlte/pages/dashboard');
require('./adminlte/demo');
