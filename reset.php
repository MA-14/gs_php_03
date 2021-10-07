<?php
require_once('funcs.php');

$score0="score0.txt";
$score1="score1.txt";
$score2="score2.txt";
$score3="score3.txt";
$score4="score4.txt";
$score5="score5.txt";
$score6="score6.txt";
$score7more="score7more.txt";

//テキストファイルを削除
deleateContent($score0);
deleateContent($score1);
deleateContent($score2);
deleateContent($score3);
deleateContent($score4);
deleateContent($score5);
deleateContent($score6);
deleateContent($score7more);

//db接続
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare('DELETE FROM bb_predict' );
$status = $stmt->execute();

//３．データ表示
$view = '';
if ($status == false) {
    sql_error($status);
} else {
  redirect('select.php'); 
}