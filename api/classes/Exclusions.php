<?php

class Exclusions {
    public $displayName = null;
    public $playstation = null;
    public $xbox = null;

    public function __construct($object) {
        $this->displayName = $object['displayName'];
        $this->playstation = $object['playstation'];
        $this->xbox = $object['xbox'];
    }

    public static function getDestinyAccount($membershipType, $membershipId) {
		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/exclusions.json')) {
			$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/exclusions.json'), true);
		} else {
			return false;
		}

        $match = array_filter($file, function($item) use ($membershipType, $membershipId) {
            if ($membershipType == 2) {
                return $membershipId == $item['playstation'];
            } elseif ($membershipType == 1) {
                return $membershipId == $item['xbox'];
            } else {
                return false;
            }
        });

        if (count($match) > 0) {
            return new Exclusions($match[0]);
        } else {
            return false;
        }
    }
}