const Flash = function () {
    const handleFlash = function () {
        $(document).on('click', '.close-flash',function (){
            $('.flash').addClass('hide');
        });
    }

    return {
        init: function () {
            handleFlash();
        }
    }
}()

$(document).ready(function (){
    Flash.init();
});
