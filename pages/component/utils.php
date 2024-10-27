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

  public static function bgSetter($role){
    if($role == "admin"){
      return "bg-red-500 bg-opacity-30 text-red-800";
    }
    elseif ($role == "employee") {
      return "bg-green-500 bg-opacity-30 text-green-800";
    }
    else {
      return "bg-yellow-500 bg-opacity-30 text-yellow-800";
    }
  } 

  public static function bgAttendance($status){
    if($status == "present"){
      return "bg-green-500 bg-opacity-30 text-green-800";
    }
    else{
      return "bg-red-500 bg-opacity-30 text-red-800";
    }
  }

  public static function readTime($time){
    $readTime = new DateTime($time);
    return $readTime->format('H:i');
  }
}
