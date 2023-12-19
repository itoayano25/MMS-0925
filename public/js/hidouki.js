$(function(){
    // 削除処理呼び出し
    hidoukidelete();
    // 検索処理
    $('.btn-search').on('click', function(e){
        e.preventDefault();

        // 検索ボタンを押したら、formのname属性からテキストデータを取ってくるserialize();をする
        let formData = $('.form_search').serialize();
        
        $.ajaxSetup({
            headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),},
        });    

        $.ajax({
                type: 'GET',//パラメーターに表示されるのがGET
                url: 'products',
                dataType: 'html', //Viewファイルでデータのやり取りをするのでhtml
                data: formData, //requestには勝手に飛ぶので、｛request:formData｝にしなくてもよい！
            })
        .done(function(data){
        // doneに帰ってきたindexviewファイルがfunction(data)に入っている（コントローラーのreturnが返ってくるもの）
            let newData =$(data).find('#products_table'); //findで帰ってきたdataの中からtableの中身だけを抽出
            $("#products_table").replaceWith(newData); //返ってきたtableの中身を差し替え！

        //ソートの部分⇒検索の段階でViewファイルを読み込み直しているので、ソートの関数をここでももう一度読んであげる！
        $(".table_sort").tablesorter();

        // 削除処理も同様に呼び出し
        hidoukidelete();
        })
        .fail(function(){
            alert('エラー')
        });
    });
});


// 削除処理
function hidoukidelete(){
    $(".delete-btn").click(function(e) {
        let deleteConfirm = confirm('削除してよろしいですか？');
        e.preventDefault();

        if(deleteConfirm == true){
            let clickEle = $(this)//thisはinputタグを参照する
            let productID = clickEle.attr('data-product_id');

            $.ajaxSetup({
                headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),},
            });
            
            //非同期通信
            $.ajax({
                type: 'POST',//GETはパラメーターに表示される、POSTは表示されない
                url: '/destroy/'+ productID,
                dataType: 'text', //dataTypeはサーバーから返ってくる値のデータタイプ
                data:{'id': productID}, //サーバーに送信するデータ型（文字列||オブジェクト型）
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
};

//ソート処理
$(document).ready(function() { 
    $(".table_sort").tablesorter();
});









