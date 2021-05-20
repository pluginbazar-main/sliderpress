/**
 * Pluginbazar Script
 */

(function ($, window, document, pluginbazar) {
    "use strict";

    $(function () {
        $(".repeater-items").sortable({handle: ".control.drag", revert: true});
    });


    $(document).on('click', '.pluginbazar-field.repeater .repeater-item .controls .control.close', function () {
        if (confirm(pluginbazar.confirmText)) {
            $(this).parent().parent().remove();
        }
    });

    $(document).on('click', '.pluginbazar-repeater-add', function () {

        let repeaterButton = $(this),
            repeaterItemsWrap = repeaterButton.parent().find('.repeater-items'),
            sourceItem = repeaterItemsWrap.find('.repeater-item:first-child'),
            allItems = repeaterItemsWrap.find('.repeater-item'),
            parentID = repeaterButton.data('parent-id'), newItem = $('<div class="repeater-item"></div>'), newItemHTML;


        newItemHTML = sourceItem.html().replaceAll(parentID + '[0]', parentID + '[' + allItems.length + ']');
        newItemHTML = newItemHTML.replaceAll(parentID + '_0_', parentID + '_' + allItems.length + '_');

        newItem.html(newItemHTML);
        newItem.find('.pluginbazar-field').each(function () {

            console.log($(this).find('input').val());

            $(this).find('input[type="text"], input[type="number"], input[type="email"], input[type="password"], input[type="hidden"]').val('');

            // For colorpicker
            $(this).find('.wp-color-result').css('background-color', '');
        });

        repeaterItemsWrap.append(newItem);
    });


    $(document).on('click', '.pluginbazar-metabox ul.tabs > li > a', function () {
        let thisTabItem = $(this).parent(), dataTarget = thisTabItem.data('target'), targetContent = $('div.content-' + dataTarget);

        thisTabItem.parent().find('li').removeClass('active');
        thisTabItem.addClass('active');

        targetContent.parent().find('> div').removeClass('active');
        targetContent.addClass('active');
    });


    $(document).on('ready', function () {

        let documentBody = $('body'), pluginbazarMeta = $('.pluginbazar-metabox'), locationArgs = window.location.href.split('#');

        if (documentBody.hasClass('wp-admin') &&
            typeof pluginbazarMeta !== 'undefined' && pluginbazarMeta.length &&
            typeof locationArgs[1] !== 'undefined' && locationArgs[1].length > 0) {

            pluginbazarMeta.find('ul.tabs > li').removeClass('active');
            pluginbazarMeta.find('ul.tabs > li.item-' + locationArgs[1]).addClass('active');

            pluginbazarMeta.find('.tab-contents > div').removeClass('active');
            pluginbazarMeta.find('.tab-contents > div.content-' + locationArgs[1]).addClass('active');
        }
    });
})(jQuery, window, document, pluginbazar);







