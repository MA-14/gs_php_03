<?php

require_once('funcs.php');

//1. POSTデータ取得
$name = $_POST['name'];
$getscore = $_POST['getscore'];
$lostscore = $_POST['lostscore'];
$comment = $_POST['comment'];
$id = $_POST['id'];

if ($getscore>$lostscore){
  $winlose = "win";
}elseif($getscore<$lostscore){
  $winlose = "lose";
}else{
  $wijnlose = "draw";
}

$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("UPDATE 
                        bb_predict 
                      SET 
                        name = :name,
                        getscore = :getscore,
                        lostscore = :lostscore,
                        winlose = :winlose,
                        comment = :comment,
                        date = sysdate()
                      WHERE
                        id = :id;");


// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':getscore', $getscore, PDO::PARAM_INT);
$stmt->bindValue(':lostscore', $lostscore, PDO::PARAM_INT);
$stmt->bindValue(':winlose', $winlose, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    //*** function化する！******\
    sql_error($stmt);
    // $error = $stmt->errorInfo();
    // exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    redirect("select.php");
    // header('Location: index.php');
    // exit();
}
