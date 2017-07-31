# IMDB Reference Graph Tool

This tool is a Project from the Course "Visual Textanalysis in Digital Humanities" and will enable you to view References for given Movies from IMDB. E.g. you will be able to see which movies are referenced in a certain movie and which are referencing a given movie. 

# General Setup

Everything you need to do to actually Setup the Neo4j Server (given you have the parsed CSV files) can be found in the cypherCSVImport.md.

Parsing the movie-links.list file from IMDB is straight forward:

`php /path/to/rep/root/src/imdbDataParser/MovieLinksParserMain.php /path/to/movie-links.list`

If the Server is local you need to use 

`npm start`

in the root to set up a proxy (otherwise your browser will interfere)

otherwise you need to change the src `js/neo4jQueryProxy.js` to `js/neo4jQuery.js` .
