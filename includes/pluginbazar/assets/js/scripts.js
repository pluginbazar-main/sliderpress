/**
 * Pluginbazar Script
 */

(function ($, window, document) {
    "use strict";


    $(document).on('click', '.pluginbazar-metabox ul.tabs > li > a', function () {
        let thisTabItem = $(this).parent(), dataTarget = thisTabItem.data('target');

        thisTabItem.parent().find('li').removeClass('active');
        thisTabItem.addClass('active');

        $('div.content-' + dataTarget).parent().find('> div').removeClass('active');
        $('div.content-' + dataTarget).addClass('active');
    });


    $(document).on('ready', function () {

        let documentBody = $('body'), pluginbazarMeta = $('.pluginbazar-metabox'), locationArgs = window.location.href.split('#');

        if (documentBody.hasClass('wp-admin') && pluginbazarMeta.length && locationArgs[1].length > 0 ) {

            pluginbazarMeta.find('ul.tabs > li').removeClass('active');
            pluginbazarMeta.find('ul.tabs > li.item-' + locationArgs[1]).addClass('active');

            pluginbazarMeta.find('.tab-contents > div').removeClass('active');
            pluginbazarMeta.find('.tab-contents > div.content-' + locationArgs[1]).addClass('active');
        }
    });
})(jQuery, window, document);







