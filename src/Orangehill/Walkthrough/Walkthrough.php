<?php namespace Orangehill\Walkthrough;

class Walkthrough {

	public static function hello($verb = 'up'){
		if (PHP_SAPI == 'cli') echo "What's $verb Zagreb?\n";
		return "What's up Zagreb?";
	}

}
