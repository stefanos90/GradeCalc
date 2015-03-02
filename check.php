<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<html>
<head>
	<title>Αυτόματος Υπολογισμός Πτυχίου</title>
	<link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
<div class="wraper">
<?php
/*
table: 		id="mainTable"
courxe: 	class="topBorderLight"
*/
include_once("simple_html_dom.php");


$username = $_POST['username'];
$password = $_POST['password'];

//username and password of account
if (!isset($username) || !isset($password)) {
	header("Location: index.php?msg=empty");
	exit();

}


//login form action url
$url="http://e-secretariat.teikav.edu.gr/unistudent/"; 
$postinfo = "userName=".$username."&pwd=".$password."&submit1=%C5%DF%F3%EF%E4%EF%F2&loginTrue=login";

//set the directory for the cookie
$cookie_file_path = "/var/www/stefanos/grade/cookie.txt";

$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
//set the cookie the site has for certain features, this is optional
curl_setopt($ch, CURLOPT_COOKIE, "cookiename=0");
curl_setopt($ch, CURLOPT_USERAGENT,
    "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfo);
curl_exec($ch);

//page to grab
curl_setopt($ch, CURLOPT_URL, "http://e-secretariat.teikav.edu.gr/unistudent/stud_CResults.asp?studPg=1&mnuid=mnu3&");

$html = curl_exec($ch);

if (curl_error($ch)) {
    echo curl_error($ch);
    exit();
}
//check for e-secretary redurect header. 
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($html, 0, $header_size);

if (strpos($header,'HTTP/1.1 302 Object moved') !== false) {
    header("Location: index.php?msg=pass");
}

curl_close($ch);


$doc 	= new DOMDocument();
libxml_use_internal_errors(true);
$doc->loadHTML($html);
$finder = new DomXPath($doc);
$node 	= $finder->query("//*[contains(@class, 'topBorderLight')]");

$data 	= array();
foreach ($node as $key => $value) {

	$data[]=$doc->saveHTML($node->item($key));

}

$course=0;
$b1d1;
$DM 		= array();
$grades		= array();
$courses 	= array();
foreach ($data as $value) {
	//echo $data[$course]." ΔΜ: ".$data[$course+2]." Βαθμος: ".$data[$course+5] ."<br>";
	
	@$tmp_grade 	= filter_var($data[$course+5], FILTER_SANITIZE_NUMBER_FLOAT);
	@$tmp_dm		= filter_var($data[$course+2], FILTER_SANITIZE_NUMBER_INT);
	
	if ($tmp_grade!="-" && $tmp_grade>4.99) {
		
		@$courses[]	= strip_tags($data[$course]);

		if ($tmp_grade>10 && $tmp_grade!=10 && $tmp_grade>=50){
			$grades[]=$tmp_grade/10;
			$DM[] 		= $tmp_dm;
			//echo $tmp_grade/10 . "<br>";
		}
		else if($tmp_grade<=10 && $tmp_grade>4) {
			$grades[]	= $tmp_grade;
			$DM[] 		= $tmp_dm;
			//echo $tmp_grade . "<br>";
		}		
	}

	
	$course=$course+7;
	if ($course>count($data)) {
		break;
	}

}

foreach ($DM as $key => $value) {
	@$b1d1 = $b1d1 + ($DM[$key]*$grades[$key]) ."<br>";
}

echo '<span class="msgGrade">Βαθμός πτυχίου: ' . round($b1d1/(array_sum($DM)),5)."</span><br>";

if (findLIKE("(ΠΤΥΧ)",$courses)){
	echo '<span class="msgSubGrade">Υπολογίστηκαν <span style="color:red;">'. count($grades) . '</span> μαθήματα μαζί με Πτυχιακή'."<br>";
}
else{
	echo '<span class="msgSubGrade">Υπολογίστηκαν <span style="color:red;">'. count($grades) . '</span> μαθήματα ΧΩΡΙΣ Πτυχιακή.<br>';	
}
echo 'Έχεις <span style="color:red;">'.array_sum($DM).'</span> διδακτικές μονάδες</span> <br>';
echo '<span class="msgSubGrade">Υπολογίστηκαν τα παρακάτω περασμένα μαθήματα: </span><br>';



function findLIKE($what,$where){
	global $courses;
	$input = preg_quote($what, '~');
	$result = preg_grep('~' . $input . '~', $where);
	if (empty($result)) {
		return false;
	}	
	else
		reset($result);
 		unset($courses[key($result)]);
 		$courses = array_values($courses);
		return true;

}



?>

</div>
<p class="msg">
<?php
foreach ($courses as $value) {

	echo $value . "<br>";
}
?>
</p>
</body>
</html>