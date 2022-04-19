<?php

/*

💬 Get Google-Reviews with PHP
==============================

**This is a tiny but usefull way to grab the 5 most relevant reviews from Google with cURL and with the use of an API Key**

How to get the needed Google Places API Key:
  - use: https://developers.google.com/maps/documentation/places/web-service/get-api-key
  - and follow the easy explaned steps

How to find the needed Placec ID:
  - use: [https://developers.google.com/maps/documentation/places/web-service/place-id]
  - and do a search for the wanted business name

Parameter
---------

```PHP
$options = array(
  'googlemaps_free_apikey' => '',       // Google API Key
  'google_maps_review_cid' => 'ChIJHegKoJUfyUwRjMxaCcviZDA',       // Google Placec ID of the Business
  'cache_data_xdays_local' => 30,       // every x day the reviews are loaded from google (save API traffic)
  'your_language_for_tran' => 'en',     // give you language for auto translate reviews
  'show_not_more_than_max' => 5,        // (0-5) only show first x reviews
  'show_only_if_with_text' => false,    // true = show only reviews that have text
  'show_only_if_greater_x' => 0,        // (0-4) only show reviews with more than x stars
  'sort_reviews_by_a_data' => 'rating', // sort by 'time' or by 'rating' (newest/best first)
  'show_cname_as_headline' => true,     // true = show customer name as headline
  'show_stars_in_headline' => true,     // true = show customer stars after name in headline
  'show_author_avatar_img' => true,     // true = show the author avatar image (rounded)
  'show_blank_star_till_5' => true,     // false = don't show always 5 stars e.g. ⭐⭐⭐☆☆
  'show_txt_of_the_review' => true,     // true = show the text of each review
  'show_author_of_reviews' => true,     // true = show the author of each review
  'show_age_of_the_review' => true,     // true = show the age of each review
  'dateformat_for_the_age' => 'Y.m.d',  // see https://www.php.net/manual/en/datetime.format.php
  'show_rule_after_review' => true,     // false = don't show <hr> Tag after each review (and before first)
  'add_schemaorg_metadata' => true,     // add schemo.org data to loop back your rating to SERP
);
echo getReviews($options);
```

> HINT: Use .review and .review .avatar in you CSS to style the output

###### Copyright 2019-2021 Igor Gaffling

*/

$options = array(
  'googlemaps_free_apikey' => '',       // Google API Key
  'google_maps_review_cid' => 'ChIJHegKoJUfyUwRjMxaCcviZDA', // Google Placec ID of the Business
  'cache_data_xdays_local' => 30,       // every x day the reviews are loaded from google (save API traffic)
  'your_language_for_tran' => 'en',     // give you language for auto translate reviews
  'show_not_more_than_max' => 5,        // (0-5) only show first x reviews
  'show_only_if_with_text' => false,    // true = show only reviews that have text
  'show_only_if_greater_x' => 0,        // (0-4) only show reviews with more than x stars
  'sort_reviews_by_a_data' => 'rating', // sort by 'time' or by 'rating' (newest/best first)
  'show_cname_as_headline' => true,     // true = show customer name as headline
  'show_stars_in_headline' => true,     // true = show customer stars after name in headline
  'show_author_avatar_img' => true,     // true = show the author avatar image (rounded)
  'show_blank_star_till_5' => true,     // false = don't show always 5 stars e.g. ⭐⭐⭐☆☆
  'show_txt_of_the_review' => true,     // true = show the text of each review
  'show_author_of_reviews' => true,     // true = show the author of each review
  'show_age_of_the_review' => true,     // true = show the age of each review
  'dateformat_for_the_age' => 'Y.m.d',  // see https://www.php.net/manual/en/datetime.format.php
  'show_rule_after_review' => true,     // false = don't show <hr> Tag after each review (and before first)
  'add_schemaorg_metadata' => true,     // add schemo.org data to loop back your rating to SERP
);


echo '<style> .review { font-family: sans-serif; } .review .avatar { float: left; width: 75px; padding-right: 20px; padding-bottom: 10px;} </style>';
echo getReviews($options);


