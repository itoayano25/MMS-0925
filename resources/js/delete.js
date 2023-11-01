// 削除js
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});
$(function(){
    $('.btn btn-danger btn-sm mx-1').on('click', function(){
        var deleteConfirm = confirm('削除してもよろしいでしょうか？');
        if(deleteConfirm == true){
            var clickEle = $(this)
            var productID = clickEle.attr('data-product_id'); 

            $.ajax({
                type: 'POST',
                url: '/destroy/'+productID,
                dataType: 'json',
                data:{'id':productID},
            })
        }else{
            (function(e){
                e.preventDefault()
            });
        };
    });
});