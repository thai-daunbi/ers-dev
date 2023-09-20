<?php

#- PDO Wrapper Class
include_once(__DIR__.'/class.db.php');

#- db info
define('HOSTNAME',	'localhost');
define('USERNAME',	'test');
define('PASSWORD',	'pass');
define('DATABASE',	'test_employee');

#- pager용 mysqli 설정
$mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
$mysqli->set_charset("utf8");

#- db 연결
$dsn = 'mysql:host='.HOSTNAME.';dbname='.DATABASE.';charset=utf8';
try {
	$db = new db($dsn, USERNAME, PASSWORD);
} catch (PDOException $e) {
	exit('DB Error:'.$e->getMessage());
	die();
}

#- Debug 함수 정의
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

try {
    $conn = new PDO("mysql:host=".HOSTNAME.";dbname=".DATABASE, USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 100개의 샘플 데이터를 추가
    for ($i = 0; $i < 100; $i++) {
        $name = "User " . ($i + 1);
        $departmentId = rand(1, 10); // 부서 ID는 1부터 10까지 랜덤으로 생성
        $gender = ($i % 2 == 0) ? "Male" : "Female";
        $age = rand(20, 60); // 20에서 60 사이의 나이 랜덤 생성
        $email = "user" . ($i + 1) . "@example.com";
        $zipcode = sprintf("%05d", rand(10000, 99999)); // 5자리 우편번호 랜덤 생성
        $todofukenId = rand(1, 5); // 토도후켄 ID는 1부터 5까지 랜덤으로 생성
        $address = "Address " . ($i + 1);

        // SQL INSERT 문 실행
        $sql = "INSERT INTO employees (name, department_id, gender, age, email, zip_code, todofuken_id, other_address) 
                VALUES (:name, :departmentId, :gender, :age, :email, :zipcode, :todofukenId, :address)";
        
        $stmt = $conn->prepare($sql);
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

    echo "100 records have been successfully added.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// 데이터베이스 연결 종료
$conn = null;
?>
