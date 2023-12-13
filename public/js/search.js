$(function(){
    $('.btn-search').click(function (){
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
            $("products_table").replaceWith(newData); //返ってきたtableの中身を差し替え！

        //ソートの部分⇒検索の段階でViewファイルを読み込み直しているので、ソートの関数をここでももう一度読んであげる！
        $(document).ready(function() { 
            $(".table_sort").tablesorter();
        });
        
        })
        .fail(function(){
            alert('エラー')
        });
    });
});










