require('jquery/dist/jquery.min');
require('jquery-ui-dist/jquery-ui.min');

// Resolve conflict in jQuery UI tooltip with Bootstrap tooltip
$.widget.bridge('uibutton', $.ui.button);

require('bootstrap/dist/js/bootstrap.bundle.min');
require('jquery-knob-chif/dist/jquery.knob.min');
require('overlayscrollbars/js/OverlayScrollbars.min');
require('simplemde/dist/simplemde.min')
require('./adminlte');
