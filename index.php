<!-- リセットがうまく機能しない！！！ -->

<?php
require_once('funcs.php');
include('header.php');

?>


  <div class="titlemessage">今日の巨人戦のスコアを予想しよう</div>
  <div class="form">
    <form action="insert.php" method ="post">
      名前　　：<input type="text" name="name">
      <br>
      得点　　：<input type="number" name="getscore" min="0" max="100">
      <br>
      失点　　：<input type="number" name="lostscore" min="0" max="100">
      <br>
      コメント：<input name="comment" size=40>
      <br>
      <input class = "input-button" type="submit" value="投稿する">
    </form>
  </div>

<div class="bottom-button">
  <button class = "result-jamp" onclick="location.href='result.php'">みんなの予想を確認</button>
</div>

<?php 
include('footer.php');