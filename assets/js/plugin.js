(function ($) {
    'use strict';

    var data = window.mypluginData || {};
    var debugEnabled = !!data.debug;

    function log(message) {
        if (debugEnabled && window.console) {
            console.log('[MyPlugin] ' + message);
        }
    }

    function getScrollbarWidth() {
        var div = $('<div style="width:50px;height:50px;overflow:scroll;position:absolute;top:-9999px;"></div>');
        $('body').append(div);
        var w = div[0].offsetWidth - div[0].clientWidth;
        div.remove();
        return w;
    }

    function openItem(itemId) {
        var $item = $(itemId);

        if (!$item.length) {
            log('Item not found: ' + itemId);
            return;
        }

        if (!$item.hasClass('myplugin-item--modal') && !$item.hasClass('myplugin-item--popup')) {
            log('Item is not a modal/popup type: ' + itemId);
            return;
        }

        var scrollbarWidth = getScrollbarWidth();
        $('body').css('padding-right', scrollbarWidth).addClass('myplugin-modal-open');
        $item.addClass('active');
        log('Opened: ' + itemId);
    }

    function closeItem(itemId) {
        var $item = $(itemId);
        $item.removeClass('active');
        $('body').css('padding-right', '').removeClass('myplugin-modal-open');

        if (window.history && window.history.pushState) {
            window.history.pushState('', document.title, window.location.pathname + window.location.search);
        }

        log('Closed: ' + itemId);
    }

    function closeAll() {
        $('.myplugin-item--modal.active, .myplugin-item--popup.active').each(function () {
            closeItem('#' + this.id);
        });
    }

    $(document).on('click', 'a[href*="#myplugin_item"]', function (e) {
        var href = $(this).attr('href');
        var target = href.substring(href.indexOf('#'));

        if ($(target).length && ($(target).hasClass('myplugin-item--modal') || $(target).hasClass('myplugin-item--popup'))) {
            e.preventDefault();
            openItem(target);
        }
    });

    $(document).on('click', '.myplugin-item__close', function (e) {
        e.preventDefault();
        closeAll();
    });

    $(document).on('click', function (e) {
        if ($(e.target).hasClass('myplugin-item--modal') || $(e.target).hasClass('myplugin-item--popup')) {
            closeAll();
        }
    });

    $(document).on('keyup', function (e) {
        if (e.keyCode === 27) {
            closeAll();
        }
    });

    function checkHash() {
        var hash = window.location.hash;
        if (hash && hash.indexOf('#myplugin_item') === 0) {
            openItem(hash);
        }
    }

    window.onhashchange = checkHash;

    $(document).ready(function () {
        checkHash();
        log('Initialized');
    });
})(jQuery);
