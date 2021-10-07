<?php

require_once('funcs.php');
include('header.php');

$pdo = db_conn();
$id = $_GET['id'];

//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM bb_predict WHERE id=' .$id . ';');
$status = $stmt->execute();

//データ表示
$view = '';
if ($status == false) {
    sql_error($status);
} else {
  $row = $stmt->fetch();    
}
?>

<form method="POST" action="update.php">
        <div class="jumbotron detail">
            <fieldset>
                <legend>投票詳細</legend>
                <label>名前      ：<input type="text" name="name" value="<?= h($row['name']) ?>"></label><br>
                <label>得点      ：<input type="number" name="getscore" value="<?= h($row['getscore']) ?>"></label><br>
                <label>失点      ：<input type="number" name="lostscore" value="<?= h($row['lostscore']) ?>"></label><br>
                <label>コメント：<br>
                <textarea name="comment" rows="4" cols="40" ><?= h($row['comment']) ?></textarea></label><br>
                <input type="hidden" name="id" value = "<?= $row['id'] ?>">
                <input  class = "input-button" type="submit" value="更新">
            </fieldset>
        </div>
    </form>

<?php 
  include('footer.php');
