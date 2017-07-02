<?php
class MovieLinksParser
{
    //root gets set in the parser
    public $moviesSet = array();
    public $linksSet = array();
    public $mainMovie = null;
    public $counter = 0;

    public function parseIMDBFile($file)
    {
        $filepointer = null;
        try {
            $filePointer = fopen($file, 'r+');
        } catch (Exception $e) {
            throw new Exception('Unable to open file with path: ' . $file, 0, $e);
        }
        $line = null;
        //skip to the data -needs testing
        $header = true;
        while ($header) {
            $line = fgets($filePointer);
            if(strcmp($line,'MOVIE LINKS LIST
') == 0 || $line === false) {
                $header = false;
                //skip next line with only ===
                fgets($filePointer);
            }
        }
        while (($line = fgets($filePointer)) !== false) {
            //empty line, seperates main movies
            if (strcmp($line, '
') == 0) {
                $this->mainMovie = null;
                continue;
            }
            //references for a main movie
            if (strcmp(substr($line, 0, 3), '  (' ) == 0) {
                $this->parseLinksLine($line);
                continue;
            }
            //line must be the mainMovie, check if its a series (series are ignored)
            if (strcmp(substr($line, -2), '}
') == 0) {
                //skip until the next empty line, because references onto a movie are irrelevant
                while (($line = fgets($filePointer)) !== false) {
                    if(strcmp($line, '
') == 0) {
                        $this->mainMovie = null;
                        break;
                    }
                }
                continue;
            }
            //correct mainMovie
            $this->mainMovie = array($line, false);
        }
        return array($this->moviesSet, $this->linksSet);
    }

    private function parseLinksLine($line)
    {
        if (strcmp(substr($line, -3), '})
') == 0) {
            return;
        }

        if ($this->mainMovie !== null) {
            //go through all different kinds of possible references and add for them entries
            if (strcmp(substr($line,0, 13), '  (references') == 0) {
                $refMovie = $this->addMovie(substr($line,13,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($this->mainMovie[2], $refMovie[2], 'references');
                }
            }

            if (strcmp(substr($line,0, 16), '  (referenced in') == 0) {
                $refMovie = $this->addMovie(substr($line,16,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($refMovie[2], $this->mainMovie[2], 'references');
                }
            }

            if (strcmp(substr($line,0, 11), '  (features') == 0) {
                $refMovie = $this->addMovie(substr($line,11,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($this->mainMovie[2], $refMovie[2], 'features');
                }
            }

            if (strcmp(substr($line,0, 14), '  (featured in') == 0) {
                $refMovie = $this->addMovie(substr($line,14,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($refMovie[2], $this->mainMovie[2], 'features');
                }
            }

            if (strcmp(substr($line,0, 10), '  (follows') == 0) {
                $refMovie = $this->addMovie(substr($line,10,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($this->mainMovie[2], $refMovie[2], 'follows');
                }
            }

            if (strcmp(substr($line,0, 14), '  (followed by') == 0) {
                $refMovie = $this->addMovie(substr($line,14,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($refMovie[2], $this->mainMovie[2], 'follows');
                }
            }

            if (strcmp(substr($line,0, 11), '  (spin off') == 0 && !(strcmp(substr($line,0, 16), '  (spin off from') == 0)) {
                $refMovie = $this->addMovie(substr($line,11,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($this->mainMovie[2], $refMovie[2], 'spin off');
                }
            }

            if (strcmp(substr($line,0, 16), '  (spin off from') == 0) {
                $refMovie = $this->addMovie(substr($line,16,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($refMovie[2], $this->mainMovie[2], 'spin off');
                }
            }

            if (strcmp(substr($line,0, 9), '  (spoofs') == 0) {
                $refMovie = $this->addMovie(substr($line,9,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($this->mainMovie[2], $refMovie[2], 'spoofs');
                }
            }

            if (strcmp(substr($line,0, 12), '  (spoofed in') == 0) {
                $refMovie = $this->addMovie(substr($line,12,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($refMovie[2], $this->mainMovie[2], 'spoofs');
                }
            }

            if (strcmp(substr($line,0, 14), '  (edited into') == 0) {
                $refMovie = $this->addMovie(substr($line,12,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($this->mainMovie[2], $refMovie[2], 'edited into');
                }
            }

            if (strcmp(substr($line,0, 14), '  (edited from') == 0) {
                $refMovie = $this->addMovie(substr($line,12,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($refMovie[2], $this->mainMovie[2], 'edited into');
                }
            }

            if (strcmp(substr($line,0, 12), '  (remake of') == 0) {
                $refMovie = $this->addMovie(substr($line,12,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($this->mainMovie[2], $refMovie[2], 'remake of');
                }
            }

            if (strcmp(substr($line,0, 12), '  (remade as') == 0) {
                $refMovie = $this->addMovie(substr($line,12,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($refMovie[2], $this->mainMovie[2], 'remake of');
                }
            }

            if (strcmp(substr($line,0, 13), '  (version of') == 0) {
                $refMovie = $this->addMovie(substr($line,13,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($this->mainMovie[2], $refMovie[2], 'version of');
                }
            }

            if (strcmp(substr($line ,0 , 32), '  (alternate language version of') == 0) {
                $refMovie = $this->addMovie(substr($line,32,-1));
                if (isset($refMovie[1]) && $refMovie[1] && isset($this->mainMovie)) {
                    if (!$this->mainMovie[1]) {
                        $this->mainMovie = $this->addMovie($this->mainMovie[0]);
                    }
                    $this->addLink($this->mainMovie[2], $refMovie[2], 'alternate language version of');
                }
            }
        }

        return;
    }

    private function addMovie($line) {

        $movieVariable = null;
        $line = trim($line);
        $pattern = '/(\([0-9\?]{4}((\/[IVXLCD]+)?)\))/';
        $matches = null;
        preg_match_all($pattern, $line, $matches, PREG_OFFSET_CAPTURE);
        if (count($matches[0]) > 0) {
            $date = $matches[0][count($matches[0])-1][0];
            $movieName = trim(substr($line, 0, $matches[0][count($matches[0])-1][1]));
            if (strcmp(substr($movieName, 0, 1), '"') == 0) {
                $movieName = substr($movieName, 1, -1);
            }
            $movieVariable = array(
                '`'. $movieName . '_' . $date . '`',
                true,
                -1
            );
            if (!isset($this->movieSet[$movieVariable[0]])) {
                $this->moviesSet[$movieVariable[0]] = array(
                    'id' => $this->counter, 
                    'title' => $movieName,
                    'date' => $date
                );
                $this->counter++;
            }
        }
        if (isset($movieVariable[0])) {
            $movieVariable[2] = $this->moviesSet[$movieVariable[0]]['id'];
        }
        else {
            $movieVariable = null;
        }
        return $movieVariable;
    }

    private function addLink($mainMovieID, $refMovieID, $ref) {

        $line = $mainMovieID . ',' . $refMovieID . ',' . '"' . $ref . '"';
        $this->linksSet[$line] = 1;
        return;
    }

    public function resetParser()
    {
        //cheap way
        unset($this->movieSet);
        unset($this->linksSet);
        unset($this->counter);
    }
}
