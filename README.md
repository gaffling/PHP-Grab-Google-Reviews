💬 Get Google-Reviews with PHP cURL & without API Key
=====================================================

**This is a dirty but usefull way to grab the first 8 most relevant reviews from Google with cURL and without the use of an API Key**

How to find the needed CID No:
  - use: [https://pleper.com/index.php?do=tools&sdo=cid_converter]
  - and do a search for your business name

Parameter
---------
```PHP
$options = array(
  'google_maps_review_cid' => '17311646584374698221', // Customer Identification (CID)
  'show_only_if_with_text' => false, // true = show only reviews that have text
  'show_only_if_greater_x' => 0,     // (0-4) only show reviews with more than x stars
  'show_rule_after_review' => true,  // false = don't show <hr> Tag after each review
  'show_blank_star_till_5' => true,  // false = don't show always 5 stars e.g. ⭐⭐⭐☆☆
  'your_language_for_tran' => 'en',  // give you language for auto translate reviews
  'sort_by_reating_best_1' => true,  // true = sort by rating (best first)
  'show_cname_as_headline' => true,  // true = show customer name as headline
  'show_age_of_the_review' => true,  // true = show the age of each review
  'show_txt_of_the_review' => true,  // true = show the text of each review
  'show_author_of_reviews' => true,  // true = show the author of each review
);
echo getReviews($options);

```

> HINT: Use .quote in you CSS to style the output

###### Copyright 2019-2020 Igor Gaffling
