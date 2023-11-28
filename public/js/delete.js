$(function() {
    $(".delete-btn").click(function(e) {
        var deleteConfirm = confirm('削除してよろしいですか？');
        e.preventDefault()

        if(deleteConfirm == true){
            var clickEle = $(this)//thisはinputタグを参照する
            var productID = clickEle.attr('data-product_id');

            $.ajaxSetup({
                headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),},
            });
            
            //非同期通信
            $.ajax({
                type: 'POST',//GETはパラメーターに表示される、POSTは表示されない
                url: '/destroy/'+ productID,
                dataType: 'text', //dataTypeは返ってくる値のデータタイプ
                data:{'id': productID},
            })
            .done(function(){
                //削除されるIDのtrを画面から削除をする⇒remove()
                clickEle.parents('tr').remove();
            })
            .fail(function(){
                alert('エラー')
            });
        }else{
            (function(e) {
                e.preventDefault()
            });
        };
    });
});