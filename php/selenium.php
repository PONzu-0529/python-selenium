<?php
require_once('vendor/autoload.php'); // Selenium WebDriverのライブラリを読み込む

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

// WebDriverのセットアップ
$host = 'http://' . getenv('SELENIUM_GRID_HOST') . ':4444'; // Selenium Serverのホストとポート
$capabilities = DesiredCapabilities::chrome(); // 利用するブラウザを指定
$driver = RemoteWebDriver::create($host, $capabilities);

// Googleの検索ページを開く
$driver->get('https://www.google.com');

// 検索ボックスにキーワードを入力して検索実行
$searchBox = $driver->findElement(WebDriverBy::name('q'));
$searchBox->sendKeys('Selenium PHP');
$searchBox->submit();

// 検索結果のタイトルを表示
$results = $driver->findElements(WebDriverBy::cssSelector('h3'));
foreach ($results as $result) {
    echo $result->getText() . "\n";
}

// ブラウザを終了する
$driver->quit();
