<?php
// PHP Comment Header
// Student Name: [Your Name]
// Date: [Date]

// Ensure the 'simple_html_dom.php' file is in the same directory as this script
include('simple_html_dom.php');

// IMDB URL for "The Big Bang Theory"
$url = 'https://www.imdb.com/title/tt0898266/';

// Creating a DOM object
$html = file_get_html($url);

// Check if the HTML was successfully retrieved
if(!$html) {
    die("Error: Unable to access IMDB page.");
}

// Extracting the title
$title = $html->find('title', 0)->plaintext;
echo "<h1>Title: $title</h1>";

// Extracting the description (assuming it's in a meta tag with name='description')
$description = $html->find("meta[name=description]", 0)->content;
echo "<p>Description: $description</p>";

// Extracting keywords (assuming they are in a meta tag with name='keywords')
$keywords = $html->find("meta[name=keywords]", 0)->content;
echo "<p>Keywords: $keywords</p>";

// Extracting all links
echo "<h2>All Links:</h2>";
foreach($html->find('a') as $link) {
    echo "<p><a href='".$link->href."'>".$link->plaintext."</a></p>";
}

// Extracting all images
echo "<h2>All Images:</h2>";
foreach($html->find('img') as $image) {
    echo "<img src='".$image->src."' alt='".$image->alt."'><br>";
}

// Extract additional elements (e.g., ratings)
$ratingDivs = $html->find('div[data-testid="hero-rating-bar__aggregate-rating"]');
if ($ratingDivs) {
    foreach ($ratingDivs as $div) {
        if (strpos($div->innertext, 'IMDb RATING') !== false) {
            $ratingSpan = $div->find('span.sc-bde20123-1', 0);
            if ($ratingSpan) {
                $rating = trim($ratingSpan->plaintext);
                echo "<p>Rating: $rating</p>";
                break;
            }
        }
    }
} else {
    echo "<p>Rating not found</p>";
}

// Clean up
$html->clear();
unset($html);
?>
