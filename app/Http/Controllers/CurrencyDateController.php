<?php
// Курсы валют по датам

namespace App\Http\Controllers;

use App\Currency;
use App\CurrencyDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrencyDateController extends Controller
{

    public function load() {

        $count = count(CurrencyDate::all());
        $today = date('d/m/Y', time());
        $result = "";

        // Первоначальное заполнение базы
        if($count == 0) {

            // Порционно заполняем базу
            $INTERVAL = Currency::INTERVAL;
            $DATE_FROM = Currency::DATE_FROM;
            $DATE_TO = strtotime(Currency::DATE_FROM) + 3600*24*$INTERVAL;
            $FINAL_DATE = strtotime($today);

            //echo "DATE_FROM = " . $DATE_FROM . "<br>";
            //echo "DATE_TO = " . date('d/m/Y', $DATE_TO) ."<br>";
            //echo "FINAL_DATE = " . $today . "<br>";

            $title = "Обновление базы курсов валют ЦБ РФ с  <b>" . Currency::DATE_FROM . "</b> по <b>".$today."</b><br>";

            while($DATE_TO <= $FINAL_DATE) {

                $url = Currency::CBR_URL_DINAMIC . "?date_req1=" . $DATE_FROM . "&date_req2=" . date('d/m/Y', $DATE_TO) . "&VAL_NM_RQ=";

                $currency = Currency::all();

                foreach ($currency as $curr){

                    $this_url = $url . $curr->CurrID;
                    $get_currency = simplexml_load_file($this_url) or die ("error cannot create object");

                    foreach ($get_currency as $get_curr) {

                        $result = $result .  "Получаем данные по валюте: ".$curr->CurrID . " . " . $curr->Name ." за ". $get_curr['Date'] ."<br>";

                        $curr_new = new CurrencyDate;
                        $count++;
                        $curr_new->id = $count;
                        $curr_new->CurrID = $get_curr['Id'];
                        $curr_new->Value = str_ireplace(',', '.', strval($get_curr->Value));
                        $curr_new->DateValue = $get_curr['Date'];
                        $curr_new->Nominal = $get_curr->Nominal;
                        $curr_new -> save();
                    }

                }

                $DATE_FROM = date('d/m/Y' , $DATE_TO);

                if( (($FINAL_DATE - $DATE_TO)/(3600*24)) < $INTERVAL ) {
                    $DATE_TO = $FINAL_DATE;
                }
                else {
                    $DATE_TO = $DATE_TO + 3600*24*$INTERVAL;
                }

            }

        }
        // Ежедневное заполнение базы
        else {

            // Сегодня
            $today = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
            // Последняя дата в базе
            $lastDayInBase = CurrencyDate::orderBy('id', 'desc')->first()->DateValue;
            // Если наступил другой день
            if($today > strtotime($lastDayInBase)) {
                // Сразу проверяем следующий день за последним в базе
                $BeforecheckDay = strtotime($lastDayInBase);
                $checkDay = strtotime($lastDayInBase) + 3600*24;
                $title = "Обновление базы курсов валют ЦБ РФ с  <b>" . date('d.m.Y', $checkDay) . "</b> по <b>".date('d.m.Y' ,$today)."</b><br>";
                while ($today >= $checkDay) {
                    $result = $result . "Производим поиск курсов валют за " . date('d.m.Y', $checkDay ). "<br>";
                    $currency = simplexml_load_file(Currency::CBR_URL_DAILY . "?date_req=" . date('d/m/Y', $checkDay )) or die ("error cannot create object");

                    $result = $result . "Курсы валют ЦБ РФ, установлены на  <b>" . $currency['Date'] . "</b><br><br>";

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
                        $result = $result . " Последние курсы зарегистрированы на ". $currency['Date'] . " и уже загружены в базу.<br>";
                    }
                    $BeforecheckDay = $checkDay;
                    $checkDay = $checkDay + 3600*24;
                }

                $result = $result . "<br>Поиск закончен.<br>";
            }
            else {
                $result = $result . "Данные уже есть есть в базе, обновление не требуется!<br><br>";
            }
        }

        return view('cbr.base', [
            'title' => $title,
            'result' => $result
        ]);

    }

    public function getLastValues(){

        $currency = Currency::all();

        foreach ($currency as $curr){
            $currency_date = CurrencyDate::where('CurrID', $curr->CurrID)->orderBy('id', 'desc')->first();

            $curr->Value = $currency_date->Value;
            $curr->DateValue = $currency_date->DateValue;
            $curr->Nominal = $currency_date->Nominal;
            //dd($curr);
        }

        $title = "Курсы валют ЦБ РФ по состоянию на  <b>" . date('d.m.Y', time()) . "</b><br>";

        return view('cbr.last', [
            'title' => $title,
            'currency' => $currency
        ]);
    }

    public function getLastValuesID($NumCode){

        $currency = Currency::where('NumCode' , $NumCode)->first();

        $currency_date = CurrencyDate::where('CurrID', $currency['CurrID'])->orderBy('id', 'desc')->paginate(Currency::PAGINATE);

        $title = "<b>". $currency -> Name . " (". $currency->NumCode . ")</b><br>";
        $title = $title . "Курсы валют ЦБ РФ по состоянию на  <b>" . date('d.m.Y', time()) . "</b><br>";

        $i = 0;
        $results = [];
        foreach ($currency_date as $curr) {
            $results['labels'][$i] = $curr->DateValue;
            $results['values'][$i] = $curr->Value;
            $i++;
        }
        $results['labels'] = array_reverse($results['labels']);
        $results['values'] = array_reverse($results['values']);

        $chart_title = "Динамика " . $currency -> Name . " с " . $results['labels'][0] . " по " . $results['labels'][$i-1];


        return view('cbr.last_id', [
            'title' => $title,
            'currency' => $currency_date,
            'NumCode' => $currency->NumCode,
            'labels' => $results['labels'],
            'datasets' => array([
                'label' => $chart_title,
                'backgroundColor' => '#3490DC',
                'data' => $results['values'],
            ])
        ]
        );
    }


    public function chartDataID ($NumCode) {

        $currency = Currency::where('NumCode' , $NumCode)->first();

        $currency_date = CurrencyDate::where('CurrID', $currency['CurrID'])->orderBy('id', 'desc')->paginate(Currency::PAGINATE);

        $i = 0;
        $results = [];
        foreach ($currency_date as $curr) {
            $results['labels'][$i] = $curr->DateValue;
            $results['values'][$i] = $curr->Value;
            $i++;
        }
        $results['labels'] = array_reverse($results['labels']);
        $results['values'] = array_reverse($results['values']);


        $chart_title = "Динамика " . $currency -> Name . " с " . $results['labels'][0] . " по " . $results['labels'][$i-1];

        return [
            'labels' => $results['labels'],
            'datasets' => array([
                'label' => $chart_title,
                'backgroundColor' => '#3490DC',
                'data' => $results['values'],
            ])
        ];
    }


    // Сводный график по 2-м валютам, как правило USD и EURO
    public function ChartInfo() {

        $NumCode = Currency::VAl1;
        $currency = Currency::where('NumCode' , $NumCode)->first();

        $currency_date = CurrencyDate::where('CurrID', $currency['CurrID'])->orderBy('id', 'desc')->paginate(Currency::PAGINATE_INFO);

        $i = 0;
        $results = [];
        foreach ($currency_date as $curr) {
            $results['labels'][$i] = $curr->DateValue;
            $results['values'][$i] = $curr->Value;
            $i++;
        }
        $results['labels'] = array_reverse($results['labels']);
        $results['values'] = array_reverse($results['values']);

        $chart_title_1 = "Динамика " . $currency -> Name . " с " . $results['labels'][0] . " по " . $results['labels'][$i-1];

        $NumCode = Currency::VAl2;
        $currency = Currency::where('NumCode' , $NumCode)->first();

        $currency_date = CurrencyDate::where('CurrID', $currency['CurrID'])->orderBy('id', 'desc')->paginate(Currency::PAGINATE_INFO);

        $i = 0;
        $results2 = [];
        foreach ($currency_date as $curr) {
            $results2['labels'][$i] = $curr->DateValue;
            $results2['values'][$i] = $curr->Value;
            $i++;
        }
        $results2['labels'] = array_reverse($results2['labels']);
        $results2['values'] = array_reverse($results2['values']);

        $chart_title_2 = "Динамика " . $currency -> Name . " с " . $results2['labels'][0] . " по " . $results2['labels'][$i-1];

        return [
            'labels' => $results['labels'],
            'datasets' => array(
                [
                    'label' => $chart_title_1,
                    'backgroundColor' => '#1BE22B',
                    'data' => $results['values'],
                ],
                [
                    'label' => $chart_title_2,
                    'backgroundColor' => '#3490DC',
                    'data' => $results2['values'],
                ],
            )
        ];

    }

    // Сводный график и информация по 2-м валютам, как правило USD и EURO
    public function ChartInfoWelcome() {

        $NumCode = Currency::VAl1;
        if((Currency::all()->count() == 0)
        OR (CurrencyDate::all()->count() == 0))
        {
            $report = 'Данные не загружены';
            return view('welcome',
                [
                    'title' => $report,
                    'VAL1Value' => $report,
                    'VAL2Value' => $report,
                    'labels' => []
                    ]);
        }
        $VAL1CurrID = Currency::where('NumCode' , $NumCode)->first()->CurrID;
        $currency = Currency::where('NumCode' , $NumCode)->first();
        $VAL1Value = CurrencyDate::where('CurrID' , $VAL1CurrID)->first()->Value;

        $currency_date = CurrencyDate::where('CurrID', $currency['CurrID'])->orderBy('id', 'desc')->paginate(Currency::PAGINATE_WEL);

        $i = 0;
        $results = [];
        foreach ($currency_date as $curr) {
            $results['labels'][$i] = $curr->DateValue;
            $results['values'][$i] = $curr->Value;
            $i++;
        }
        $results['labels'] = array_reverse($results['labels']);
        $results['values'] = array_reverse($results['values']);

        $chart_title_1 = "Динамика " . $currency -> Name . " с " . $results['labels'][0] . " по " . $results['labels'][$i-1];

        $NumCode = Currency::VAl2;
        $VAL2CurrID = Currency::where('NumCode' , $NumCode)->first()->CurrID;
        $currency = Currency::where('NumCode' , $NumCode)->first();
        $VAL2Value = CurrencyDate::where('CurrID' , $VAL2CurrID)->first()->Value;

        $currency_date = CurrencyDate::where('CurrID', $currency['CurrID'])->orderBy('id', 'desc')->paginate(Currency::PAGINATE_WEL);

        $i = 0;
        $results2 = [];
        foreach ($currency_date as $curr) {
            $results2['labels'][$i] = $curr->DateValue;
            $results2['values'][$i] = $curr->Value;
            $i++;
        }
        $results2['labels'] = array_reverse($results2['labels']);
        $results2['values'] = array_reverse($results2['values']);

        $chart_title_2 = "Динамика " . $currency -> Name . " с " . $results2['labels'][0] . " по " . $results2['labels'][$i-1];

        $title = "<b>". $currency -> Name . " (". $currency->NumCode . ")</b><br>";
        $title = $title . "Курсы валют ЦБ РФ по состоянию на  <b>" . date('d.m.Y', time()) . "</b><br>";

        return view('welcome',
            [
                'title' => $title,
                'VAL1Value' => $VAL1Value,
                'VAL2Value' => $VAL2Value,
                'labels' => $results['labels'],
                'datasets' => array(
                    [
                        'label' => $chart_title_1,
                        'backgroundColor' => '#1BE22B',
                        'data' => $results['values'],
                    ],
                    [
                        'label' => $chart_title_2,
                        'backgroundColor' => '#3490DC',
                        'data' => $results2['values'],
                    ],
                )
            ]);
    }

}
