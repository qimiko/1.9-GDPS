<?php
require_once dirname(__FILE__)."/XORCipher.php";
require_once dirname(__FILE__)."/generatePass.php";
include_once dirname(__FILE__)."/mainLib.php";

class GJPCheck {
	public static function check($gjp, $accountID) {
		include dirname(__FILE__)."/connection.php";
		include dirname(__FILE__)."/../../config/security.php";

		if (self::checkSession($gjp, $accountID)) {
			return 1;
		}

		$ml = new mainLib();
		if($sessionGrants){
			$ip = $ml->getIP();
			$query = $db->prepare("SELECT count(*) FROM actions WHERE type = 16 AND value = :accountID AND value2 = :ip AND timestamp > :timestamp");
			$query->execute([':accountID' => $accountID, ':ip' => $ip, ':timestamp' => time() - 3600]);
			if($query->fetchColumn() > 0){
				return 1;
			}
		}
		$gjpdecode = str_replace("_","/",$gjp);
		$gjpdecode = str_replace("-","+",$gjpdecode);
		$gjpdecode = base64_decode($gjpdecode);
		$gjpdecode = XORCipher::cipher($gjpdecode,37526);
		$validationResult = GeneratePass::isValid($accountID, $gjpdecode);
		if($validationResult == 1 AND $sessionGrants){
			$ip = $ml->getIP();
			$query = $db->prepare("INSERT INTO actions (type, value, value2, timestamp) VALUES (16, :accountID, :ip, :timestamp)");
			$query->execute([':accountID' => $accountID, ':ip' => $ip, ':timestamp' => time()]);
		}
		return $validationResult;
	}

	public static function validateGJPOrDie($gjp, $accountID){
		if(self::check($gjp, $accountID) != 1)
			exit("-1");
	}

	public static function validateGJP2OrDie($gjp2, $accountID){
		if(GeneratePass::isGJP2Valid($accountID, $gjp2) != 1)
			exit("-1");
	}

	/**
	 * Gets accountID and from the POST parameters and validates if the provided GJP matches
	 *
	 * @return     The account id
	 */
	public static function getAccountIDOrDie(){
		require_once "../lib/exploitPatch.php";
		require_once dirname(__FILE__)."/sessions.php";
		require_once dirname(__FILE__)."/auth.php";

		if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
			$userToken = trim(str_replace('Bearer', '', $_SERVER['HTTP_AUTHORIZATION']));
			$id = Auth::get_auth_user($userToken);
			if ($id != -1) {
				return $id;
			}
		}

		if(empty($_POST['accountID'])) exit("-1");

		$accountID = ExploitPatch::remove($_POST["accountID"]);

		if (AccSession::checkSession($accountID)) {
			return $accountID;
		}

		if(!empty($_POST['gjp'])) self::validateGJPOrDie($_POST['gjp'], $accountID);
		elseif(!empty($_POST['gjp2'])) self::validateGJP2OrDie($_POST['gjp2'], $accountID);
		else exit("-1");

		return $accountID;
	}

	public static function checkSession($gjp, $accountID)
	{
		require_once dirname(__FILE__)."/sessions.php";
		require_once dirname(__FILE__)."/auth.php";
		include dirname(__FILE__)."/connection.php";

		if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
			$userToken = trim(str_replace('Bearer', '', $_SERVER['HTTP_AUTHORIZATION']));
			return Auth::check_auth_user($userToken, $accountID);
		}

		$gjp = "";
		return AccSession::checkSession($accountID);
	}
}
?>
