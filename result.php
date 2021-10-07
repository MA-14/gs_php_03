<?php
require_once('funcs.php');
include('header.php');

$pdo = db_conn();

  $stmt = $pdo->prepare("SELECT * FROM bb_predict");
  $status = $stmt->execute();

  $win_view="";
  $win_view_count=0;
  $lose_view="";
  $lose_view_count=0;
  $draw_view="";
  $draw_view_count=0;

  if ($status==false) {
      //execute（SQL実行時にエラーがある場合）
      sql_error($stmt);
    }
    else{
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
      if($result["winlose"]=="win"){
        $win_view .= "<li>".h($result["getscore"])." vs ".h($result["lostscore"])." - ".h($result["comment"])." (".h($result["name"]).")"."</li>";
        $win_view_json =json_encode($win_view); 
        $win_view_count ++ ;
      }elseif($result["winlose"]=="lose"){
        $lose_view .= "<li>".h($result["getscore"])." vs ".h($result["lostscore"])." - " .h($result["comment"])." (".h($result["name"]).")"."</li>";
        $lose_view_json =json_encode($lose_view); 
        $lose_view_count++;
      }else{
        $draw_view .= "<li>";
        $draw_view .= h($result["getscore"])." vs ".h($result["lostscore"])." - ".h($result["comment"])." (".h($result["name"]).")"; 
        $draw_view .= "</li>";
        $draw_view_json =json_encode($draw_view); 
        $draw_view_count ++;
      }
    }
  }

  //ファイル内の0、1の数を数える
  $find0 = '/0/';
  $find1 = '/1/';

  //得点それぞれの予想数
  $get_score_vote0 = preg_match_all($find0,file("score0.txt")[0]);
  $get_score_vote1 = preg_match_all($find0,file("score1.txt")[0]);
  $get_score_vote2 = preg_match_all($find0,file("score2.txt")[0]);
  $get_score_vote3 = preg_match_all($find0,file("score3.txt")[0]);
  $get_score_vote4 = preg_match_all($find0,file("score4.txt")[0]);
  $get_score_vote5 = preg_match_all($find0,file("score5.txt")[0]);
  $get_score_vote6 = preg_match_all($find0,file("score6.txt")[0]);
  $get_score_vote7more = preg_match_all($find0,file("score7more.txt")[0]);

  //失点それぞれの予想数
  $lost_score_vote0 = preg_match_all($find1,file("score0.txt")[0]);
  $lost_score_vote1 = preg_match_all($find1,file("score1.txt")[0]);
  $lost_score_vote2 = preg_match_all($find1,file("score2.txt")[0]);
  $lost_score_vote3 = preg_match_all($find1,file("score3.txt")[0]);
  $lost_score_vote4 = preg_match_all($find1,file("score4.txt")[0]);
  $lost_score_vote5 = preg_match_all($find1,file("score5.txt")[0]);
  $lost_score_vote6 = preg_match_all($find1,file("score6.txt")[0]);
  $lost_score_vote7more = preg_match_all($find1,file("score7more.txt")[0]);  

?>

  <div class="titlemessage">みんなの予想はこの通り！</div>

<div class="result-box box1"> 
  <h2 class="result-box-title">勝敗・スコア分析</h2>
  <div class="allcharts">
    <div class="win_lose_rate chart_wrapper">
      <div class="chart-title">勝敗予想</div>
      <div id="vote_none1">・投稿はありません</div>
      <div class="result_figure figures" style="width:325px">
        <canvas id="mychart1" class="mychart1"></canvas>
      </div>
    </div>

    <div class="getScore_rate chart_wrapper">
      <div class="chart-title">得点数予想</div>
      <div id="vote_none2">・投稿はありません</div>
      <div class="getScore_figure figures" style="width:350px">
        <canvas id="mychart2" class="mychart2"></canvas>
      </div>
    </div>

    <div class="lostScore_rate chart_wrapper">
      <div class="chart-title">失点数予想</div>
      <div id="vote_none3">・投稿はありません</div>
      <div class="lostScore_figure figures" style="width:350px">
        <canvas id="mychart3" class="mychart3"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="result-box"> 
  <h2 class="result-box-title">投票一覧</h2>
  <div class="vote_all">
      <div class="win_vote comment">
        <div class="vote_title"><span>勝ち予想</span>（<?= $win_view_count ?>件）</div>
        <ul class="win_vote_content vote-content">
          <?php if ($win_view !== ""): ?>
          <?= $win_view ?>
          <?php else: ?>
          <li>投稿はありません</li>
          <?php endif ?>
        </ul>
      </div>
      <div class="lose_vote comment">
        <div class="vote_title">負け予想（<?= $lose_view_count ?>件）</div>
        <ul class="lose_vote_content vote-content">
        <?php if ($lose_view !== ""): ?>
         <?= $lose_view ?>
          <?php else: ?>
          <li>投稿はありません</li>
          <?php endif ?>
        </ul>
      </div>
      <div class="draw_vote comment">
        <div class="vote_title">引き分け予想（<?= $draw_view_count ?>件）</div>
        <ul class="draw_vote_content vote-content">
          <?php if ($draw_view !== ""): ?>
          <?= $draw_view ?>
          <?php else: ?>
          <li>投稿はありません</li>
          <?php endif ?>
        </ul>
      </div>
  </div>
