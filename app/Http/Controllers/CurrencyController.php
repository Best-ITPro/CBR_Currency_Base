<?php
// Курсы валют - список

namespace App\Http\Controllers;

use \App\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{

    public function load() {

        $currency = simplexml_load_file(Currency::CBR_URL_DAILY) or die ("error cannot create object");

        $title = "Курсы валют ЦБ РФ, установлены на  <b>" . $currency['Date'] . "</b><br>";
        $result = "";
        $count = count(Currency::all());

        foreach ($currency->Valute as $curr) {

            $result = $result . $curr['ID'] . " - " . $curr -> Name . "<br>";
            $result = $result . $curr->NumCode ." : ". $curr->CharCode . " : ". $curr->Nominal . " = " . $curr->Value ."<br>";

            // Первоначальное заполнение базы
            if(count(Currency::where('CurrID', $curr['ID'] )->get()) == 0)
            {
                $result = $result . $curr -> Name ." в базе не найден, добавляем!<br><br>";
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
                $result = $result . $curr -> Name ." есть в базе, обновление не требуется!<br><br>";
            }
        }

        return view('cbr.list', [
            'title' => $title,
            'result' => $result
        ]);
    }
}
