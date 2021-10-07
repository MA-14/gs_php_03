<?php

require_once('funcs.php');

//勝敗に応じて書き込み用ファイル作成
$score0="score0.txt";
$score1="score1.txt";
$score2="score2.txt";
$score3="score3.txt";
$score4="score4.txt";
$score5="score5.txt";
$score6="score6.txt";
$score7more="score7more.txt";

//DB接続
$pdo = db_conn();

if ($_SERVER['REQUEST_METHOD']=='POST'){

  if (isset($_POST["getscore"]) && isset($_POST["lostscore"])){
    $name= trim($_POST['name']);
    $name = ($name==='')? '名無し':$name;
    $name = str_replace("\t", " ",$name);

    $comment= trim($_POST['comment']);
    $comment = str_replace("\t", " ",$comment);

    $getscore= $_POST["getscore"];
    $lostscore= $_POST["lostscore"];
    $postedAt = date('Y/m/d H:i:s');

    if ($getscore>$lostscore){
      $winlose = "win";
    }elseif($getscore<$lostscore){
      $winlose = "lose";
    }else{
      $winlose = "draw";
    }
  }else{
    $getscore= "";
    $lostscore= "";
  }

  if ($getscore!=="" && $lostscore!==""){

    //得点に応じて、該当ファイルに０を記入
      if ((int)$getscore===0){
        $fp = fopen($score0, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }elseif($getscore==1){
        $fp = fopen($score1, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }elseif($getscore==2){
        $fp = fopen($score2, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }elseif($getscore==3){
        $fp = fopen($score3, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }elseif($getscore==4){
        $fp = fopen($score4, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }elseif($getscore==5){
        $fp = fopen($score5, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }elseif($getscore==6){
        $fp = fopen($score6, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }elseif($getscore>=7){
        $fp = fopen($score7more, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }

      //失点に応じて、該当ファイルに１を記入
      if ((int)$lostscore===0){
        $fp = fopen($score0, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }elseif($lostscore==1){
        $fp = fopen($score1, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }elseif($lostscore==2){
        $fp = fopen($score2, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }elseif($lostscore==3){
        $fp = fopen($score3, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }elseif($lostscore==4){
        $fp = fopen($score4, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }elseif($lostscore==5){
        $fp = fopen($score5, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }elseif($lostscore==6){
        $fp = fopen($score6, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }elseif($lostscore>=7){
        $fp = fopen($score7more, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }
  }

    //データ登録SQL作成
    // 1. SQL文を用意
    $stmt = $pdo->prepare("INSERT INTO bb_predict(id, getscore, lostscore, winlose, name, comment, date)
    VALUES(NULL, :getscore, :lostscore, :winlose, :name, :comment, sysdate())");
  
    //  2. バインド変数を用意
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':getscore', $getscore, PDO::PARAM_STR);
    $stmt->bindValue(':lostscore', $lostscore, PDO::PARAM_STR);
    $stmt->bindValue(':winlose', $winlose, PDO::PARAM_STR);
    $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
  
    //  3. 実行
    $status = $stmt->execute();
  
    //４．データ登録処理後
    if ($status == false) {
        //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
        sql_error($stmt);
    } else{
      redirect("result.php");
    }
}



