<?php

namespace App\Helpers;

//use Illuminate\Http\Request;

class Menu
{
    //

    public static function active($page)
    {
        $path = app('request')->path();
        $current = $path;

	    $path  = explode('/', $path);

        if (in_array($page, $path))
            return 'active open';

	    if ($page === $current)
		    return 'active open';

        return '';
    }
}