</div>

  <div class="bottom-button">
    <button class = "vote-jamp" onclick="location.href='index1.php'">投稿画面に戻る</button>
    <button class = "select-jamp" onclick="location.href='select.php'">編集</button>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    <?php  if ($win_view !=="") :?>
    var win_view= JSON.parse('<?php echo $win_view_json ?>')
    <?php endif ?>
    <?php  if ($lose_view !=="") :?>
    var lose_view= JSON.parse('<?php echo $lose_view_json ?>')
    <?php endif ?>
    <?php  if ($draw_view !=="") :?>
    var draw_view= JSON.parse('<?php echo $draw_view_json ?>')
    <?php endif ?>

    // 予想がある時に図を表示
    <?php if($win_view !=="" || $lose_view !=="" || $draw_view !==""): ?>
      document.getElementById("vote_none1").style.display ="none";
      document.getElementById("vote_none2").style.display ="none";
      document.getElementById("vote_none3").style.display ="none";

      var ctx = document.getElementById('mychart1');
      var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['勝ち', '引き分け', '負け'],
          datasets: [{
            data: [<?= $win_view_count ?>, <?= $draw_view_count ?>, <?= $lose_view_count ?>],
            backgroundColor: ['#f88', '#484', '#48f'],
            weight: 100,
          }],
        },
        options:{
          plugins:{
            legend:{
              labels:{
                color:"white",
              }
            }
          }
        }
      });

      var ctx = document.getElementById('mychart2');
      var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['0点', '1点', '2点', '3点', '4点','5点','6点', '7点以上'],
          datasets: [{
            data: [<?php echo $get_score_vote0 ?>,<?php echo $get_score_vote1 ?>,<?php echo $get_score_vote2 ?>,<?php echo $get_score_vote3 ?>,<?php echo $get_score_vote4 ?>,<?php echo $get_score_vote5 ?>,<?php echo $get_score_vote6 ?>,<?php echo $get_score_vote7more ?>],
            backgroundColor: ['#e6b8c2','#f88','#e68a9e','#e65c7a','#e62e56','#ff0037','#cc002c','#990021'],
            weight: 100,
          }],
        },
        options:{
          plugins:{
            legend:{
              labels:{
                color:"white",
              }
            }
          }
        }
      });

      var ctx = document.getElementById('mychart3');
      var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['0点', '1点', '2点', '3点', '4点','5点','6点', '7点以上'],
          datasets: [{
            data: [<?php echo $lost_score_vote0 ?>,<?php echo $lost_score_vote1 ?>,<?php echo $lost_score_vote2 ?>,<?php echo $lost_score_vote3 ?>,<?php echo $lost_score_vote4 ?>,<?php echo $lost_score_vote5 ?>,<?php echo $lost_score_vote6 ?>,<?php echo $lost_score_vote7more ?>],
            backgroundColor: ['#abcbd9', '#82bdd9', '#57b0d9','#2ba2d9','#0095d9','#00aeff','#008bcc','#006999'],
            weight: 100,
          }],
        },
        options:{
          plugins:{
            legend:{
              labels:{
                color:"white",
                padding:10
              }
            }
          }
        }
      });

    //予想がない時は図を非表示
    <?php else: ?>  
      document.getElementById("vote_none1").style.display ="block";
      document.getElementById("vote_none2").style.display ="block";
      document.getElementById("vote_none3").style.display ="block";
    <?php endif ?>
  </script>




  <?php 
  include('footer.php');