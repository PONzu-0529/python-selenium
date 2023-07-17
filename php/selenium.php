<?php
require_once('vendor/autoload.php'); // Selenium WebDriverのライブラリを読み込む

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverDimension;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;

// WebDriverのセットアップ
$host = 'http://' . getenv('SELENIUM_GRID_HOST') . ':4444'; // Selenium Serverのホストとポート

$options = new ChromeOptions();
$options->addArguments([
    '--headless',
    '--mute-audio',
    '--no-sandbox',
    '--disable-gpu'
]);
$options->setExperimentalOption('excludeSwitches', ['enable-logging']);

$capabilities = DesiredCapabilities::chrome();
$capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

$driver = RemoteWebDriver::create($host, $capabilities);

function waitForElement($driver, $locator)
{
    $wait = new WebDriverWait($driver, 10); // 最大待機時間を設定 (ここでは10秒としています)

    $element = $wait->until(
        WebDriverExpectedCondition::visibilityOfElementLocated($locator)
    );

    return $element;
}

// Googleの検索ページを開く
$driver->get('https://www.google.com');

// 検索ボックスにキーワードを入力して検索実行
$searchBoxLocator = WebDriverBy::name('q');
$searchBox = waitForElement($driver, $searchBoxLocator);
$searchBox->sendKeys('Selenium PHP');
$searchBox->submit();

$screenshot = $driver->takeScreenshot('screenshot_' . time() . '.png');

// 検索結果のタイトルを表示
$results = $driver->findElements(WebDriverBy::cssSelector('h3'));
foreach ($results as $result) {
    echo $result->getText() . "\n";
}

// ブラウザを終了する
$driver->quit();
