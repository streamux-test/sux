
<?
session_start();
include "../lib.php";

$board = $_REQUEST[board];
$board_grg = $_REQUEST[board_grg];
$id = $_REQUEST[id];
$igroup = $_REQUEST[igroup];
$passover = $_REQUEST[passover];
$page = $_REQUEST[page];
$sid = $_REQUEST[sid];
$ljs_mod = $_REQUEST[ljs_mod];

$result = mysql_query("select * from $board_group where name='$board'");
$row = mysql_fetch_array($result);
$name = $row[name];
$width = $row[width];
$include1 = $row[include1];
$include2 = $row[include2];
$include3 = $row[include3];
$day = $row[date];
$w_admin = $row[w_admin];
$r_admin = $row[r_admin];
$rw_admin = $row[rw_admin];
$re_admin = $row[re_admin];
$listnum = $row[listnum];
$limit_word = $row[limit_word];
$tail = $row[tail];
$download = $row[download];
$setup = $row[setup];
$w_grade = $row[w_grade];
$r_grade = $row[r_grade];
$rw_grade = $row[rw_grade];
$re_grade = $row[re_grade];
$limit_choice = $row[limit_choice];

if ($limit_word){
	$word_nums = split(",", $limit_word);
	$nums_count = count($word_nums); 

	for ($i=0; $i<$nums_count; $i++) {
		$limit_str = $word_nums[$i];

		if ($limit_choice == title) {
			$result2 = mysql_query("delete from $board where title like '%$limit_str%' order by id desc");
		} else if ($limit_choice == comment) {
			$result2 = mysql_query("delete from $board where comment like '%$limit_str%' order by id desc");
		} else {
			$result2 = mysql_query("delete from $board where title like '%$limit_str%' and comment like '%$limit_str%' and order by id desc");
		}
	}
}

$skin_path = "skin/${include2}";

if($include1){
	include "$include1";
}else{
	echo "상단 파일경로를 입력해 해주세요! 예)파일명.php";
}

if($include2){
	include "${skin_path}/list.php";
}else{
	echo "스킨을 선택해주세요!";
}

if($include3){
	include "$include3";
}else{
	echo "하단 파일경로를 입력해 해주세요! 예)파일명.php";
}
?>