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
