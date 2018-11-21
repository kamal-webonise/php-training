<?php
  $file = fopen('./file.txt' , 'r') or die('Unable to Open File!');

  $list = explode(' ' , fread($file , filesize('file.txt')));
  $random_key = array_rand($list , 1);

  function hangman($element) {

    $str_length = strlen($element); // life line for a word would be its length
    $wrong_attempt = $right_attempt = 0;
    $guess_characters = array();
    
    while($wrong_attempt < $str_length and $right_attempt < $str_length) {

      $input = readline('enter a character( a-z )');
      $exist = strpos($element , $input);

      if( gettype($exist) == 'integer' ) { // character exists in the string

        $lastPos = 0;
        $positions = array();

        if(in_array($input, $guess_characters)) { //hit the correct guessed aphabet again

          echo 'You have already tried this alphabet'.PHP_EOL;
        }
        else {

          while (($lastPos = strpos($element, $input, $lastPos)) !== false) { // checks if the alpabet repeat
            $positions[] = $lastPos;
            $lastPos = $lastPos + 1;
          }

          echo "index".PHP_EOL;
          print_r($positions);
          $right_attempt += sizeof($positions);
          echo 'You have correctly guess your '. $right_attempt.' characters out of '.$str_length.PHP_EOL;
          array_push($guess_characters, $input);
          
        }
      } 
      else { // wrong attempt 
        $wrong_attempt++;
        echo 'You miss your '. $wrong_attempt.' attemptt out of '.$str_length.PHP_EOL;
      }
    }

    if($wrong_attempt == $str_length) {
      echo 'You Loose'.PHP_EOL;
    }
    else {
      echo 'You Win'.PHP_EOL; 
    }

  }
  hangman($list[$random_key]);

  fclose($file);
?>
