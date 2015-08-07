<body>
<p>
<?php
	function step_2($table){
	print(var_dump($_POST));
	echo "<br />";
	if(isset($_POST['trustForm'])){
		$trustForm = $_POST['trustForm'];
		$page_id = $_POST['pageid'];
		$fp = fopen('/tmp/function.txt', 'ab');
		$count = count(file('/tmp/function.txt'));
		if($fp){
			$count = $count+1;
			$data = sprintf('"'.$count.'","'.$table.'","'.$trustForm.'","'.$page_id.'"');
			fwrite($fp,$data."\n");
		}
		fclose($fp);

		echo "設定の書き込みが完了しました。";
				  echo "以下のIDをはりつけてください。<br />";
				  echo "[TrustFormCustom id=".$count."]";
	}
?>
</p>

<?php
//echo "登録に失敗しました。";
	}
$table = $_REQUEST['table'];
step_2($table);
?>
</body>
