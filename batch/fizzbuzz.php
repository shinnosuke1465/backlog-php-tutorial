<?php


// 入力値を受け取る
$value = $argv[1];

if($value % 3 ===0 && $value % 5 === 0){
  // 入力値が3と５で割り切れる
  // FizzBuzzを出力
  echo "FizzBuzz\n";
} else if ($value % 3 === 0){
 // 入力値が3で割り切れる
  // Fizzを出力
  echo "Fizz\n"; 
} else if ($value % 5 === 0){
  // 入力値が５で割り切れる
  // Buzzを出力
  echo "Buzz\n";
} else{
  // 入力値を出力
  echo "$value\n";
}
?>