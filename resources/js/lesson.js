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

    $('#optionsSelect select').on('change', function() {
        const teacher = $('#teacher_id').val(),
              students_class = $('#students_class_id').val()

        if  (teacher !== null && students_class !== null) {

            $.ajax({
                url: routeConsultHours,
                type: 'post',
                data: {
                    teacher_id: teacher,
                    students_class_id: students_class
                },
                dataType: 'json',
                success: function (response) {
                    if (Array.isArray(response)) {
                        response.forEach((item, index) => {
                            $('input[value="'+item+'"]').parent().addClass('bg-gray-100 hover:bg-gray-100')
                        })
                    }
                }
            })

        }
    })
})
