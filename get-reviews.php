<?php
/*

💬 Get Google-Reviews with PHP cURL & without API Key
=====================================================

If you have the business open in Google Maps:
- Do a search in Google Maps for the business name
- Make sure it’s the only result that shows up.
- Replace http:// with view-source: in the URL
- Click CTRL+F and search the source code for “ludocid”
- CID will be the numbers after “ludocid\\u003d” and till the last number

Example
-------
```TXT
ludocid\\u003d16726544242868601925\
```

> HINT: Use .quote in you CSS to style the output

###### Copyright 2019 Igor Gaffling

*/

$cid = '16726544242868601925';   // The CID you want to see the reviews for
$show_only_if_with_text = false; // true OR false
$show_only_if_greater_x = 0;     // 0-4
$show_rule_after_review = false; // true OR false
/* ------------------------------------------------------------------------- */

$ch = curl_init('https://www.google.com/maps?cid='.$cid);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla / 5.0 (Windows; U; Windows NT 5.1; en - US; rv:1.8.1.6) Gecko / 20070725 Firefox / 2.0.0.6");
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
$result = curl_exec($ch);
curl_close($ch);
$pattern = '/window\.APP_INITIALIZATION_STATE(.*);window\.APP_FLAGS=/ms';
if ( preg_match($pattern, $result, $match) ) {
  $match[1] = trim($match[1], ' =;'); // fix json
  $reviews = json_decode($match[1]);
  $reviews = ltrim($reviews[3][6], ")]}'"); // fix json
  $reviews = json_decode($reviews);
  $customer = $reviews[0][1][0][14][18];
  $reviews = $reviews[0][1][0][14][52][0];
}
if (isset($reviews)) {
  echo '<div class="quote"><strong>'.$customer.'</strong><br>';
  foreach ($reviews as $review) {
    if ($show_only_if_with_text == true and empty($review[3])) continue;
    if ($review[4] <= $show_only_if_greater_x) continue;
    for ($i=1; $i <= $review[4]; ++$i) echo '⭐'; // RATING
    if ($show_blank_star_till_5 == true)
      for ($i=1; $i <= 5-$review[4]; ++$i) echo '☆'; // RATING
    echo '<p>'.$review[3].'<br>'; // TEXT
    echo '<small>'.$review[0][1].'</small></p>'; // AUTHOR
    if ($show_rule_after_review == true) echo '<hr size="1">';
  }
  echo '</div>';
}
