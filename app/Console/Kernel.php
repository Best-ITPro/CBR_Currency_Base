<?php

namespace App\Console;

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CurrencyDateController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// Currency
use App\Currency;
use App\CurrencyDate;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            // тело функции

            // 1. Currency.List
            $currency = simplexml_load_file(Currency::CBR_URL_DAILY) or die ("error cannot create object");

            $title = "Курсы валют ЦБ РФ, установлены на  " . $currency['Date'];
            $result = "";
            $count = count(Currency::all());

            foreach ($currency->Valute as $curr) {

                $result = $result . $curr['ID'] . " - " . $curr -> Name . "\n";
                $result = $result . $curr->NumCode ." : ". $curr->CharCode . " : ". $curr->Nominal . " = " . $curr->Value ."\n";

                // Первоначальное заполнение базы
                if(count(Currency::where('CurrID', $curr['ID'] )->get()) == 0)
                {
                    $result = $result . $curr -> Name ." в базе не найден, добавляем!\n";
                    $curr_new = new Currency;
                    $count++;
                    $curr_new->id = $count;
                    $curr_new->CurrID = $curr['ID'];
                    $curr_new->Name = $curr->Name;
                    $curr_new->NumCode = $curr->NumCode;
                    $curr_new->CharCode = $curr->CharCode;
                    $curr_new->Nominal = $curr->Nominal;
                    $curr_new -> save();

                }
                else {
                    $result = $result . $curr -> Name ." есть в базе, обновление не требуется!\n";
                }
            }
            // Log 1
            info($title);
            info($result);

            // 2. Currency.Base
            // Сегодня
            $today = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
            // Завтра
            $yesterday = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
            // Последняя дата в базе
            $lastDayInBase = CurrencyDate::orderBy('id', 'desc')->first()->DateValue;
            // Если наступил другой день
            if($yesterday > strtotime($lastDayInBase)) {
                // Сразу проверяем следующий день за последним в базе
                $BeforecheckDay = strtotime($lastDayInBase);
                $checkDay = strtotime($lastDayInBase) + 3600*24;
                $title = "Обновление базы курсов валют ЦБ РФ с  " . date('d.m.Y', $checkDay) . " по ".date('d.m.Y' ,$today)."\n";
                while ($today >= $checkDay) {
                    $result = $result . "Производим поиск курсов валют за " . date('d.m.Y', $checkDay ). "\n";
                    $currency = simplexml_load_file(Currency::CBR_URL_DAILY . "?date_req=" . date('d/m/Y', $checkDay )) or die ("error cannot create object");

                    $result = $result . "Курсы валют ЦБ РФ, установлены на  " . $currency['Date'] . "\n";

                    if(strtotime($currency['Date']) > $BeforecheckDay) {

                        foreach ($currency as $get_curr) {

                            $curr_new = new CurrencyDate;
                            $count++;
                            $curr_new->id = $count;
                            $curr_new->CurrID = $get_curr['ID'];
                            $curr_new->Value = str_ireplace(',', '.', strval($get_curr->Value));
                            $curr_new->DateValue = date('d.m.Y', $checkDay);
                            $curr_new->Nominal = $get_curr->Nominal;
                            $curr_new->save();
                        }

                    }
                    else {
                        $result = $result . " Последние курсы зарегистрированы на ". $currency['Date'] . " и уже загружены в базу.\n";
                    }
                    $BeforecheckDay = $checkDay;
                    $checkDay = $checkDay + 3600*24;
                }

                $result = $result . "Поиск закончен.\n";
            }
            else {
                $result = $result . "Данные уже есть есть в базе, обновление не требуется!\n";
            }

            // Log 2
            info($title);
            info($result);

        })->twiceDaily(12, 15);

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
