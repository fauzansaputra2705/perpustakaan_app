$(function () {
    'use strict'

    // Feather Icon Init Js
    // feather.replace();

    // =================================
    // Tooltip
    // =================================
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // =================================
    // Popover
    // =================================
    let popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })

    // increment & decrement
    $(document).on('click', '.minus,.add', function () {
        let $qty = $(this).closest('div').find('.qty'),
            currentVal = parseInt($qty.val()),
            isAdd = $(this).hasClass('add')
        if (!isNaN(currentVal)) {
            if (isAdd) {
                $qty.val(++currentVal)
            } else {
                if (currentVal > 0) {
                    $qty.val(--currentVal)
                } else {
                    $qty.val(currentVal)
                }
            }
        }
    })

    // ==============================================================
    // Collapsable cards
    // ==============================================================
    $(document).on('click', 'a[data-action="collapse"]', function (e) {
        e.preventDefault()
        $(this).closest('.card').find('[data-action="collapse"] i').toggleClass('ti-minus ti-plus')
        $(this).closest('.card').children('.card-body').collapse('toggle')
    })
    // Toggle fullscreen
    $(document).on('click', 'a[data-action="expand"]', function (e) {
        e.preventDefault()
        $(this).closest('.card').find('[data-action="expand"] i').toggleClass('ti-arrows-maximize ti-arrows-maximize')
        $(this).closest('.card').toggleClass('card-fullscreen')
    })
    // Close Card
    $(document).on('click', 'a[data-action="close"]', function () {
        $(this).closest('.card').removeClass().slideUp('fast')
    })

    // fixed header
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 60) {
            $('.app-header').addClass('fixed-header')
        } else {
            $('.app-header').removeClass('fixed-header')
        }
    })
})

/*change layout boxed/full */
$(document).on('click', '.full-width', function () {
    $('.container-fluid').addClass('mw-100')
    $('.full-width i').addClass('text-primary')
    $('.boxed-width i').removeClass('text-primary')
})
$(document).on('click', '.boxed-width', function () {
    $('.container-fluid').removeClass('mw-100')
    $('.full-width i').removeClass('text-primary')
    $('.boxed-width i').addClass('text-primary')
})

/*Dark/Light theme*/
$('.light-logo').hide()
$(document).on('click', '.dark-theme', function () {
    $('nav.navbar-light').addClass('navbar-dark')
    $('.dark-theme i').addClass('text-primary')
    $('.light-theme i').removeClass('text-primary')
    $('.light-logo').show()
    $('.dark-logo').hide()
})
$(document).on('click', '.light-theme', function () {
    $('nav.navbar-light').removeClass('navbar-dark')
    $('.dark-theme i').removeClass('text-primary')
    $('.light-theme i').addClass('text-primary')
    $('.light-logo').hide()
    $('.dark-logo').show()
})

/*Card border/shadow*/
$(document).on('click', '.cardborder', function () {
    $('body').addClass('cardwithborder')
    $('.cardshadow i').addClass('text-dark')
    $('.cardborder i').addClass('text-primary')
})
$(document).on('click', '.cardshadow', function () {
    $('body').removeClass('cardwithborder')
    $('.cardborder i').removeClass('text-primary')
    $('.cardshadow i').removeClass('text-dark')
})

$(document).on('click', '.change-colors li a', function () {
    $('.change-colors li a').removeClass('active-theme')
    $(this).addClass('active-theme')
})

/*Theme color change*/
function toggleTheme(value) {
    $('.preloader').show()
    let sheets = document.getElementById('themeColors')
    sheets.href = value
    $('.preloader').fadeOut()
}
$('.preloader').fadeOut()
