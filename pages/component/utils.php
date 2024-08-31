<?php

class Utils
{
  public static function randPassword($length)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    $charactersLength = strlen($characters);
    $randomPassword = '';

    // Generate password secara acak
    for ($i = 0; $i < $length; $i++) {
      $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomPassword;
  }
}
