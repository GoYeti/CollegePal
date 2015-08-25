<?php
$dbType = "mysql";
$dbHost = "localhost";
$dbName = "ue";
$userName = "root";
$passWord = "root";
$dsn = "$dbType:host=$dbHost;dbname=$dbName";
$dbh = new PDO ( $dsn, $userName, $passWord );

function sqlSelect($sqlTable, $parameters, $sqlCol = "", $orderBy = "") {
	if ($orderBy != "")
		$sqlOrder = " order by '" . $orderBy . "'";
	if ($sqlCol == "")
		$sqlCol = "*";
	$countParameterts = count ( $parameters );
	$sql = "";
	$sqlAnd = " AND ";
	if ($countParameterts == 0) {
		$sql = "SELECT * FROM $sqlTable";
		return $sql;
	} else {
		foreach ( $parameters as $key => $value ) {
			if ($sql == "") {
				$sql = "SELECT $sqlCol FROM $sqlTable WHERE ";
				$sqlMore = "$key = '$value'";
				$sql = $sql . $sqlMore;
			} else {
				$sqlMore = "$sqlAnd$key = '$value'";
				$sql = $sql . $sqlMore;
			}
		}
		return $sql;
	}
}
function sqlInsert($sqlTable, $parameters) {
	// INSERT INTO userInfo (name,gender) VALUES ("Yeti","1");
	$sql = "";
	$count = count ( $parameters );
	if ($count == 0) {
		$sql = null;
		return false;
	}
	for($i = 0; $i < $count; $i ++) {
		$key = key ( $parameters );
		$value = current ( $parameters );
		if ($count == 1) {
			$sql = "INSERT INTO $sqlTable ($key) VALUES ('$value')";
		} else if ($count > 1) {
			if ($i == 0) {
				$sqlKey = $key;
				$sqlValue = $value;
				$sql = "INSERT INTO $sqlTable ($sqlKey) VALUES ('$sqlValue')";
			} else if ($i > 0) {
				$sqlKey = $sqlKey . ",$key";
				$sqlValue = $sqlValue . "','$value";
				$sql = "INSERT INTO $sqlTable ($sqlKey) VALUES ('$sqlValue')";
			}
		}
		next ( $parameters );
	}
	return $sql;
}
function sqlEcxucte($sql) {
	global $dbh;
	$sth = $dbh->prepare ( $sql );
	$rs = $sth->execute ();
	if ($rs === true && is_array ( $rs )) {
		return true;
	} else if ($rs === false) {
		return false;
	}
	$result = $sth->fetch ();
	// echo $result;
	return $result;
}

$para = array (
// 		"userName" => "4",
// 		"name" => "yeti",
// 		"passWord" => "123",
// 		"gender" => "1" 
);
?>