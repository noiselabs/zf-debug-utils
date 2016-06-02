/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

$(document).ready(function() {
    $('.zf-debug-utils__datatables').DataTable();
});

$('#zf-debug-utils__form__match-route').submit(function( event ) {
    event.preventDefault();

    var form = $(this);
    var formData = form.serializeArray();
    var progressPanel = $('.zf-debug-utils__route-match__panel.progress');
    var matchSuccessPanel = $('.zf-debug-utils__route-match__panel.panel-success');
    var matchFailedPanel = $('.zf-debug-utils__route-match__panel.panel-danger');

    progressPanel.show();
    matchSuccessPanel.hide();
    matchFailedPanel.hide();

    var jqxhr = $.get(form.prop('action'), formData);

    jqxhr.done(function( data ) {
        progressPanel.hide();
        if (data.routeMatch != null) {
            $('#zf-debug-utils__route-match__panel__source-method--success').html(data.requestedRouteData.method);
            $('#zf-debug-utils__route-match__panel__source-url--success').html(data.requestedRouteData.url);
            $('#zf-debug-utils__route-match__panel__match-name').html(data.routeMatch.name);
            $('#zf-debug-utils__route-match__panel__match-url').html(data.routeMatch.url);
            $('#zf-debug-utils__route-match__panel__match-controller').html(data.routeMatch.controller);
            $('#zf-debug-utils__route-match__panel__match-action').html(data.routeMatch.action);
            matchSuccessPanel.fadeIn();
        } else {
            $('#zf-debug-utils__route-match__panel__source-method--failed').html(data.requestedRouteData.method);
            $('#zf-debug-utils__route-match__panel__source-url--failed').html(data.requestedRouteData.url);
            matchFailedPanel.fadeIn();
        }
    });
});