<?php
// 天気ごとの画像切り替えがエラー起きるので修正
require 'openWeatherAPI.php';
header('X-FRAME-OPTION:DENY'); // クリックジャッキング対策
//header('Content-Type: image/png');
// $sunny = imagecreatefrompng("img/sunny.png");

function h($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
// コンテンツ形式の指定
//header('Content-type: image/png');

// 0:タイトル画面, 1:天気画面
$pageflag = 0;

if(!empty($_POST['location'])){
    $pageflag = 1;
}
if(isset($_POST['back'])){
    $pageflag = 0;
}
?>

<?php if($pageflag === 0) :?>
<!DOCTYPE html>
<meta charset="utf-8">
<link rel="stylesheet" href="common/simple.css">
<head></head>
<body>
    <h2>現在の天気を簡易表示するアプリ</h2>   
    <form method="POST" action="app.php">
        地名
        <input type="text" name="location">
        <br>
        <input type="submit" name="btn_submit"value="送信する。">
    </form>   
</body>
<html>
<?php endif; ?>

<?php if($pageflag === 1) :?>
<!DOCTYPE html>
<meta charset="utf-8">
<link rel="stylesheet" href="common/simple.css">
<head></head>
<body>
    <h2>天気結果</h2>
    <?php 
    $info = weatherinfo($_POST['location']);
    $message = makemessage($info, $_POST['location']);
    $weather = weatherStatus($info);
    
    switch($weather){
        case 'Clear':
            //　これと同じことができるメソッドが欲しい
            echo '<img src="img/sunny.png">';
            break;
        case 'Clouds':
            echo '<img src="img/cloud.png">';
            break;
        case 'Rain':
            echo '<img src="img/rain.png">';
            break;
        case 'Snow':
            echo '<img src="img/snow.png">';
            break;
      } 
    ?>
 
    <h2><?php echo h($message); ?></h2>
    <br>
    <form method="POST" action="app.php">
        <input type="submit" name="back"value="戻る。">
    </form>
</body>
<html>
<?php endif; ?>
