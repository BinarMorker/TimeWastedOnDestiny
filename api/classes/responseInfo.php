<?php

abstract class ResponseInfo {

	abstract function getStatus();
	abstract function getErrorCode();
	abstract function getMessage();

}