function getReviews($option) {
  if (file_exists('reviews.json') and strtotime(filemtime('reviews.json')) < strtotime('-'.$option['cache_data_xdays_local'].' days')) {
    $result = file_get_contents('reviews.json');
  } else {
    $url = 'https://maps.googleapis.com/maps/api/place/details/json?place_id='.$option['google_maps_review_cid'].'&key='.$option['googlemaps_free_apikey'];
    if (function_exists('curl_version')) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      if ( isset($option['your_language_for_tran']) and !empty($option['your_language_for_tran']) ) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Language: '.$option['your_language_for_tran']));
      }
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36');
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($ch);
      curl_close($ch);
    } else {
      $arrContextOptions=array(
        'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
        ),
        'http' => array(
          'method' => 'GET',
          'header' => 'Accept-language: '.$option['your_language_for_tran']."\r\n" .
          "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36\r\n"
        )
      );  
      $result = file_get_contents($url, false, stream_context_create($arrContextOptions));
    }
    $fp = fopen('reviews.json', 'w');
    fwrite($fp, $result);
    fclose($fp);
  }
  $data  = json_decode($result, true);
  #echo'<pre>';var_dump($data);echo'</pre>'; // DEV & DEBUG
  $reviews = $data['result']['reviews'];
  $html = '';
  if (!empty($reviews)) {
    if ( isset($option['sort_reviews_by_a_data']) and $option['sort_reviews_by_a_data'] == 'rating' ) {
      array_multisort(array_map(function($element) { return $element['rating']; }, $reviews), SORT_DESC, $reviews);
    } else if ( isset($option['sort_reviews_by_a_data']) and $option['sort_reviews_by_a_data'] == 'time' ) {
      array_multisort(array_map(function($element) { return $element['time']; }, $reviews), SORT_DESC, $reviews);
    }
    $html .= '<div class="review">';
    if (isset($option['show_cname_as_headline']) and $option['show_cname_as_headline'] == true) {
      $html .= '<strong>'.$data['result']['name'].' ';
      if (isset($option['show_stars_in_headline']) and $option['show_stars_in_headline'] == true) {
        for ($i=1; $i <= $data['result']['rating']; ++$i) $html .= '⭐';
        if (isset($option['show_blank_star_till_5']) and $option['show_blank_star_till_5'] == true) for ($i=1; $i <= 5-floor($data['result']['rating']); ++$i) $html .= '☆';
      }
      $html .= '</strong><br>';
    }
    if (isset($option['add_schemaorg_metadata']) and $option['add_schemaorg_metadata'] == true) {
      $html .= '<itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"><meta itemprop="worstRating" content="1"/><meta itemprop="bestRating" content="5"/>';
      $html .= '<meta itemprop="ratingValue" content="'.$data['result']['rating'].'"/>';
    }
    if (isset($option['show_rule_after_review']) and $option['show_rule_after_review'] == true) $html .= '<hr size="1">';
    foreach ($reviews as $key => $review) {
      if (isset($option['show_not_more_than_max']) and $option['show_not_more_than_max'] > 0 and $key >= $option['show_not_more_than_max']) continue;
      if (isset($option['show_only_if_with_text']) and $option['show_only_if_with_text'] == true and empty($review['text'])) continue;
      if (isset($option['show_only_if_greater_x']) and $review['rating'] <= $option['show_only_if_greater_x']) continue;
      if (isset($option['show_author_of_reviews']) and $option['show_author_of_reviews'] == true and
          isset($option['show_author_avatar_img']) and $option['show_author_avatar_img'] == true) $html .= '<img class="avatar" src="'.$review['profile_photo_url'].'">';
      for ($i=1; $i <= $review['rating']; ++$i) $html .= '⭐';
      if (isset($option['show_blank_star_till_5']) and $option['show_blank_star_till_5'] == true) for ($i=1; $i <= 5-$review['rating']; ++$i) $html .= '☆';
      $html .= '<br>';
      if (isset($option['show_txt_of_the_review']) and $option['show_txt_of_the_review'] == true) $html .= str_replace(array("\r\n", "\r", "\n"), ' ', $review['text']).'<br>';
      if (isset($option['show_author_of_reviews']) and $option['show_author_of_reviews'] == true) $html .= '<small>'.$review['author_name'].' </small>';
      if (isset($option['show_age_of_the_review']) and $option['show_age_of_the_review'] == true) $html .= '<small> '.date($option['dateformat_for_the_age'], $review['time']).'  &mdash; '.$review['relative_time_description'].' </small>';
      if (isset($option['show_rule_after_review']) and $option['show_rule_after_review'] == true) $html .= '<hr style="clear:both" size="1">';
    }
    $html .= '</div>';
  }
  return $html;
}
