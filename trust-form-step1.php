<body>
<?php
//STEP1はcsvファイルをDBへ登録する処理
// sqlへのデータ登録
function table_add($_FILES){
$pathData = pathinfo($_FILES["upfile"]["name"]);
$table = $pathData["filename"];
//mysqlを使用するためのグローバル関数定義
//$table = $_FILES["upfile"]["name"];
$jal_db_version = "1.0";
global $wpdb;
global $jal_db_version;

//tableの作成

   $table_name = $wpdb->prefix . $table;
      if($wpdb->get_var("show tables like '$table_name'") != $table_name) {

	  $sql = "CREATE TABLE ".$table_name." (
  serial VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
	  count INT(11) DEFAULT NULL
	  );";

	  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	  dbDelta($sql);
	  }
 //csvファイルのアップロード
 $sql = sprintf('LOAD DATA INFILE "/tmp/%s" INTO TABLE %s FIELDS TERMINATED BY \',\' ENCLOSED BY \'"\''
 ,$_FILES["upfile"]["name"] ,$table_name );

$wpdb->query($sql);

return $table;

}
?>
<p>
<?php
// 	if(is_uploaded_file($_FILES["upfile"]["tmp_name"])){
	  if (@move_uploaded_file($_FILES["upfile"]["tmp_name"], "/tmp/" . $_FILES["upfile"]["name"])) {
       chmod("/tmp/" . $_FILES["upfile"]["name"], 0644);
	   echo $_FILES["upfile"]["name"] . "をアップロードしました。";
	   $table = table_add($_FILES);
print<<<EOF
	   <h2>詳細設定</h2>
	   <form action='' method="POST">
	   <p>
	   <div>固定ページのページID(trustFormを設置している固定ページのID)
	   <input type='text' name='trustForm' value=""></div>

	   <div>固定ページのページID(応募フォームを設置する固定ページのID)
	   <input type='text' name='pageid' value=""></div>
	   <input type='hidden' name='step' value='2'>
	   <input type='hidden' name='table' value='$table'>
	   <input type="submit" value="送信">
	   </p>
	   </form>
EOF;
	} else {
	   echo "ファイルをアップロードできません。";
	}
// }
?>
</p>
</body>
