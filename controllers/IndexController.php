<?php

namespace Apine\Controllers\User;

use Apine\MVC\TwigView;
use Apine\Utility\Routes;

class IndexController {

    public function index($params) {
        $view = new TwigView();
        $view->set_view("index");

        $hdceAds = [
            [
                'text' => "See how you can change for hybrid cloud with HDCE",
                'link' => "https://www.hdce.ca/en/serveur-vm-dedier/"
            ],
            [
                'text' => "Why is this website accessible? Because of HDCE High Availability Hosting",
                'link' => "https://www.hdce.ca/en/serveur-vm-dedier/"
            ],
            [
                'text' => "Tired of asking your colleague's availability? HDCE Cloud Mail got you covered",
                'link' => "https://www.hdce.ca/en/services-offerts/courriels-collaboratifs/"
            ],
            [
                'text' => "You can count on us with our Cloud Accounting Solution!",
                'link' => "https://www.hdce.ca/en/systeme-comptable-cloud/"
            ],
            [
                'text' => "Tired of having to check your servers each day? HDCE Cloud Monitoring",
                'link' => "https://www.hdce.ca/en/services-offerts/telesurveillance-des-infrastructures/"
            ],
            [
                'text' => "Link-File, an HDCE exclusivity, gives you the ability to send Terabytes through emails",
                'link' => "https://www.hdce.ca/en/linkfile/"
            ]
        ];

        $index = rand(0, count($hdceAds) - 1);

        $view->set_param('hdceAdText', $hdceAds[$index]['text']);
        $view->set_param('hdceAdLink', $hdceAds[$index]['link']);

        if (isset($params[0])) {
            $view->set_param('search', $params[0]);
        }

        return $view;
    }

    public function about() {
        $view = new TwigView();
        $view->set_view("about");
        return $view;
    }

    public function redirect() {
        return Routes::internal_redirect('');
    }

}