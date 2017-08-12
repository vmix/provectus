<?php
/*
Напишите программу, которая выводит на экран числа от 1 до 100. При этом вместо чисел, кратных трем, программа должна выводить слово Fizz, а вместо чисел, кратных пяти — слово Buzz. Если число кратно пятнадцати, то программа должна выводить слово FizzBuzz. Задача может показаться очевидной, но нужно получить наиболее простое и красивое решение.
*/

$numbers = range(1, 100);

function divBy3($number) // возвращает true, если число делится на 3
{
    if ($number % 3 == 0) return true;
    return false;
}

function divBy5($number) // возвращает true, если число делится на 5
{
    if ($number % 5 == 0) return true;
    return false;
}

foreach ($numbers as $number) {
    if (divBy3($number) && divBy5($number)) { // если число делится на 15
        echo 'FizzBuzz' . '<br>';
    } elseif (divBy3($number)) {  // если число делится на 3
        echo 'Fizz' . '<br>';
    } elseif (divBy5($number)) {  // если число делится на 5
        echo 'Buzz' . '<br>';
    } else {
        echo $number . '<br>';  // если число не делится ни на 3, ни на 5, ни на 15
    }
}