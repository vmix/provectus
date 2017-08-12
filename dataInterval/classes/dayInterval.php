<?php
/* Задача - вывести разницу между двумя датами в годах, месяцах, днях без использования стандартных функций
 php для работы с датами */

// Сделана автозагрузка класса. Будет POST-запрос. PHPStorm как-то странно работает с post-запросами, так что лучше разархивировать в диеркторию с доступом через localhost

Class dayInterval
{
    // заданы для удобства работы
    public $start_date;
    public $end_date;

    // входные данные
    public $years;
    public $months;
    public $days;
    public $total_days;
    public $invert = false; // ее не использовал, сделал автоматическое распознавание дат, сравнение и если начальная больше, чем конечная, то они переставляются местами и функция вызывается с уже измененным порядком следования дат.

    private $full_year = [ // информация о количестве дней в году по месяцам
        '1' => 31,
        '2' => 28,
        '3' => 31,
        '4' => 30,
        '5' => 31,
        '6' => 30,
        '7' => 31,
        '8' => 31,
        '9' => 30,
        '10' => 31,
        '11' => 30,
        '12' => 31
    ];

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date; // инициализируем объект датами
        $this->end_date = $end_date;

        $this->dateDifference($this->start_date, $this->end_date, $this->invert = false); // вызовем функцию сравнения дат
    }

    protected function dateDifference($start_date, $end_date, $invert = false) // основная функция, которая будет считать разность дат
    {
        if ($invert) { // проверка не установлен ли флаг инвертирования дат
            $tmp = $start_date;
            $start_date = $end_date;
            $end_date = $tmp;
        }

        $parsed_start_date = $this->parseDate($start_date); // парсим даты. В результате массив: [год, месяц, день]
        $parsed_end_date = $this->parseDate($end_date);

        $number_start_date = implode('', $parsed_start_date); // записываем дату в виде 20170525 (год месяц дата) Нужно для сравнения дат
        $number_end_date = implode('', $parsed_end_date);

        $array_of_years = []; // В массиве хранится сколько високосных годов было в промежутке между введенными датами
        $quantity_of_leap_year = 0;
        for ($i = $parsed_start_date[0]; $i <= $parsed_end_date[0]; $i++) {
            if ($this->isLeap($i)) {
                $quantity_of_leap_year += 1;
            }
            $array_of_years[] = $i;
        }

        if (($number_start_date <=> $number_end_date) == 0) { // сравнение дат с помощью оператора spaceship (php 7)
            $this->years = 0;
            $this->months = 0;
            $this->days = 0;
        }
        if (($number_start_date <=> $number_end_date) == -1) { //  если начальная дата меньше, то сравним годы
            switch ($parsed_start_date[0] <=> $parsed_end_date[0]) {
                case -1:
                    $this->years = $parsed_end_date[0] - $parsed_start_date[0];  // если начальный год меньше, то вычисляем разницы лет
                    break;
                case 0:
                    $this->years = 0; // если годы равны, то очевидно прошло меньше года, т.е. 0 лет
                    break;
            }  //  вариант 'больше' не рассматриваем, так как подразумевается инвертирование порядка дат, если начальная больше конечной
            switch ($parsed_start_date[1] <=> $parsed_end_date[1]) { // теперь сравним месяцы
                case -1:
                    $this->months = $parsed_end_date[1] - $parsed_start_date[1]; // если начальный меньше, то вычисляем разницу
                    break;
                case 0:
                    $this->months = 0; // если месяцы равны, то разница между ними 0
                    break;
                case 1:
                    $this->months = 12 - ($parsed_start_date[1] - $parsed_end_date[1]); // если начальный больше конечного, то отнимаем эту разницу от 12 и уменьшаем год на один на следующей строке
                    $this->years--;
                    break;
            }
            switch ($parsed_start_date[2] <=> $parsed_end_date[2]) { // сравним дни
                case -1:
                    $this->days = $parsed_end_date[2] - $parsed_start_date[2]; // если начльный меньше, просто вычисляем разницу
                    break;
                case 0:
                    $this->days = 0; // если равны, то разница будет 0
                    break;
                case 1:
                    $this->days = 31 - ($parsed_start_date[2] - $parsed_end_date[2]);
                    $this->months--;
                    if ($this->months == -1) {
                        $this->months = 12 + $this->months;
                        $this->years--;
                    }
                    break;
            }
        }
        if (($number_start_date <=> $number_end_date) == 1) { // в случе если дата начальная больше конечной, то надо инвертировать флаг и вызвать функцию с флагом, который позволит автоматически поменять даты
            $this->invert = true;
            $this->dateDifference($start_date, $end_date, true);
        }
    }

    protected function parseDate(string $date): array // парсит дату в виде массива с годом, месяцем и днем в качестве элементов массива
    {
        $parsed_date = explode('-', $date);
        return $parsed_date; // возвращаем массив
    }

    private function isLeap($year) // если год високосный, то вернем true
    {
        if (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function dayInterval($start_date, $end_date, $invert = false) // считает разность дат в днях
    {
        if ($invert) {
            $tmp = $start_date;
            $start_date = $end_date;
            $end_date = $tmp;
        }
        $parsed_start_date = $this->parseDate($start_date); // парсим даты. В результате массив: [год, месяц, день]
        $parsed_end_date = $this->parseDate($end_date);

        $number_start_date = implode('', $parsed_start_date); // записываем дату в виде 20170525 (год месяц дата) Нужно для сравнения дат
        $number_end_date = implode('', $parsed_end_date);


        $start_index = $this->parseDate($start_date)[0];
        $end_index = $this->parseDate($end_date)[0];
        $arr = range($start_index, $end_index);  // массив, содержащий года, которые входят между этими датами полностью

        if ($this->isLeap($start_index)) {
            $days_till_end_year = 366 - $this->daysCounter($start_date);
        } else {
            $days_till_end_year = 365 - $this->daysCounter($start_date);
        }

        switch ($end_index - $start_index) {
            case 0:
                $this->total_days = $this->daysCounter($end_date) - $this->daysCounter($start_date);
                break;
            case 1:
                $this->total_days = $days_till_end_year + $this->daysCounter($end_date);
                break;
            case ($end_index - $start_index) >= 2:
                $quantity_of_leap_years = 0;
                for ($i = $arr[0]; $i <= end($arr); $i++) {
                    if ($this->isLeap($i)) $quantity_of_leap_years++;
                }
                $this->total_days = $days_till_end_year + ($end_index - $start_index - 1) * 365 + $quantity_of_leap_years + $this->daysCounter($end_date);
                break;
        }
        if ($number_start_date > $number_end_date) { // в случе если дата начальная больше конечной, то надо инвертировать флаг и вызвать функцию с флагом, который позволит автоматически поменять даты
            $this->invert = true;
            $this->dayInterval($start_date, $end_date, true);
        }

        return $this->total_days;
    }

    protected function daysCounter($date)  // метод считает кол-во дней , прошедшее с начала года до переданной даты
    {
        $counter = 0; // сюда будем записывать подсчет

        $year = $this->parseDate($date)[0];
        $month = $this->parseDate($date)[1];
        $day = $this->parseDate($date)[2];

        if ($this->isLeap($year) && $month . $day >= '02' . '29') { // если год високосный заданная дата не меньше 29 февраля
            $counter++; // то добавим один день в стандартный февраль
        }
        for ($i = 1; $i < $month; $i++) { // сложим все дни по месяцам, за исключением месяца заданной даты
            $counter += $this->full_year[$i];
        }
        $counter += $day; // добавим кол-во дней в месяце заданной даты

        return $counter; // искомое кол-во дней с начала года до заданной даты включительно
    }
}


