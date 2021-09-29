$(document).ready(function() {

    $('.class_schedule-item').on('click', function() {
        let selected = $(this).data('selected')

        if (selected) {
            $(this)
                .removeClass('bg-indigo-300 hover:bg-indigo-200')
                .addClass('hover:bg-indigo-100')
                .data('selected', !selected)
                .find('input').prop('checked', !selected)
        } else {
            $(this)
                .addClass('bg-indigo-300 hover:bg-indigo-200')
                .removeClass('hover:bg-indigo-100')
                .data('selected', !selected)
                .find('input').prop('checked', !selected)
        }
    })

})
