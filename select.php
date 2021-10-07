<?php

require_once('funcs.php');
include('header.php');
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM bb_predict');
$status = $stmt->execute();

//３．データ表示
$view = '';
if ($status == false) {
    sql_error($status);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //GETデータ送信リンク作成
        // <a>で囲う。
        $view .= '<p>';
        $view .= '<a href= "detail.php?id=' . $result['id'] . '">';
        $view .= $result['date'] . '：' . $result['getscore']."vs". $result['lostscore']. "-". $result['comment']. "(".$result['name'].")";
        $view .= '</a>';
        $view .= '<a href = "delete.php?id='. $result['id'] .  '">';
        $view .= '    [削除] ';
        $view .= '</a>';
        $view .= '</p>';
    }
}
?>

<div class="titlemessage" id="vote-detail-title">投稿された予想を編集できます</div>
<!-- Main[Start] -->
      <div id="vote_none" >投稿はありません</div>
      <div class="container jumbotron" id="vote-detail">
        <a href="detail.php" id="vote-detail1"></a>
        <?= $view ?>
      </div>
   
    <!-- Main[End] -->
    <div class="bottom-button">
      <form  method="post" action="reset.php">
        <button type="submit" name="reset">全ての投稿を削除</button>
      </form>
      <button class = "vote-jamp" onclick="location.href='index.php'">投稿画面に戻る</button>
      <button class = "vote-jamp" onclick="location.href='result.php'">投票結果に戻る</button>
    </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
  <?php if ($view!==""): ?>
    document.getElementById("vote_none").style.display ="none";
    document.getElementById("vote-detail-title").style.display ="block";
    document.getElementById("vote-detail").style.display ="block";
    document.getElementById("vote-detail1").style.display ="block";
  <?php else: ?>  
    document.getElementById("vote-detail-title").style.display ="none";
    document.getElementById("vote-detail").style.display ="none";
    document.getElementById("vote-detail1").style.display ="none";
    document.getElementById("vote_none").style.display ="block";
  <?php endif ?>
  
  </script>



</body>

</html>


<?php 
  include('footer.php');
