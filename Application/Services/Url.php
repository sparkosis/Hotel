<?php
////////////////////////////////////////////////////////////////////////////////
//                     ___  ____  _____ _____ ____  _                         //
//                    / ___||  _ \| ____| ____|  _ \( )_   _ _ __             //
//                    \___ \| |_) |  _| |  _| | | | |/| | | | '_ \            //
//                    ___) |  __/| |___| |___| |_| | | |_| | |_) |            //
//                   |____/|_|   |_____|_____|____/   \__,_| .__/             //
//                                                        |_|                 //
////////////////////////////////////////////////////////////////////////////////

namespace Services;


class Url
{
    public static function redirect($url = null, $fullpath = false)
    {
        if ($fullpath == false) {
            $url = DIR . $url;
        }
        header('Location: '.$url);
        exit;
    }
    /**
     * created the absolute address to the template folder
     * @return string url to template folder
     */
    public static function templatePath($custom = false)
    {
        if ($custom == true) {
            return DIR.'Application/Templates/'.$custom.'/';
        } else {
            return DIR.'/Application/Templates/'.TEMPLATE.'/';
        }
    }
    /**
     * created the relative address to the template folder
     * @return string url to template folder
     */
    public static function relativeTemplatePath($admin = false)
    {
        if ($admin == false) {
            return "Application/Templates/".DEFAULT_TEMPLATE."/";
        } else {
            return "Application/Templates/".ADMIN_TEMPLATE."/";
        }
    }
    /**
     * converts plain text urls into HTML links, second argument will be
     * used as the url label <a href=''>$custom</a>
     *
     * @param  string $text   data containing the text to read
     * @param  string $custom if provided, this is used for the link label
     * @return string         returns the data with links created around urls
     */
    public static function autoLink($text, $custom = null)
    {
        $regex   = '@(http)?(s)?(://)?(([-\w]+\.)+([^\s]+)+[^,.\s])@';
        if ($custom === null) {
            $replace = '<a href="http$2://$4">$1$2$3$4</a>';
        } else {
            $replace = '<a href="http$2://$4">'.$custom.'</a>';
        }
        return preg_replace($regex, $replace, $text);
    }
    /**
     * This function converts and url segment to an safe one, for example:
     * `test name @132` will be converted to `test-name--123`
     * Basicly it works by replacing every character that isn't an letter or an number to an dash sign
     * It will also return all letters in lowercase
     *
     * @param $slug - The url slug to convert
     *
     * @return mixed|string
     */
    public static function generateSafeSlug($slug)
    {
        setlocale(LC_ALL, "en_US.utf8");

        $slug = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $slug));

        $slug = htmlentities($slug, ENT_QUOTES, 'UTF-8');

        $pattern = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $slug = preg_replace($pattern, '$1', $slug);

        $slug = html_entity_decode($slug, ENT_QUOTES, 'UTF-8');

        $pattern = '~[^0-9a-z]+~i';
        $slug = preg_replace($pattern, '-', $slug);

        return strtolower(trim($slug, '-'));
    }
    /**
     * Go to the previous url.
     */
    public static function previous()
    {
        header('Location: '. $_SERVER['HTTP_REFERER']);
        exit;
    }
    /**
     * get all url parts based on a / seperator
     * @return array of segments
     */
    public static function segments()
    {
        return explode('/', $_SERVER['REQUEST_URI']);
    }
    /**
     * get last item in array
     */
    public static function lastSegment($segments)
    {
        return end($segments);
    }
    /**
     * get first item in array
     */
    public static function firstSegment($segments)
    {
        return $segments[0];
    }
}
