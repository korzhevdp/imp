<!DOCTYPE html>
<html>
<head>
	<title><?=$title;?></title>
	<meta name="keywords" content="<?=$keywords;?>">
	<meta name='yandex-verification' content='74872298f6a53977' />
	<link href="<?=$this->config->item("api");?>/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?=$this->config->item("api");?>/css/nomapfrontend.css" rel="stylesheet" media="screen" type="text/css">
</head>

<body>
	<!-- menu -->
	<div class="navbar navbar-inverse">
		<div class="navbar-inner">
			<?=$brand.$menu;?>
		</div>
	</div>
	<!-- menu -->

	<!-- content -->
		<?=$content;?>
	<!-- content -->
		<?=$comment;?>

	<!-- Modal -->
		<?=$modals;?>
	<!-- Modal -->
	
	<?=$footer;?>
	<div class="grayFooter">
		Звонки по вопросам размещения принимает Роман - специалист по найму жилья с 20-летним опытом работы.<br>
		<div class="moreinfo">
			&copy;2010-<?=date("Y");?><br>
			Основано на проекте MiniGIS.NET<br>
			Не является средством массовой информации<br>
			Номер в реестре распространителей информации: хххххх<br>
			Сайт использует технологию cookies<br>
			Сайт не собирает информации о посетителях, кроме той, которую посетители заполняют сами<br>
			Сайт не собирает информации о банковских картах<br>
		</div>
	</div>
	<script src="<?=$this->config->item("api");?>/jscript/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?=$this->config->item("api");?>/bootstrap/js/bootstrap.js"></script>
</body>
</html>