<?php

namespace Apine\Modules\WOD;


class Player {

    public $id;

    public $console;

    public $username;

    public $seconds;

    public function setId($a_id) {
        $this->id = $a_id;
    }

    public function setConsole($a_console) {
        $this->console = $a_console;
    }

    public function setUsername($a_username) {
        $this->username = $a_username;
    }

    public function setSeconds($a_seconds) {
        $this->seconds = $a_seconds;
    }

    public function getId() {
        return $this->id;
    }

    public function getConsole() {
        return $this->console;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getSeconds() {
        return $this->seconds;
    }
}