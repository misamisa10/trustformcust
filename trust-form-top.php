<?php

function TrustFormCustom($atts){

	extract(shortcode_atts(array(
		'id' => 'id'
		), $atts)
	);
//echo $id;
//$t_name = $table_name;
//echo $t_name;
$j=0;
$fp = fopen('/tmp/function.txt', 'r');
while($contents = fgetcsv($fp, 256 )){$j++;
   	 if($j == $id){
	   for($i = 0; $i < 4; ++$i ){
	   $table = $contents['1'];
	   $trustform = $contents['2'];
	   $page_id = $contents['3'];
//	      echo("[".$contents[$i]."]");
//		  echo "<br />";
		}
	}
}
fclose($fp);
/*
$wpdbのデータベース名をデータベースに合わせて手動で変更すること！！
＊接頭語「wp_」は不要なので注意！！
/var/www/html/wordpress/wp-includes/wp-db.php の208行目にデータベース名を追加すること。
*/
//mysqlを使用するためのグローバル関数定義（定義済み）
global $wpdb;
$wp_table = "wp_".$table;
// シリアル名（検索キーワード)
$serial = isset($_GET['keyword']) ? $_GET['keyword'] : "";
			   
// 検索結果メッセージ
$message = ( isset($_GET['keyword']) && (!$serial) ) ? "シリアル名を入力してください。" : "";

if ($serial) {
//発行するsql文の作成
/****** [tsuri_3rd_single]の部分を登録したデータベースの名前に変更する ******/
$sql = sprintf("SELECT serial,count FROM %s WHERE serial='%s'", $wp_table, $serial);
//echo $sql."<br />";
//sqlの実行
$query_serial = $wpdb->get_results($sql);

// 検索結果メッセージ
$message = (!$query_serial) ? "<b>該当するシリアルが見つかりませんでした。再度ご確認し入力ください。</b>" : "";
}
												    
//製品価格を表示
if(isset($query_serial)){
foreach ($query_serial as $qserial) {
if($qserial->count==1)
{
echo "<p>シリアル番号【".$qserial->serial."】は既に応募済みです。再度シリアル番号をお確かめください。</p>";
}else{
//発行するsql文の作成
/****** [tsuri_3rd_single]の部分を登録したデータベースの名前に変更する ******/
$sql = sprintf("UPDATE %s SET count=1 WHERE serial='%s'", $wp_table, $serial);

//sqlの実行
$update_count = $wpdb->query($sql);

//応募フォームへのリダイレクト
//$url = sprintf("http://54.64.83.95/wordpress/?page_id=456", $serial);
//wp_redirect($url,303);
//exit;
echo do_shortcode($trustform);
exit;
}
}
}

?>

<!-- 製品価格検索フォーム -->
<?php
echo '<form class="" id="" role="search" action="./" method="get">'; 
echo '<input type="hidden" name="page_id" value="'.$page_id.'" />';
echo '<div>';

//<!-- キーワード入力欄 -->
echo '<label for="search_box">シリアルナンバーを入力してください。</label>';
echo '<input class="" id="search_box" type="text" name="keyword" placeholder="" maxlength="7"  value="'.$serial.'" />';

																					    
//<!-- ボタン -->
echo '<input id="price-search-button" class="searchsubmit" type="submit" value="確定する" />';
echo '</div>';
echo '</form>';
																												 
//<!-- 検索結果メッセージ -->
echo '<p>';
echo $message;
echo '</p>';
}

add_shortcode('TrustFormCustom', 'TrustFormCustom');
?>
