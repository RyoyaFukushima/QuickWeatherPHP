<?php
// OpenWeatherAPIを使って現在の仙台の天気を取得してみる
// TODO:GitHubに上げる場合はAPIKEYを隠す
// TODO:次はフォームで地名を入力して任意の位置を取れるようにする
/**
 * ファイル全体をまるごと読み込みたい→ file_get_contents()
 * ファイルの中身をまるごと出力したい→ readfile()
 * 行単位のテキストファイルを配列として読み込みたい→ file()
 * ファイルをバイト単位で読み込みたい→ fopen()+fread()
 * CSVを読み込みたい→ SplFileObjectクラス
 * オブジェクト指向的に操作したい→ SplFileObjectクラス
 * クラウドとかFTPとかにあるファイルを読み込みたい→ League\Flysystemライブラリ
 * 
 * 引用:https://qiita.com/tadsan/items/bbc23ee596d55159f044
 */

function weatherinfo($location){
    // とりあえず8都市くらい日本語化
    $enloc = match($location){
        '仙台'   => 'Sendai',
        '東京'   => 'Tokyo',
        '大阪'   => 'Osaka',
        '札幌'   => 'Sapporo',
        '名古屋' => 'Nagoya',
        '京都'   => 'Kyoto',
        '横浜'   => 'Yokohama'
    };
    // openweatherのAPIキーは別ファイルから読み込む
    $API_KEY = file_get_contents('apikey.txt');
    $url = "https://api.openweathermap.org/data/2.5/weather?q=${enloc}&units=metric&APPID=$API_KEY";
    $res = file_get_contents($url);
    $res_json = json_decode($res, true);

    return $res_json;
}
function weatherStatus($json){
    $weather = $json['weather'][0]['main'];
    return $weather;
}
function makemessage($json, $location){
    // 天気部分をパースして取得
    $weather = $json['weather'][0]['main'];
    // 気温部分をパースして取得
    $temp = $json['main']['temp'];
    // 英語の結果を日本語に簡易的に変換
    $jpweather = match($weather){
        'Clear' => '晴れ',
        'Clouds' => '曇り',
        'Rain' => '雨',
        'Snow' => '雪'
    };
    $message = "現在の${location}の天気は${jpweather}です。気温は${temp}度です。";

    return $message;
}
?>
