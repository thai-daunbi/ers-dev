<?php

#- PDO Wrapper Class
include_once(__DIR__.'/class.db.php');

#- db info
define('HOSTNAME',	'localhost');
define('USERNAME',	'root');
define('PASSWORD',	'');
define('DATABASE',	'test_employee');

#- pager
$mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
$mysqli->set_charset("utf8");

#- db 
$dsn = 'mysql:host='.HOSTNAME.';dbname='.DATABASE.';charset=utf8';
try {
	$db = new db($dsn, USERNAME, PASSWORD);
} catch (PDOException $e) {
	exit('DB Error:'.$e->getMessage());
	die();
}

#- Debug
function debug($value)
{
	if (empty($value)) {
		return false;
	}

	if (is_array($value) or is_object($value)) {
		echo '<div class="debug"><b>debug::</b><pre>';
		print_r($value);
		echo "</pre></div>";
	} else {
		echo '<div class="debug"><b>debug::</b> '.$value.'</div>';
	}
	return true;
}

function dump($value)
{
	if (empty($value)) {
		return false;
	}

	if (is_array($value) or is_object($value)) {
		echo '<div class="debug"><b>debug::</b><pre>';
		var_dump($value);
		echo "</pre></div>";
	} else {
		echo '<div class="debug"><b>debug::</b> '.$value.'</div>';
	}
	return true;
}

function error($value, $msg=null)
{
	if (empty($value)) {
		return false;
	}

	if (is_array($value)) {
		echo '<div class="error"><b>error::</b>'.$msg.'<pre>';
		print_r($value);
		echo "</pre></div>";
	} else {
		if (!empty($msg)) {
			$msg .= " ";
		}
		echo '<div class="error"><b>error::</b> '.$msg.$value.'</div>';
	}
	return true;
}

$flagFile = __DIR__ . '/data_added_flag.txt';
$fp = fopen('../sql/13TOKYO.CSV', 'r');

if (!file_exists($flagFile)) {
    try {
		$db = new PDO("mysql:host=".HOSTNAME.";dbname=".DATABASE, USERNAME, PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		for ($i = 0; $i < 100; $i++) {
			$departmentName = "Department " . ($i + 1);

			$sql = "INSERT INTO department (department_name) VALUES (:departmentName)";
			
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':departmentName', $departmentName);
			$stmt->execute();
		}

		for ($i = 0; $i < 100; $i++) {
			$todofukenName = "Todofuken " . ($i + 1);

			$sql = "INSERT INTO todofuken (todofuken_name) VALUES (:todofukenName)";
			
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':todofukenName', $todofukenName);
			$stmt->execute();
		}

		for ($i = 0; $i < 100; $i++) {
			$name = "User " . ($i + 1);
			$departmentId = rand(1, 10); 
			$gender = ($i % 2 == 0) ? "Male" : "Female";
			$age = rand(20, 60); 
			$email = "user" . ($i + 1) . "@example.com";
			$zipcode = sprintf("%05d", rand(10000, 99999));
			$todofukenId = rand(1, 5); 
			$address = "Address " . ($i + 1);

			$sql = "INSERT INTO employee (name, department_id, gender, age, email, postal_code, todofuken_id, other_address) 
					VALUES (:name, :departmentId, :gender, :age, :email, :zipcode, :todofukenId, :address)";
			
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':departmentId', $departmentId);
			$stmt->bindParam(':gender', $gender);
			$stmt->bindParam(':age', $age);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':zipcode', $zipcode);
			$stmt->bindParam(':todofukenId', $todofukenId);
			$stmt->bindParam(':address', $address);
			
			$stmt->execute();
		}

        file_put_contents($flagFile, 'Data added');
        
        echo "100 records have been successfully added to department, todofuken, and employee tables.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Data has already been added.";
}


$db = null;
?>
