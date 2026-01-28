<?php
class WordFilter {
	public static function checkBlocked($sentence) {
		$blockedTerms = __DIR__ . "/../../config/blockedTerms.txt";
		$handle = fopen($blockedTerms, "r");

		if ($handle) {
			while (($line = fgets($handle)) !== false) {
				if (stripos($sentence, $line) !== false) {
					return true;
				}
			}
			fclose($handle);
		}

		return false;
	}
}
?>