$(document).ready(function() {

    $('input[name="type_of_user_id"]').on('change', function() {
        if ($(this).val() === '1') {
            $('#input-ra').removeClass('hidden').find('input').prop('required', true)
            $('#input-cpf').addClass('hidden').find('input').prop('required', false)
        } else {
            $('#input-cpf').removeClass('hidden').find('input').prop('required', true)
            $('#input-ra').addClass('hidden').find('input').prop('required', false)
        }
    })

})