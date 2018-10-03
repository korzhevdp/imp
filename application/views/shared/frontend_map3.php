<!DOCTYPE HTML>
<html>
<head>
	<title> Welcome screen </title>
	<meta name="Author" content="NorFolk">
	<meta name="Keywords" content="">
	<meta name="Description" content="Yet Another Web-GIS">
	<link href="<?=$this->config->item('api');?>/css/icons.css" rel="stylesheet">
</head>

<body>
	<style type="text/css">
		body{
			margin:0;
			padding:0;
			background-color:#aaa;
			font-family:Tahoma;
		}
		#YMapsID {
			width: 100%
			height: 500px;
			outline:1px solid gray;
		}
		#leftPanel{
			position:absolute;
			top:50px;
			vertical-align:top;
			padding-bottom: 10px;
			left:0px;
			width: 260px;
			height:50%;
			min-height:350px;
			border-radius: 0 0 5px 0;
			z-index:10000000;
			overflow:hidden
		}
		#bottomPanel{
			position:absolute;
			right:100px;
			bottom:30px;
			background-color:#fff;
			vertical-align:middle;
			min-width:560px;
			width:60%;
			padding:10px;
			border: 2px solid #ccc;
			border-radius:3px;
			z-index:10000000;
		}
		#bottomPanel input[type=text] {
			width:70%;
			border:none;
			background-color:#eee;
			height:38px;
			border-radius: 3px 0 0 3px ;
			font-size:32px;
			padding-left:10px;
			color: #977;
		}

		#globalSearch {
			display:block;
			clear:none;
			float:right;
			width:15%;
			border:none;
			background-color:#029688;
			height:40px;
			margin-right:10px;
			margin-top:0px;
			color:#ffffcc;
			font-size: 20px;
		}
		.panelToggler {
			border-radius: 0 5px 5px 0;
			background-color:#ededed;
			width:100%;
			height:40px;
			text-align:right;
			cursor:pointer;
			vertical-align:middle;
		}
		.panelToggler span {
			margin-top:15px;
			margin-right:15px;
		}
		.panelToggler:hover{
			background-color:#e6e6e6;
		}
		.panel {
			padding-bottom: 15px;
			position:relative;
			background-color:#fff;
			width:240px;
			border-radius: 0 0 5px 0;
		}
		::placeholder,
		::-ms-input-placeholder,
		:-ms-input-placeholder {
			color: #000;
			opacity: .3;
			font-size:inherit;
		}
		.panelToggler div {
			padding: 10px;
			padding-right: 20px;
			font-weight:bolder;
		}
		.panel .menuItem {
			border-bottom: 1px solid #ddd;
			padding: 15px;
			margin-left:24px;
			cursor:pointer;
			color: #888;
		}
		.panel .menuItem:hover{
			color: #000;
			background-color: #F6F6F6;
		}
		.panel .menuItem i {
			margin-right:10px;
			margin-top:4px;
		}
		#searchForm{
			position:absolute;
			right:100px;
			bottom:95px;
			background-color:#fff;
			font-size: 12px;
			overflow-y: auto;
			display:none;
			min-width: 560px;
			width: 60%;
			z-index:10000000;
			padding:10px;
			color: #555;
			border: 2px solid #ccc;
			border-radius:3px;
		}
		#searchFormToggler {
			float:right;
			clear: none;
			width: 6%;
			height: 40px;
			border-radius: 3px;
			background-color:#eee;
			cursor:pointer;
			text-align: center;
		}
		#searchFormToggler i {
			margin-top: 10px;
		}
		.objectGroup{
			height:80px;
		}
		.objectGroupHeader{
			height:18px;
			padding:4px;
			font-weight:bold;
			font-size: 14px;
		}
		.objectType{
			position:relative;
			float:left;
			cursor:pointer;
			margin:8px;
			border: 1px solid #eee;
			width:100px;
			height:24px;
			font-size: 14px;
			padding:2px;
			border-radius:3px;
			vertical-align: middle;
			text-align:center;
		}
		.objectType:hover{
			background-color:#eee;
			color: #000;
		}
		#balloon{
			font-size:13px;
			position:absolute;
			right:400px;
			top:200px;
			overflow-y: auto;
			min-width: 200px;
			width: 200px;
			min-height: 350px;
			height: 350px;
			background-color:#eee;
			border: 2px solid #ccc;
			border-radius:3px;
			z-index:9000000;
			padding:10px;
		}
		.balloon-header{
			font-weight:bold;
			color:#999;
			margin-bottom:5px;
		}
		.balloon-price{
			font-weight:bold;
			float:right;
			clear:none;
			color:#029688
		}
		.balloon-image {
			text-align:center;
			margin-top:5px;
			margin-bottom:5px;
		}
		.balloon-text {
			height:150px;
			margin-top:5px;
			border-top:1px solid #ddd;
			color:#999;
		}
		.balloon-text a {
			color:#029688;
		}
		#moreInfo {
			padding-top:4px;
			text-align:center;
			display:block;
			clear: none;
			width:100%;
			border:none;
			background-color:#029688;
			height:24px;
			color:#ffffcc;
			cursor:pointer;
		}
	</style>

	<div id="YMapsID">
		<div id="leftPanel">
			<div class="panelToggler">
				<div id="panelTogglerMarker"><i class="icon-chevron-left"></i></div>
			</div>
			<div class="panel">
				<div class="menuItem" title="Жильё"><i class="icon-home"></i><span class="labels">Жильё</span></div>
				<div class="menuItem" title="Бары"><i class="icon-glass"></i><span class="labels">Бары</span></div>
				<div class="menuItem" title="Отдых"><i class="icon-music"></i><span class="labels">Отдых</span></div>
				<div class="menuItem" title="Туризм"><i class="icon-map-marker"></i><span class="labels">Туризм</span></div>
				<div class="menuItem" title="Трансфер"><i class="icon-plane"></i><span class="labels">Трансфер</span></div>
			</div>
		</div>
	</div>

	<div id="searchForm">
		<div id="searchFor"></div>
		<div id="searchData">
			<div class="objectGroup" title="Индивидуальное предпринимательство">
				<div class="objectGroupHeader">Частный сектор</div>
				<div class="objectType" ref="1">Дом</div>
				<div class="objectType" ref="2">Коттедж</div>
				<div class="objectType" ref="3">Квартира</div>
				<div class="objectType" ref="4">Комната</div>
			</div>
			<div class="objectGroup" title="Индустриальные объекты">
				<div class="objectGroupHeader">Гостиницы</div>
				<div class="objectType" ref="5">Мини-отель</div>
				<div class="objectType" ref="6">Гостиница</div>
				<div class="objectType" ref="7">Пансионат</div>
				<div class="objectType" ref="8">Хостел</div>
			</div>
		</div>
	</div>

	<div id="bottomPanel">
		<input type="text" id="globalSearchText" placeholder="Найти по названию">
		<div id="searchFormToggler" title="Расширенная форма поиска">
			<i class="icon-chevron-up"></i>
		</div>
		<button id="globalSearch">ИСКАТЬ</button>
	</div>

	<div id="balloon">
		<div class="balloon-header">
			Гостевой дом<br>
			ВАСИЛИЙ
			<div class="balloon-price">
				от $300
			</div>
		</div>
		
		<div class="balloon-image">
			<img src="/images/ajax-loader.gif" width="128" height="128" border="0" alt="">
		</div>
		<div class="balloon-text">
			<b>ул. Ленина, д. 5</b><br>
			105 метров до моря<br>
			Мангал и джакузи во дворе<br>
			Номера на 1-5 человек<br>
			Летняя кухня<br>
			<a href="">Что рядом</a>
		</div>
		<div class="balloon-footer">
			<div id="moreInfo">Подробнее</div>
		</div>
	</div>

	<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/jquery.js"></script>
	<script type="text/javascript">


	


		var mp = {
				zoom   : <?=$this->config->item('map_zoom');?>,
				center : [<?=$this->config->item('map_center');?>],
				type   : <?=$this->config->item('map_type');?>,
				lang   : '<?=$this->session->userdata("lang");?>',
				mapset : <?=$mapset;?>,
				headers: ['<?=$headers;?>'],
				otype  : <?=$otype;?>

			},
			panelState  = 1,
			searchState = 0,
			<?=$switches?>
		
		$(".panelToggler").click(function() {
			$("#leftPanel").animate({
				opacity : (panelState) ? .8 : 1,
				left    : (panelState) ? "-=200" : "+=200" ,
			}, 500, function() {
				panelState = (panelState) ? 0 : 1;
				(panelState) 
					? $("#panelTogglerMarker i").removeClass("icon-chevron-right").addClass("icon-chevron-left")
					: $("#panelTogglerMarker i").removeClass("icon-chevron-left").addClass("icon-chevron-right")
					$(".labels").css('display', (panelState) ? 'inline' : 'none' );
					$(".panel .menuItem").css({
						'text-align' : ((panelState) ? 'left' : 'right'),
						'padding'    : ((panelState) ? '10px' : '10px 4px 10px 10px')
					});
			});
		});

		$("#searchFormToggler").click(function() {
			( !searchState ) 
				? $("#searchFormToggler i").removeClass("icon-chevron-up").addClass("icon-chevron-down")
				: $("#searchFormToggler i").removeClass("icon-chevron-down").addClass("icon-chevron-up")
			if (searchState) {
				$("#searchForm").fadeOut(500, function() {
					searchState = (searchState) ? 0 : 1;
				});
				return true;
			}
			$("#searchForm").fadeIn(500, function() {
				searchState = (searchState) ? 0 : 1;
			});
		});
	</script>


	<script src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&amp;load=package.full&amp;lang=<?=(($this->session->userdata("lang") === "ru") ? "ru-RU" :"en-US");?>" type="text/javascript"></script>
	<!-- <script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/mapsGen4.js"></script> -->
	<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/maps_frontend3.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/mapUI.js"></script>

</html>
