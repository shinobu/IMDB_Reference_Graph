<?php
class MovieLinksParser
{
    //root gets set in the parser
    public $moviesSet = array();
    public $linksSet = array();
    public $filePointer = null;
    public $mainMovie = null;

    public function parseIMDBFile($file)
    {
        try {
            $this->filePointer = fopen($file, 'r+');
        } catch (Exception $e) {
            throw new Exception('Unable to open file with path: ' . $file, 0, $e);
        }
        $line = null;
        //skip to the data -needs testing
        $header = true;
        while ($header) {
            $line = fgets($this->filePointer);
            if(strcmp($line,'MOVIE LINKS LIST\n') == 0) {
                $header = false
                //skip next line with only ===
                fgets($this->filePointer);
            }
        }
        while (($line = fgets($this->filePointer)) !== false) {

            //empty line, seperates main movies
            if (strcmp($line, '\n') == 0) {
                $this->mainMovie = null;
                continue;
            }

            //references for a main movie
            if (strcmp(substr($line, 0, 2), '  (' ) == 0) {
                $parseLinksLine($line);
                continue;
            }

            //line must be the mainMovie, check if its a series (series are ignored)
            if (strcmp(substr($line, -2), '}\n') == 0) {
                //skip until the next empty line, because references onto a movie are irrelevant
                while (($line = fgets($this->filePointer)) !== false) {
                    if(strcmp($line, '\n') == 0) {
                        $this->mainMovie = null;
                        break;
                    }
                }
                continue;
            }

            //correct mainMovie
            $mainMovie = addMovie($line);
        }
        return $query
    }

    private function parseLinksLine($string)
    {
        if (strcmp(substr($line, -3), '})\n') == 0) {
            return;
        }

        if($this->mainMovie !== null) {
            //go through all different kinds of possible references and add for them entries
            if (strcmp(substr($line,0, 12), '  (references') == 0) {

            }

            if (strcmp(substr($line,0, 12), '  (referenced in') == 0) {
                
            }

            if (strcmp(substr($line,0, 12), '  (features') == 0) {
                
            }

            if (strcmp(substr($line,0, 12), '  (featured in') == 0) {
                
            }

            if (strcmp(substr($line,0, 12), '  (follows') == 0) {
                
            }

            if (strcmp(substr($line,0, 12), '  (followed by') == 0) {
                
            }

            if (strcmp(substr($line,0, 12), '  (spin off') == 0) {
                
            }

            if (strcmp(substr($line,0, 12), '  (spin off from') == 0) {
                
            }

            if (strcmp(substr($line,0, 12), '  (spoofs') == 0) {
                
            }

            if (strcmp(substr($line,0, 12), '  (spoofed in') == 0) {
                
            }

            if (strcmp(substr($line,0, 12), '  (edited into') == 0) {
                
            }

            if (strcmp(substr($line,0, 12), '  (edited from') == 0) {
                
            }

            if (strcmp(substr($line,0, 12), '  (remake of') == 0) {
                
            }

            if (strcmp(substr($line,0, 12), '  (remade as') == 0) {
                
            }

            if (strcmp(substr($line,0, 12), '  (??') == 0) {
                
            }

            if (strcmp(substr($line,0, 12), '  (version of') == 0) {
                
            }
        }

        return;
    }

    private addMovie($line) {

        
        return $movieVariable
    }

    public function resetParser()
    {
        //cheap way
        unset($movieSet);
        unset($linksSet);
    }
}
