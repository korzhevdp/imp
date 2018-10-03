<!doctype html>
<html lang="ru">
<head>
	<title>Административная консоль - редактор объектов</title>
	<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/jquery.js"></script>
	<link href="<?=$this->config->item('api');?>/css/editor.css" rel="stylesheet">
	<link href="<?=$this->config->item('api');?>/bootstrap/css/bootstrap.css" rel="stylesheet">
</head>

<body class="altEditor">

<table class="editorTable">
<tr>
	<td class="leftColumn">
		<a href="/admin/library/<?=$liblink?>" id="lib-btn" class="btn btn-primary btn-block">В библиотеку</a>
	</td>
	<td class="rightColumn">
		<h4 class="altEditorHeader">
			<span id="header_location_name"><?=$location_name;?></span>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<small id="description"><?=$description;?></small>
		</h4>
		<ul class="nav nav-tabs">
			<?=$pagelist_alt;?>
			<? if ($hasSchedule) { ?>
			<li class="schedule"><a href="#schedule" data-toggle="tab">Расписание</a></li>
			<? } ?>
			<? if ($has_child) { ?>
			<li class="subObjects"><a href="#subObjects" data-toggle="tab">Состав</a></li>
			<? } ?>
		</ul>
	</td>
</tr>
<tr>
	<td class="leftColumn">
		<div class="input-prepend">
			<span class="add-on">Название</span><input type="text" form="tForm" id="l_name" name="object[name]" value="<?=$location_name;?>">
		</div>
		<div class="input-prepend">
			<span class="add-on">Адрес</span><input type="text" form="tForm" id="l_addr" class="l_addr" name="object[addr]" value="<?=$address;?>">
		</div>
		<div class="input-prepend">
			<span class="add-on">Стиль</span><select form="tForm" id="l_attr" name="object[attr]" class="styles"></select>
		</div>
		<div class="input-prepend">
			<span class="add-on">Телефон</span><input type="text" form="tForm" id="l_cont" name="object[contact]" value="<?=$contact_info;?>">
		</div>
		<i class=" icon-map-marker"></i>
		<span id="m_lat_d"></span>&nbsp;<span id="m_lon_d"></span>
		<input type="hidden" id="m_lat">
		<input type="hidden" id="m_lon">

		<table class="table">
			<tr>
				<td id="dropZone" title="<?=($this->session->userdata("lang") === "ru") 
				? "Перетащите изображения сюда"
				: "Drag and drop your images here";?>">
					<txt></txt>
					<input type="hidden" name="lid" value="<?=$lid?>" id="uploadLID">
					<ul class="imageGallery">
						<?=$images;?>
					</ul>
				</td>
			</tr>
			<tr>
				<td id="DnDStatus"></td>
			</tr>
		</table>
		<?=$panel;?>

		<label class="checkbox" title="Объект доступен для поиска" for="l_act">
			<input type="checkbox" class="l_act" id="l_act">Опубликовано
		</label>
		<label class="checkbox" title="Включить возможность комментирования" for="l_comm">
			<input type="checkbox" class="l_comm" id="l_comm">Комментарии
		</label>
		<hr>
		<button type="button" class="btn btn-primary btn-block" id="saveBtn" title="Сохранить данные объекта">Сохранить</button>

		
	</td>
	<td class="rightColumn tab-content">
		<div class="tab-pane active"   id="YMapsID">
				<span class="btn-group pull-right">
					<span class="btn btn-info btn-mini" id="pointsLoad" title="Загрузить опорные точки из имеющихся в библиотеке объектов">Опорные точки</span>
					<span class="btn btn-info btn-mini dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
					</span>
				<ul class="dropdown-menu">
					<li><a href="#" id="pointsClear">Очистить опорные точки</a></li>
				</ul>
			</span>
			<span class="btn-group pull-right" data-toggle="buttons-radio" style="margin-right:25px;">
				<span class="btn btn-info btn-mini mapsw" id="toYandex">Yandex</span>
				<span class="btn btn-info btn-mini mapsw" id="toGoogle">Google</span>
			</span>
		</div>
		<div class="tab-pane propPage" id="propPage"></div>
		<div class="tab-pane"          id="schedule"><?=$schedule;?></div>
		<div class="tab-pane"          id="subObjects"></div>
	</td>
</tr>
</table>
<?=$content;?>

<div id="loadPoints" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Выберите типы объектов для создания опорных точек</h3>
	</div>
	<div class="modal-body">
		<table class="table table-bordered table-condensed table-hover">
		<tr>
			<th style="width:15px;"><input type="checkbox" id="checkAll"></th>
			<th>Типы объектов</th>
			<th style="width:135px;">Тип</th>
			<th style="width:25px;"><i class="icon-info-sign"></i></th>
			<th style="width:25px;"><i class="icon-list"></i></th>
		</tr>
		<?=(isset($baspointstypes)) ? $baspointstypes : "";?>
		</table>
	</div>
	<div class="modal-footer">
		<a href="#" data-dismiss="modal" class="btn">Закрыть</a>
		<a href="#" id="loadSelectedObjects" class="btn btn-primary">Загрузить точки</a>
	</div>
</div>

<div id="nodeExport" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Координаты вершин геометрии</h3>
	</div>
	<div class="modal-body" id="exportedNodes"></div>
	<div class="modal-footer">
		<a href="#" data-dismiss="modal" class="btn">Закрыть</a>
		<a href="#" id="loadSelectedObjects" class="btn btn-primary">Загрузить точки</a>
	</div>
</div>


<script src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&amp;load=package.full&amp;lang=<?=(($this->session->userdata("lang") === "ru") ? "ru-RU" :"en-US");?>" type="text/javascript"></script>
<script type="text/javascript" src="<?=$this->config->item('api');?>/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="<?=$this->config->item('api');?>/jqueryui/js/jqueryui.js"></script>

<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/styles2.js"></script>
<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/yandex_styles.js"></script>
<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/objecteditor/maps2.js"></script>
<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/objecteditor/editorui.js"></script>
<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/objecteditor/dragndrop.js"></script>
<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/objecteditor/schedule.js"></script>
<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/objecteditor/nodal.js"></script>
</body>
</html>