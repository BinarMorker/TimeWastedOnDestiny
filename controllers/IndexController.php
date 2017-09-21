<?php

namespace Apine\Controllers\User;

use Apine\MVC\TwigView;
use Apine\MVC\URLHelper;
use Apine\Utility\Routes;

class IndexController {

    public function index($params) {
        $view = new TwigView();
        $view->set_view("index");

        if (isset($params[0])) {
            $view->set_param('search', $params[0]);
        }

        return $view;
    }

    public function redirect() {
        return Routes::internal_redirect('');
    }

}