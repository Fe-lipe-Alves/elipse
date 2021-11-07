
const receiverListItemClick = function () {
    $('.receiver-list-item').each((index, item) => {
        $(item).removeClass('bg-primary-500-light shadow-md').addClass('hover:bg-white')
    })

    $(this).addClass('bg-primary-500-light shadow-md').removeClass('hover:bg-white')

    $('#receiver_id').val($(this).data('id'))
}

const checkContent = () => {
    return $('#text-new-message').val() !== '' || $('#files')[0].files.length > 0
}

const checkContentSend = function () {
    if (checkContent()) {
        $('#btn-send').removeClass('bg-white').addClass('bg-primary-500').prop('disabled', false)
    } else {
        $('#btn-send').addClass('bg-white').removeClass('bg-primary-500').prop('disabled', true)
    }
}

const changeBoxInputFile = function () {
    let boxFile = $('#box-files-name'),
        boxInput = $('#box-input-text'),
        inputFiles = $('#files'),
        countFiles = inputFiles[0].files.length

    $('#text-new-message').val('')

    if (countFiles > 0) {
        let names = []

        $(inputFiles[0].files).each((index, item) => {
            names.push(item.name)
        })
        names = names.join(', ')

        boxInput.addClass('hidden')
        boxFile.removeClass('hidden')
        boxFile.find('#length').text(countFiles)
        boxFile.find('#files-name').html(names).attr('title', names)
    } else {
        boxInput.removeClass('hidden')
        boxFile.addClass('hidden')
    }
}

const sendMessage = () => {
    let text = $('#text-new-message').val(),
        files = $('#files')[0].files,
        form = $('#newMessage'),
        formData = new FormData(form[0])

    // for (let i=0; i < files.length; i++) {
    //     formData.append('files[]')
    // }

    $.ajax({
        url: form.attr('action'),
        type: 'post',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        dataType: 'json',
        success: function(response) {
            console.log(response)
        }
    })

    // if (text !== '') {
    //     formData.append('')
    // }
}

$(document).ready(function () {

    $('.receiver-list-item').on('click', receiverListItemClick)

    $('#text-new-message').on('keyup', function () {
        checkContentSend()
    })

    $('#btn-file').on('click', function () {
        $('#files').click()
    })

    $('#files').on('change', function () {
        changeBoxInputFile()
        checkContentSend()
    })

    $('#newMessage').on('submit', function (event) {
        event.preventDefault()
        sendMessage()
    })
})
