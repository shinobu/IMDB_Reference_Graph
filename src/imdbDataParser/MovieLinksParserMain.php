<?php 
require_once(realpath(dirname(__FILE__)) . '/MovieLinksParser.php');

global $argv;
if (isset($argv[1])) {
    //echo "start";
    $parser = new MovieLinksParser();
    $parser->parseIMDBFile($argv[1]);
    //echo "end";
    $movieCSV = 'id,title,date' . PHP_EOL;
    foreach ($parser->moviesSet as $key=>$movie) {
        $movieCSV .= $movie['id'] . ',"' . $parser->escapeDoubleQuotes($movie['title']) . '","' . $movie['date'] . '"' . PHP_EOL;
    }
    $linksCSV = 'mainid,refid,type' . PHP_EOL;
    foreach ($parser->linksSet as $link=>$value) {
        $linksCSV .= $link . PHP_EOL;
    }
    file_put_contents(getcwd() . '/movie.csv', $movieCSV);
    file_put_contents(getcwd() . '/links.csv', $linksCSV);
} else {
    echo "missing filename";
}