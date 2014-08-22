$(document).ready(function () {
    var $main = $('#page-container'),
        $pages = $main.children('section'),
        $steps = $('nav li'),
    //$navIndicator = $("#nav-indicator"),
        $nextButton = $('#next-button'),
        $prevButton = $('#prev-button'),
        pagesCount = $pages.length,
        current = 0,
        stepsUnlocked = 0,
        isAnimating = false,
        endCurrPage = false,
        endNextPage = false,
        animEndEventNames = {
            'WebkitAnimation': 'webkitAnimationEnd',
            'OAnimation': 'oAnimationEnd',
            'msAnimation': 'MSAnimationEnd',
            'animation': 'animationend'
        },
    // animation end event name
        animEndEventName = animEndEventNames[ Modernizr.prefixed('animation') ],
    // support css animations
        support = Modernizr.cssanimations;

    $pages.each(function () {
        var $page = $(this);
        $page.data('originalClassList', $page.attr('class'));
    });

    $steps.click(function () {
        var index = $(this).index();
        if (index <= stepsUnlocked) {
            gotoPage($(this).index());
        }
    });

    $steps.eq(current).addClass('active-step');
    $pages.eq(current).addClass('page-current');

    $nextButton.on('click', function () {
        if (isAnimating) {
            return false;
        }
        nextPage();
    });

    $prevButton.on('click', function () {
        if (isAnimating) {
            return false;
        }
        previousPage();
    });

    function gotoPage(pageNumber) {
        if (isAnimating || pageNumber === current || pageNumber > stepsUnlocked) {
            return false;
        }

        isAnimating = true;

        var $currPage = $pages.eq(current);
        var $currStep = $steps.eq(current);

        $currStep.removeClass("active-step");

        var outClass = '', inClass = '';

        if (current > pageNumber) {
            outClass = 'page-scaleDown';
            inClass = 'page-moveFromTop page-ontop';
        }
        else {
            outClass = 'page-scaleDown';
            inClass = 'page-moveFromBottom page-ontop';
        }

        current = pageNumber;

        var $nextPage = $pages.eq(current).addClass('page-current');
        $steps.eq(current).addClass('active-step');

        $currPage.addClass(outClass).on(animEndEventName, function () {
            $currPage.off(animEndEventName);
            endCurrPage = true;
            if (endNextPage) {
                onEndAnimation($currPage, $nextPage);
            }
        });

        $nextPage.addClass(inClass).on(animEndEventName, function () {
            $nextPage.off(animEndEventName);
            endNextPage = true;
            if (endCurrPage) {
                onEndAnimation($currPage, $nextPage);
            }
        });

        //TweenLite.to($navIndicator, 0.6, { y: 90 * current, ease:Power2.easeOut } );

        if (!support) {
            onEndAnimation($currPage, $nextPage);
        }

    }

    function nextPage() {
        if (current < pagesCount - 1) {
            stepsUnlocked = current + 1;
            gotoPage(stepsUnlocked);
        }
        else {
            gotoPage(0);
            stepsUnlocked = 0;
        }
    }

    function previousPage() {
        if (current > 0) {
            gotoPage(current - 1);
            stepsUnlocked = current;
        }
        else {
            gotoPage(pagesCount - 1);
            stepsUnlocked = pagesCount - 1;
        }
    }

    function onEndAnimation($outpage, $inpage) {
        endCurrPage = false;
        endNextPage = false;
        resetPage($outpage, $inpage);
        isAnimating = false;
    }

    function resetPage($outpage, $inpage) {
        $outpage.attr('class', $outpage.data('originalClassList'));
        $inpage.attr('class', $inpage.data('originalClassList') + ' page-current');
    }

    setInterval(nextPage, 12000);




    var $window = $(window);
    var $pageContainer = $("#page-container");
    var $footer = $("#footer");
    var footerHeight = $footer.outerHeight();
    $window.resize(function () {
        var width = $window.width();
        var height = $window.height();
        var pageHeight = height - footerHeight;
        $pageContainer.css('height',pageHeight + 'px' );
        $(".height-33").css("height", Math.floor(pageHeight / 3) + "px");
        $(".height-50").css("height", Math.floor(pageHeight / 2) + "px");
        $(".height-100").css("height", pageHeight + "px");

    }).resize();

    $('.posts').vTicker('init', {speed: 400,
        pause: 4000,
        showItems: 1,
        padding: 4});

    /*$('.anniversaries').vTicker('init', {speed: 400,
        pause: 4000,
        showItems: 2,
        padding: 4});*/


});
