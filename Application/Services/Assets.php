<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sparkosis
 * Date: 24/10/2016
 * Time: 12:45
 */

namespace Services;


class Assets
{
  public static $json = null;
  public static function path($file)
  {
    $parts = explode('.', $file);
    if (self::isLocal()) {
      if ($parts[1] === 'css') {
        return;
      }
      return 'http://localhost:3003/assets/'.$file;
    }
    if (! self::$json) {

      self::$json = json_decode(file_get_contents(TEMPLATE.'assets/assets.json'));
    }
    return self::$json->{$parts[0]}->{$parts[1]};
  }
  public static function isLocal()
  {

    return strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;
  }
}
