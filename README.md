
💬 Get Google-Reviews with PHP
==============================

**This is a tiny but usefull way to grab the 5 most relevant reviews from Google with cURL and with the use of an API Key**

How to get the needed Google API Key:
  - use: https://developers.google.com/maps/documentation/places/web-service/get-api-key
  - and follow the easy explaned steps

How to find the needed Placec ID:
  - use: https://developers.google.com/maps/documentation/places/web-service/place-id
  - and do a search for the wanted business name

Parameter
---------

```PHP
$options = array(
  'googlemaps_free_apikey' => '',       // Google API Key
  'google_maps_review_cid' => 'ChIJHegKoJUfyUwRjMxaCcviZDA', // Google Placec ID
  'cache_data_xdays_local' => 30,       // every x day the reviews are loaded from google
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
  'show_rule_after_review' => true,     // false = don't show <hr> Tag after/before each review
  'add_schemaorg_metadata' => true,     // add schemo.org data to loop back your rating to SERP
);
echo getReviews($options);
```

> HINT: Use .review and .review .avatar in you CSS to style the output

###### Copyright 2019-2021 Igor Gaffling
