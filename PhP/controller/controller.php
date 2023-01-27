<?php

/**
 * Display list of movies
 */
function showMovies()
{
    // Get data
    require_once 'model/movies.php';

    // Prepare data: nothing for now

    // Go ahead and show it
    require_once 'view/movies.php';
}

/**
 * Display list of concerts
 * @param $future : tells if we must show only those in the future or all of them
 */

function showConcerts($future)
{
    // Get data
    require_once 'model/concerts.php';

    // Prepare data
    if (isset($future))
    {
        if ($future == 'y') // remove all concerts in the past
        {
            $today = date("Y-m-d");
            foreach ($concerts as $key => $concert)
            {
                if ($concert['date'] < $today)
                {
                    unset($concerts[$key]); // you MUST do it this way !!! unset($concert) will NOT destroy the data in the array
                }
            }
        }
        else
        {
            require_once 'view/error.php';
            return; // stop here so we don't include the 'normal' view
        }
    }

    // Go ahead and show it
    require_once 'view/concerts.php';
}
?>
