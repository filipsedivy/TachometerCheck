# 🚘 Crawler KontrolaTachometru.cz


Install it using Composer:

```
composer require filipsedivy/TachometerCheck
```


Usage
-----

```php
<?php

$guzzle = new \GuzzleHttp\Client();
$goutte = new \Goutte\Client();

// OCR service

// 2Captcha.com
$ocr = new \MDCR\TachometerCheck\Adapter\OCR\TwoCaptcha('API KEY', $guzzle);

// ---- OR

// Google Vision
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/google_credentials.json');
$imageAnnotatorClient = new \Google\Cloud\Vision\V1\ImageAnnotatorClient();
$ocr = new \MDCR\TachometerCheck\Adapter\OCR\GoogleVision($imageAnnotatorClient);

// Add OCR to crawler

$crawler = new \MDCR\TachometerCheck\Adapter\Crawler\Crawler($ocr, $goutte);

// Load tachometer check
$tachometerCheck = new \MDCR\TachometerCheck\TachometerCheck($crawler);
$histories = $check->getHistory('VIN CODE');

```