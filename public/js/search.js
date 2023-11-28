// 非同期での検索⇒1119スタート

// //11/20の1on1での学び
// ⇒非同期通信では値をとばすだけ！なので、検索のメソッドはコントロールのindex部分に記述する
// ⇒各フォームからのrequestの値を「シリアライズ」というプラグインを使用してajaxに使用する
// ajax通信が成功した時の動作を.doneに記述し、.failに失敗の時を記述する
// .doneで使用するプラグイン
//find()⇒特定部分を抜き出す⇒ビューファイルの中から抜き出す
// html（）⇒抜き出したデータをビューに表示させる変数に変換　id=prpduct_table



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
            dataType: 'text', 
            data: {'request': formData},
        })
        .done(function(search){
        // doneの部分でデータを飛ばしたあとの処理を書かないといけない。
        //find()⇒特定部分を抜き出す⇒ビューファイルの中から抜き出す
        // html（）⇒抜き出したデータをビューに表示させる変数に変換id=prpduct_table
            console.log(search.products);
        })
        .fail(function(){
            alert('エラー')
        });
    });
});










