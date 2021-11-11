import $ from 'jquery/src/jquery';
window.$ = window.jQuery = $;
require('./message-control')

// require('@popperjs/core')
// require('bootstrap/dist/js/bootstrap')

function toggleNavbar(collapseID) {
    document.getElementById(collapseID).classList.toggle("hidden");
    document.getElementById(collapseID).classList.toggle("bg-white");
    document.getElementById(collapseID).classList.toggle("m-2");
    document.getElementById(collapseID).classList.toggle("py-3");
    document.getElementById(collapseID).classList.toggle("px-6");
}

function openDropdown(event, dropdownID) {
    const dropdown = document.getElementById(dropdownID),
          parentElement = $(event.target).parents('a, button')[0]

    $('[data-open="true"]').addClass('hidden').removeClass('block')

    Popper.createPopper(parentElement, dropdown, { placement: "bottom-end" });

    $('#'+dropdownID).addClass('block').removeClass('hidden').attr('data-open', 'true')
}

function closeDropdown(event, element) {
    if (
        $(event.target).parents('[data-interaction="dropdown"]').length === 0 &&
        $(event.target).parents('[data-hundle="dropdown"]').length === 0
    ) {
        element.classList.add("hidden");
        element.classList.remove("block");
    }
    event.stopPropagation()
}

$(document).ready(function () {
    $('[data-hundle="dropdown"]').on('click', function (event) {
        event.preventDefault()
        openDropdown(event, $(this).data('for'))
    })

    $(document).on('click', function (event) {
        $('[data-interaction="dropdown"]').each(function (index, item) {
            closeDropdown(event, item)
        })
    })

    $('#userHeaderBox #logout').on('click', function () {
        $('#formLogout').submit();
    })

    $('[data-action="destroy"]').on('click', function () {
        let formGeneric = $('#formGeneric')

        formGeneric.find('input[name="_method"]').val('delete')
        formGeneric.attr('action', $(this).data('route'))
        formGeneric.submit()
    })
})
