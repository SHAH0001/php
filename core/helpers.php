<?php

    function dd($args)
    {
        echo '<pre>' . print_r($args, true) . '</pre>'; 
    }

    function redirect($uri)
    {
        header('Location: '. $uri);
    }
