require('./filedrop')

let formData = new FormData($('#form-work')[0])

const addFileTable = file => {
    let html =
        '<tr class="item-file">\n' +
        '<th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">\n' +
        file.name +
        '</th>\n' +
        '<td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">\n' +
        file.extension +
        '</td>\n' +
        '<td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">\n' +
        file.size +
        '</td>\n' +
        '<td class="w-12 border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">\n' +
        '<button data-uuid="'+ file.uuid +'" type="button" class="remove-file bg-gray-200 text-black font-bold px-2 py-1 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"><i class="fas fa-minus"></i></button>'
        '</td>\n' +
        '</tr>'

    $('#table-files tbody').append(html)
}

const checkHasFiles = () => {
    if ($('.remove-file').length > 0) {
        $('#table-files').removeClass('hidden')
    } else {
        $('#table-files').addClass('hidden')
        $('#table-files tbody').html('')
    }
}

$(document).ready(function() {

    $('#students_class_id').on('change', function() {
        let route = $(this).find(':selected').data('teachers'),
            selectTeacher = $('#lesson_id')

        selectTeacher.prop('disabled', true).html('')

        $.get(route).then( response => {
            if (response.success) {
                response.lessons.forEach((item) => {
                    selectTeacher.append('<option value="' + item.id + '">' + item.subject.description + '</option>')
                })
            }

            selectTeacher.prop('disabled', false)
        })
    })

    $('#box-input-file').filedrop({
        input: $('#files'),
        render: addFileTable,
        callback: checkHasFiles,
        formData
    })

    $('#form-work').on('submit', function (event) {
        event.preventDefault()

        let form = new FormData($(this)[0])
        form.delete('files')
        for(let pair of form.entries()) {
            formData.append(pair[0], pair[1])
        }

        $.ajax({
            url: $(this).attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(response){
                if (response.success) {
                    $(location).attr('href', response.route)
                } else {
                    if (Object.hasOwnProperty(response.error)) {
                        alert('erro');
                    }
                }
            }
        })
    })

    $(document).on('click', '.remove-file', function () {
        formData.delete($('#files').attr('name')+'['+$(this).attr('data-uuid')+']')
        $(this).parents('tr.item-file').remove()

        checkHasFiles()
    })

    $('.remove-file-uploaded').on('click', function () {
        $(this).parent().append('<input type="hidden" name="deletefile[]" value="' + $(this).data('id') + '"/>')
        $(this).parents('.item-file').hide()
    })
})
