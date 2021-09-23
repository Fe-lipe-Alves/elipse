$(document).ready(function() {

    $('input[name="type_of_user_id"]').on('change', function() {
        let studentID = '2';
        if ($(this).val() === studentID) {
            $('#input-ra').removeClass('hidden').find('input').prop('required', true)
            $('#input-cpf').addClass('hidden').find('input').prop('required', false)
        } else {
            $('#input-cpf').removeClass('hidden').find('input').prop('required', true)
            $('#input-ra').addClass('hidden').find('input').prop('required', false)
        }
    })

})
