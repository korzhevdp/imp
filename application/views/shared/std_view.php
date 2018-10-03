<!doctype html>
<html>
<head>
	<title><?=$name;?></title>
	<meta name='yandex-verification' content='74872298f6a53977' />
</head>

<body>
	<img src="/images/flag_ru.png" id="langFlag" width="32" height="32" border="0" alt="">
	<div class="stdViewHeader">
		<?=$name;?>&nbsp;&nbsp;&mdash;&nbsp;&nbsp;<?=$location_name;?>
	</div>
	<div class="stdView">
		<img id="minimap" src="/images/minimaps/<?=$friendly_id;?>.png" title="<?=$address.", ".substr($lat, 0, 9).",".substr($lon, 0, 9);?>" alt="minimap">
		<div class="address"><i class="icon-home"></i>&nbsp;&nbsp;<?=$address;?></div>
		<div class="contacts"><i class="icon-envelope"></i>&nbsp;&nbsp;<?=$contact;?></div>
		<div class="coordinates">
			<i class="icon-map-marker"></i>&nbsp;&nbsp;<span><?=substr($lat, 0, 9).",".substr($lon, 0, 9);?></span>
		</div>
		
		<div class="locationImages">
		<h4>Фотографии</h4>
			<?=(isset($all_images) && strlen($all_images)) ? $all_images : "" ;?>
		</div>

	</div>
	<div class="stdViewContent">
		<?=$content;?>
	</div>

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

	<div class="modal hide fade" id="langSelector" style="width:440px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><i class="icon-remove"></i></button>
			<?//=$lang_header;?>
		</div>
		<div class="modal-body">
			<form method=post action="/map/set_language">
				<button type="submit" class="btn btn-large langSubmitter" name="lang" value="ru" title="Russian">
				<img src="/images/flag_ru.png" width="32" height="32" border="0" alt=""></button>
				<button type="submit" class="btn btn-large langSubmitter" name="lang" value="en" title="English"><img src="/images/flag_en.png" width="32" height="32" border="0" alt=""></button>
				<button type="submit" class="btn btn-large langSubmitter" name="lang" value="de" title="German"><img src="/images/flag_de.png" width="32" height="32" border="0" alt=""></button>
				<button type="submit" class="btn btn-large langSubmitter" name="lang" value="es" title="Spanish"><img src="/images/flag_es.png" width="32" height="32" border="0" alt=""></button>
				<input type="hidden" name="redirect" value="/lodging/<?=$friendly_id;?>">
			</form>
		</div>
		<div class="modal-footer"></div>
	</div>

	<div class="modal hide fade" id="imgViewer">
		<div class="modal-header" style="height:30px;">
			Фото<button type="button" class="close" data-dismiss="modal"><i class="icon-remove"></i></button>
		</div>
		<div class="modal-body" id="viewer">
			
		</div>
		<div class="modal-footer"></div>
	</div>
	
	<link href="/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="/css/nomapfrontend.css" rel="stylesheet" media="screen" type="text/css">
	<script type="text/javascript" src="/jscript/jquery.js"></script>
	<script type="text/javascript" src="/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript">
	<!--
		$(".modal").modal('hide');
		$("#langFlag").click(function() {
			$("#langSelector").modal('show');
		});
		$(".locationImage").click(function() {
			var url = $(this).attr("src").split("/");
			//alert(url.toSource());
			//return false
			$("#viewer").empty().append('<img src="/uploads/full/' + [ url[3], url[4]].join("/") + '">')
			$("#imgViewer").modal('show');
		});
	//-->
	</script>
	

</body>
</html>
