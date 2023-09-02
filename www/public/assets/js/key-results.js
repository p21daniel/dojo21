let KeyResult = (() => {
    let handleForm = () => {
        $('#key-result-form').submit(function (event) {
            let keyResultForm = $(this).serialize();

            event.preventDefault();

            $.ajax({
                url: '/key-result/save',
                type: 'POST',
                data: keyResultForm,
                success: function (data) {
                    window.location.href = '/objective/list';
                }
            });
        });
    }

    let handleButtons = function () {
        $('#key_result_remove_button').click(function (){
            let id = $('#key_result_remove_button').val();

            $.ajax({
                url: '/key-result/remove',
                type: 'POST',
                data: {
                    id: id
                },
                success: function (data) {
                    window.location.href = '/objective/list';
                }
            });
        })

        $('#key_result_edit_button').click(function (){
            let id = $('#key_result_edit_button').val();

            $.ajax({
                url: '/key-result/edit',
                type: 'POST',
                data: {
                    id: id
                },

                success: function (data) {
                    window.location.href = '/key-result';
                }
            });
        })
    }

    return {
        init: () => {
            handleForm();
            handleButtons();
        }
    }
})();

$(document).ready(() => {
    KeyResult.init();
});