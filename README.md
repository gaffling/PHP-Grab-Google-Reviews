💬 Get Google-Reviews with PHP cURL & without API Key
=====================================================

**This is a dirty but usefull way to grab the first 8 most relevant reviews from Google with cURL and without the use of an API Key**

How to find the CID - If you have the business open in Google Maps:
- Do a search in Google Maps for the business name
- Make sure it’s the only result that shows up.
- Replace http:// with view-source: in the URL
- Click CTRL+F and search the source code for “ludocid”
- CID will be the numbers after “ludocid\\u003d” and till the last number

or use this tool: https://ryanbradley.com/tools/google-cid-finder/

Example
-------
```TXT
ludocid\\u003d16726544242868601925\
```

Parameter
---------
```PHP
$options = array(
  'google_maps_review_cid' => '17311646584374698221', // Customer Identification (CID)
  'show_only_if_with_text' => false, // true = show only reviews that have text
  'show_only_if_greater_x' => 0,     // (0-4) only show reviews with more than x stars
  'show_rule_after_review' => true,  // false = don't show <hr> Tag after each review
  'show_blank_star_till_5' => true,  // false = don't show always 5 stars e.g. ⭐⭐⭐☆☆
);
echo getReviews($options);

```

> **HINT**: Use .quote in you CSS to style the output

###### Copyright 2019 Igor Gaffling
