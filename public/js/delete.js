$(function() {
    $('#delete-js').click(function() {
        var deleteConfirm = confirm('削除してよろしいですか？');

        if(deleteConfirm == true){
            var clickEle = $(this)//thisはinputタグを参照する
            var productID = clickEle.attr('data-product_id');
            console.log(productID);
            
            $.ajaxSetup({
                headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),},
            });
            //非同期通信
            $.ajax({
                type: 'POST',
                url: '/destroy/'+ productID,
                dataType: 'json',
                data:{'id': productID},
            })
            
            .done(function(){
                alert('成功！');
            })
            .fail(function(){
                alert('失敗！')
            })
        }else{
            (function(e) {
                e.preventDefault()
            });
        };
    });
});