<?php 
require_once(realpath(dirname(__FILE__)) . '/MovieLinksParser.php');
//require_once(../../vendor/autoload.php);

global $argv;
if (isset($argv[1])) {
    echo "start";
    $parser = new MovieLinksParser();
    $parser->parseIMDBFile($argv[1]);
    echo "end";
    $neo4jQuery = '';
    foreach ($parser->moviesSet as $movie=>$value) {
        $neo4jQuery .= $movie . PHP_EOL;
    }
    foreach ($parser->linksSet as $link=>$value) {
        $neo4jQuery .= $link . PHP_EOL;
    }
    echo $neo4jQuery;
} else {
    echo "missing filename";
}