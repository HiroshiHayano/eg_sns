// window.onload = function(){
//     alert("Hello World!");
// }

$(document).ready(function(){
    // $('.comment').hide();
    // $('.comment_opener').on('click', function() {
    //     var self = $(this);
    //     if (self.data('opened')) {
    //         $(this).html('&#9661;')
    //         self.data('opened', false);
    //     } else {
    //         $(this).html('&#9651;')
    //         self.data('opened', true);
    //     }
    //     $(this).next('.comment').toggle(250);
    // });


    // $('.answer_form').hide();
    // $('.answer_button').on('click', function() {
    //     var self = $(this);
    //     if (self.data('opened')) {
    //         $(this).text('回答する')
    //         self.data('opened', false);
    //     } else {
    //         $(this).text('回答を閉じる')
    //         self.data('opened', true);
    //     }
    //     $('.answer_form').toggle(250);
    // });

    $(function() {
        $('input[type=file]').after('<span></span>');
        // アップロードするファイルを選択
        $('input[type=file]').change(function() {
            var file = $(this).prop('files')[0];
            // 画像以外は処理を停止
            if (! file.type.match('image.*')) {
                // クリア
                $(this).val('');
                $('span').html('');
                return;
            }
            // 画像表示
            var reader = new FileReader();
            reader.onload = function() {
                var img_src = $('<img>').attr({'src': reader.result, 'width': 'auto', 'height': 150});
                $('span#thumbnail').html(img_src);
            }
            reader.readAsDataURL(file);
        });
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});
