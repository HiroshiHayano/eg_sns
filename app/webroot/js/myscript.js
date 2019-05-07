// window.onload = function(){
//     alert("Hello World!");
// }

$(document).ready(function(){
    $('.comment').hide();
    $('.comment_opener').on('click', function() {
        var self = $(this);
        if (self.data('opened')) {
            $(this).html('&#9661;')
            self.data('opened', false);
        } else {
            $(this).html('&#9651;')
            self.data('opened', true);
        }
        $(this).next('.comment').toggle(250);
    });


    $('.answer_form').hide();
    $('.answer_button').on('click', function() {
        var self = $(this);
        if (self.data('opened')) {
            $(this).text('回答する')
            self.data('opened', false);
        } else {
            $(this).text('回答を閉じる')
            self.data('opened', true);
        }
        $('.answer_form').toggle(250);
    });

    // $('.question_edit_layer').hide();
    // $('.question_edit_opener').on('click', function() {
    //     $('.question_edit_layer').show(250);
    // });
    // $('.question_edit_closer').on('click', function() {
    //     $('.question_edit_layer').hide(250);
    // });

    // $('#postform_layer').hide();
    // $('button#postform_opener').on('click', function() {
    //     $('#postform_layer').show(250);
    // });
    // $('button#postform_closer').on('click', function() {
    //     $('#postform_layer').hide(250);
    // });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});
