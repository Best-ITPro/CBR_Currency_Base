<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StartController extends Controller
{
    public function index() {
        $url_data = [
            [
                'title' => 'Best IT Pro',
                'url' => 'http://best-itpro.ru'
            ],
            [
                'title' => 'GitHub',
                'url' => 'https://github.com/Best-ITPro'
            ],
            [
                'title' => 'Facebook',
                'url' => 'https://www.facebook.com/bestitpro/'
            ],
            [
                'title' => 'Twitter',
                'url' => 'https://twitter.com/Best_ITPro'
            ],
            [
                'title' => 'VK.COM',
                'url' => 'https://vk.com/bestitpro'
            ]
        ];

        return view('start', [
            'url_data' => $url_data
        ]);

    }

    public function getJson() {

        return  [
            [
                'title' => 'Best IT Pro',
                'url' => 'http://best-itpro.ru'
            ],
            [
                'title' => 'GitHub',
                'url' => 'https://github.com/Best-ITPro'
            ],
            [
                'title' => 'Facebook',
                'url' => 'https://www.facebook.com/bestitpro/'
            ],
            [
                'title' => 'Twitter',
                'url' => 'https://twitter.com/Best_ITPro'
            ],
            [
                'title' => 'VK.COM',
                'url' => 'https://vk.com/bestitpro'
            ]
        ];
    }


    public function chartData () {
        return [
            'labels' => [ 'январь', 'февраль', 'март', 'апрель', 'май' ],
            'datasets' => array([
                'label' => 'Остаток',
                'backgroundColor' => '#F00',
                'data' => [ 609200, 597065, 572582, 559908, 554396 ],
            ])
        ];
    }

    public function chartRandom(){
        return [
            'labels' => [ 'январь', 'февраль', 'март', 'апрель', 'май' ],
            'datasets' => array(
                [
                'label' => 'Остаток',
                'backgroundColor' => '#F00',
                'data' => [ rand(0,600000), rand(0,600000), rand(0,600000), rand(0,600000), rand(0,600000) ],
                ],
                [
                    'label' => 'Доход',
                    'backgroundColor' => '#F26202',
                    'data' => [ rand(0,600000), rand(0,600000), rand(0,600000), rand(0,600000), rand(0,600000) ],
                ],
                )
        ];
    }


}
