<?php
  $file = fopen('./file.txt' , 'r') or die('Unable to Open File!');

  $list = explode(' ' , fread($file , filesize('file.txt')));
  $random_key = array_rand($list , 1);

  function hangman($element) {
    $str_length = strlen($element); // life line for a word would be its length
    $wrong_attempt = $right_attempt = 0;
    while($wrong_attempt <= $str_length) {
      echo 'enter a character( a-z )';
      $input = fgetc(STDIN);
      $exist = strpos($element , $input);
      if( gettype($exist) == 'integer' ) {
        echo 'integer';
      }
    }  
    // echo $str_length . $element;

  }

  hangman('aaa');

  fclose($file);
?>