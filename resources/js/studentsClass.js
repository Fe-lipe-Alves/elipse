function active(element) {
    if (element.data('active')) {
        element.addClass('bg-transparent hover:bg-blue-100')
            .removeClass('bg-blue-200 hover:bg-blue-300')
            .attr('data-active', 'false')
            .data('active', false)
    } else {
        element.removeClass('bg-transparent hover:bg-blue-100')
            .addClass('bg-blue-200 hover:bg-blue-300')
            .attr('data-active', 'true')
            .data('active', true)
    }
}

function sendToClass(element) {
    element.data('list', 'class')
}

function addList(from, to) {
    $('#list-' + from + ' button.student[data-active="true"]').each( ( index, item ) => {
        let list = $('#list-' + to),
            newItem = $($(item).clone()).appendTo(list),
            id = $(item).attr('data-id');

        $(item).hide()
        newItem.attr('data-list', to).append('<input type="hidden" name="students[]" value="' + id + '">')
        active(newItem)
    })
}

function removeList(from, to) {
    $('#list-' + from + ' button.student[data-active="true"]').each( ( index, item ) => {
        let id = $(item).attr('data-id'),
            oldItem = $('#list-all').find('[data-id="' + id + '"]')

        $(item).remove()
        oldItem.show()
        active(oldItem)
    })
}

$(document).ready(function() {

    $(document).on('click', '.student', function() {
        // if ($(this).data('list') === 'all') {
            active($(this))
        // }
    })

    $('#add-class').on('click', function() {
        addList('all', 'class')
    })

    $('#remove-class').on('click', function() {
        removeList('class', 'all')
    })
})
