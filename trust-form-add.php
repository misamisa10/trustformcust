<body>
<?php
if(!isset($_REQUEST['step'])){
?>
<h1>応募用フォーム詳細設定</h1>
<h2>STEP 1: ファイルの選択</h2>
<p>シリアルファイルを選択してください。<br />
<form action='' method="post" enctype="multipart/form-data">
ファイル：<br />
<input type="file" name="upfile" size="30" /><br />
<br /></p>
<input type='hidden' name='step' value='1'>
<input type="submit" value="アップロード" />
</form>
<p>
<?php
}
//	require('trust-form-step1.php');
if(isset($_FILES) && isset($_REQUEST['step']) && $_REQUEST['step']==1){
	require_once('trust-form-step1.php');
}
if(isset($_REQUEST['step']) && $_REQUEST['step']==2){
	require_once('trust-form-step2.php');
}
?>
</body>
