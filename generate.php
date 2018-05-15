<?php

/**
 * Dispaly help if no arguments
 */
if (@empty($argv[1]) && @empty($argv[2])) {
    echo 'How to run:'."\n".
    'php generate.php {ISBN} {destination.file}'."\n".
    'php generate.php {ISBN,ISBN,...} {distination.file}'."\n".
    'php generate.php {isbn_source.file} {distination.file}'."\n\n".
    '{ISBN} - The first argument for the script can be a single ISBN number.'."\n".
    '{ISBN,ISBN,...}The first argument may be many ISBN numbers seperated by a \',\' with no spaces.'."\n".
    '{isbn_source.file}The first argument may be the name of a file that has an ISBN number on each line.'."\n".
    '{destination.file} The second argument is optional, but if provided the script will create the file given the name you provide.  If blank then it will create \'index.html\'.  Caution!  This will overwrite the file if it already exist.'."\n";
    exit(0);
}
$isbnSource = '';
$htmlOutput = '';


/**
 * Grab the first 2 arguments from the command line
 */
$isbnSource = @$argv[1];
$htmlOutput = @empty($argv[2]) ? './index.html' : @$argv[2];

$isbnList = '';

$libUrl = 'https://openlibrary.org/api/books?bibkeys=ISBN:_ISBN_&jscmd=data&format=json';
/**
 * First check to see if the isbn source is a file
 */
if (is_file($isbnSource)) {
    $fh = fopen($isbnSource, 'rb');
    if ($fh) {
        while (($buffer = fgets($fh, 4096)) !== false) {
            $buffer = trim($buffer);
            if (!is_numeric($buffer)) {
                // We can ignore all non-numeric ISBN and continue with the others
                echo 'Warning: Non-numeric ISBN found:'.$buffer."\n";
                continue;
            }
            $isbnList .= $buffer.',';
        }
    } else {
        echo 'ISBN file not a file.  Please check permissions and path.'."\n";
        exit(0);
    }
    $isbnList = rtrim($isbnList, ',');
} else if (preg_match('/\d+,/',$isbnSource)) {
    /**
     * Allow a comma seperated string of ISBN
     */
    $isbnList = $isbnList = rtrim($isbnList, ',');
} else {
    echo 'ISBN file or ISBN number not found.'."\n";
    exit(0);
}

if (empty($isbnList)) {
    echo 'The list of ISBN is empty or is invalid'."\n";
    exit(0);
}

$carousel = '';
$excerpt = '';

/**
 * Get ISBN information
*/
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, str_replace('_ISBN_', $isbnList, $libUrl));
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$jsonResult = curl_exec($ch);
curl_close($ch);
if (!$jsonResult) {
    echo 'Could not return results set in JSON.'."\n";
    exit(0);
}

/**
 * put json results into an associative array
 */
$books = json_decode($jsonResult, true);

/**
 * if returning more than one ISBN, then only the first key in the array will have the prefix 'ISBN:', the rest of the keys will only have the number.
 */
foreach ($books as $key => $item) {
    $isbn = (stripos($key, 'ISBN') !== false) ? str_replace('ISBN:', '', $key) : $key;
    $authors = '';
    foreach ($item['authors'] as $author) {
        $authors .= $author['name'] . ',  ';
    }
    $authors = rtrim($authors, ',  ');
    $carousel .= '    <li><div style="width:200px;height:300px;"><a href="#'.$key.'"><img src="'.$item['cover']['medium'].'" title="'.$item['title'].'" alt="'.$item['excerpts'][0]['text'].'"/></a></div></li>'."\n";
    $excerpt .= '<div id="'.$key.'" class="excerpt"><div><div>ISBN: '.$isbn.'</div><div>Title: '.$item['title'].'</div><div>Author: '.$authors.'</div></div><div>Excerpt:  '.$item['excerpts'][0]['text'].'</div></div>'."\n";
}
$carousel = '<ul>' . $carousel . '</ul>';

/**
 * Now read the template into a string, replace the place holders
 */
$template = file_get_contents('./templates/carousel.template.html');
$template = str_replace('<hidden_carousel></hidden_carousel>', $carousel, str_replace('<hidden_excerpt></hidden_excerpt>', $excerpt, $template));

/**
 * Now write contents out to file
 */
$fh = fopen($htmlOutput, 'w+b');
fwrite($fh, $template);
fflush($fh);
fclose($fh);
exit(1);
?>
