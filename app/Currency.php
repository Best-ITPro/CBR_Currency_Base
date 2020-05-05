<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    const CBR_URL_DAILY = "http://www.cbr.ru/scripts/XML_daily.asp";
    // http://www.cbr.ru/scripts/XML_dynamic.asp?date_req1=01/01/1997&date_req2=05/05/2020&VAL_NM_RQ=R01235
    const CBR_URL_DINAMIC = "http://www.cbr.ru/scripts/XML_dynamic.asp";

    // Дата начальной загрузки (глубина)
    const DATE_FROM = "01/06/2019";

    // Период - разбиение на интервалы
    const INTERVAL = 80;

    // Пагинация общая
    const PAGINATE = 15;
    // Пагинация на странице Info
    const PAGINATE_INFO = 17;
    // Пагинация на странице Welcome
    const PAGINATE_WEL = 10;

    // Сводный график по 2-м валютам, как правило USD и EURO
    const VAl1 = '840';
    const VAl2 = '978';

    public function best_debug($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}
