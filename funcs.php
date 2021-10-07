<?php
function h($s){
  return htmlspecialchars($s,ENT_QUOTES,'UTF-8');
}


//勝敗予想をパーセンテージで出す
function rate($a,$b,$c){
  return round($a/($a+$b+$c)*100);
}

  //ファイルの中身を削除するファンクション
  function deleateContent($f){
    $fp = fopen($f, "w");
    fclose($fp);
  }

//DB接続関数：db_conn() 
//※関数を作成し、内容をreturnさせる。
//※ DBname等、今回の授業に合わせる。

function db_conn() {
  try {
    //ID:'root', Password: 'root'
    $pdo = new PDO('mysql:dbname=baseball;charset=utf8;host=localhost', 'root', 'root');
    return $pdo;
  } catch (PDOException $e) {
    exit('DBConnectError:' . $e->getMessage());
  }
}

//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){
  $error = $stmt->errorInfo();
  exit('SQLError:' . print_r($error, true));
}
//stmtは引数として代入されている

//リダイレクト関数: redirect($file_name)
function redirect($file_name){
  header('Location:' .$file_name);
  exit();
}