<h4>Семантика объектов&nbsp;&nbsp;&nbsp;&nbsp;<small>группа: <b><?=$og_name;?></b> - cвойство: <b><?=$selfname;?></b></small></h4>
<div class="semanticsManager">
	<form method=post id="ogp_edit_form" action="/admin/save_semantics">
		<ul class="nav nav-tabs" style="clear:both;">
			<li class="active"><a href="#tabs1" data-toggle="tab">Свойство</a></li>
			<li><a href="#tabs2" data-toggle="tab">Положение в форме</a></li>
			<li><a href="#tabs3" data-toggle="tab">Участие в группах</a></li>
		</ul>
		<div class="tab-content" style="clear:both;">
			<div id="tabs1" class="tab-pane active">

				<div>
				<div class="input-prepend">
					<label class="add-on" for="ogp4">Метка:</label>
					<input type="text" id="ogp4" form="ogp_edit_form" name="label" value="<?=$label;?>">
				</div>
				</div>

				<div>
				<div class="input-prepend">
					<label class="add-on" for="ogp5">Имя:</label>
					<input type="text" id="ogp5" form="ogp_edit_form" name="selfname" value="<?=$selfname;?>">
				</div>
				</div>

				<div>
				<div class="input-prepend">
					<label class="add-on" for="ogp6">Алгоритм поиска:</label>
					<select form="ogp_edit_form" name="algoritm" id="ogp6">
						<option title="Алгоритм объединительного поиска. По нему вновь найденный объект будет добавляться в коллекцию. Типовое применение поиск значения взятого из набора полей checkbox" value="u" <? if ($algoritm === "u" ) {?> selected="selected"<? } ?>>Соответствует одному из признаков</option>
						<option title="Алгоритм исключающего отбора. Собранная коллекция объектов будет проверяться на наличие у объекта в наборе указанного признака. Удобно для отсеивания по территориальному признаку. Типовое применение поиск значения взятого из поля select" value="ud"<? if ($algoritm === "ud") {?> selected="selected"<? } ?>>Соответствует всем признакам</option>
						<option title="Алгоритм изучается" value="d"<?  if ($algoritm === "d" ) {?> selected="selected"<? } ?>>d - алгоритм</option>
						<option title="Алгоритм &quot;больше или равно&quot;. Значение свойства объекта будет сравниваться с заданным в нём параметром в соответствии с весовыми коэффициентами" value="me"<? if ($algoritm === "me") {?> selected="selected"<? } ?>>Больше или равно</option>
						<option title="Алгоритм &quot;меньше или равно&quot;. Значение свойства объекта будет сравниваться с заданным в нём параметром в соответствии с весовыми коэффициентами" value="le"<? if ($algoritm === "le") {?> selected="selected"<? } ?>>Меньше или равно</option>
						<option title="Алгоритм &quot;цена&quot;. Значение рассчитывается на текущий момент из справочника ценовых периодов. На данный момент не рекомендовано к использованию." value="pr"<? if ($algoritm === "pr") {?> selected="selected"<? } ?>>Цена на дату запроса</option>
					</select>
				</div>
				</div>

				<div id="additionalFields" class="hide">
				<div class="input-prepend input-append">
					<label class="add-on" for="ogp6-1">Множитель</label>
					<input type="text" class="short" id="ogp6-1" form="ogp_edit_form" name="multiplier" value="<?=$multiplier;?>">
					<label class="add-on" for="ogp6-2">Делитель</label>
					<input type="text" class="short" id="ogp6-2" form="ogp_edit_form" name="divider" value="<?=$divider;?>">
				</div>
				</div>

				<div>
				<div class="input-prepend">
					<label class="add-on" for="ogp7">Группа свойств:</label>
					<input type="text" list="ogp7list" form="ogp_edit_form" value="<?=$property_group_name;?>" name="property_group" id="ogp7">
					<datalist id="ogp7list">
						<?=$property_group;?>
					</datalist>
				</div>
				</div>

				<div>
				<div class="input-prepend">
					<label class="add-on" for="ogp9">Категория:</label>
					<input type="text" form="ogp_edit_form" name="cat" value="<?=$cat_name;?>" list="ogp9list" id="ogp9">
					<datalist id="ogp9list">
						<?=$cat;?>
					</datalist>
				</div>
				</div>

				<div>
				<div class="input-prepend">
					<label class="add-on" for="ogp14">Привязка:</label>
					<select form="ogp_edit_form" name="linked" id="ogp14">
						<?=$linked;?>
					</select>
				</div>
				</div>

			</div>
			<div id="tabs2" class="tab-pane">

				<div>
				<div class="input-prepend">
					<label class="add-on" for="ogp1">Страница:</label>
					<input type="text" id="ogp1" form="ogp_edit_form" name="page" value="<?=$page;?>">
				</div>
				</div>

				<div>
				<div class="input-prepend">
					<label class="add-on" for="ogp2">Строка:</label>
					<input type="text" id="ogp2" form="ogp_edit_form" name="row" value="<?=$row;?>">
				</div>
				</div>

				<div>
				<div class="input-prepend">
					<label class="add-on" for="ogp3">Порядок в строке:</label>
					<input type="text" id="ogp3" form="ogp_edit_form" name="element" value="<?=$element;?>">
				</div>
				</div>

				<div>
				<div class="input-prepend">
					<label class="add-on" for="ogp8">Тип поля:</label>
					<select form="ogp_edit_form" name="fieldtype" id="ogp8">
						<option value="select"   <? if ($fieldtype === "select" )   {?> selected="selected"<? } ?>>Выпадающий список</option>
						<option value="checkbox" <? if ($fieldtype === "checkbox" ) {?> selected="selected"<? } ?>>Флажок</option>
						<option value="text"     <? if ($fieldtype === "text" )     {?> selected="selected"<? } ?>>Текст</option>
						<option value="textarea" <? if ($fieldtype === "textarea" ) {?> selected="selected"<? } ?>>Текстовое поле</option>
					</select>
				</div>
				</div>

				<div>
				<div class="input-prepend">
					<label class="add-on" for="ogp11">Параметры:</label>
					<input type="text" id="ogp11" form="ogp_edit_form" name="parameters" value="<?=$parameters;?>">
				</div>
				</div>

			</div>
			<div id="tabs3" class="tab-pane">
				<?=$groups;?>
			</div>

		</div>
		<div class="semanticControls">
			<input  type="hidden" form="ogp_edit_form" name="property" value="<?=$property;?>">
			<input  type="hidden" form="ogp_edit_form" name="object_group" value="<?=$object_group;?>">
			<button type="submit" form="ogp_edit_form" name="mode" class="btn" value="new" style="margin-top:10px;">Создать новый элемент</button>
			<button type="submit" form="ogp_edit_form" name="mode" class="btn btn-primary" value="save" style="margin-left:147px;margin-top:10px;">Сохранить элемент</button>
			<span class="btn btn-warning assigner">Назначить свойство в группы <i class="icon-arrow-down icon-white" title="Назначить свойство семантики в группы"></i></span>
		</div>
	</form>
</div>

<hr>
<div class="semanticsManager">
	<h4>Параметры семантики&nbsp;&nbsp;&nbsp;&nbsp;<small>Для описания и поиска</small></h4>
	<table class="table table-bordered table-condensed table-hover">
		<tr>
			<th><i class="icon-check"></i></th>
			<th>Категория&nbsp;<i class="setProperty icon-arrow-down" ref="groups" title="Присвоить значение для этого поля во всех выбранных элементах"></i></th>
			<th>Метка&nbsp;<i class="setProperty icon-arrow-down" ref="labels" title="Присвоить значение для этого поля во всех выбранных элементах"></i></th>
			<th>Название</th>
			<th>Подкатегория&nbsp;<i class="setProperty icon-arrow-down" ref="subcats" title="Присвоить значение для этого поля во всех выбранных элементах"></i></th>
			<th>Алгоритм&nbsp;<i class="icon-question-sign"></i></th>


			<th><i class="icon-search"></i><i class="setProperty icon-arrow-down " title="Доступность для поиска"></i></th>
			<th><i class="icon-off"></i><i class="setProperty icon-arrow-down " ref="onoff" title="Включить / Выключить"></i></th>
			<th>Действие</th>
		</tr>
		<tbody id="listOfProperties">
			<?//=$list;?>
		</tbody>
		
	</table>
</div>

<div class="modal hide fade" id="modal_props">
	<div class="modal-header" >
		<button type="button" class="close" data-dismiss="modal"><i class="icon-remove"></i></button>
		<h4>Групповое обновление свойств</h4>
	</div>
	<div class="modal-body" id="modal_props_body">
		<table class="table table-condensed">
		<tr>
			<td>Новое значение</td>
			<td><input type="text" id="newPropertyVal"></td>
		</tr>
		<tr>
			<td>Выберите значение</td>
			<td><select id="propertyVal"></select></td>
		</tr>
		</table>
		<span id="propertyAnnounce"><span>
	</div>
	<div class="modal-footer" style="text-align:right;padding-right:15px;">
		<span class="btn btn-small" data-dismiss="modal">Отмена</span>
		<span class="btn btn-small btn-primary" id="applyProps">Применить</span>
	</div>
</div>

<div class="modal hide fade" id="modal_props2">
	<div class="modal-header" >
		<button type="button" class="close" data-dismiss="modal"><i class="icon-remove"></i></button>
		<h4>Поиск / Активность</h4>
	</div>
	<div class="modal-body" id="modal_props_body2">
		<span id="propertyAnnounce2"></span>
	</div>
	<div class="modal-footer" style="text-align:right;padding-right:15px;">
		<span class="btn btn-small" data-dismiss="modal">Отмена</span>
		<span class="btn btn-warning switchers" id="turnOn">Включить всё</span>
		<span class="btn btn-warning switchers" id="turnOff">Отключить всё</span>
	</div>
</div>

<div class="modal hide fade" id="modal_props3">
	<div class="modal-header" >
		<button type="button" class="close" data-dismiss="modal"><i class="icon-remove"></i></button>
		<h4>Ассоциировать свойства с группами объектов</h4>
	</div>
	<div class="modal-body" id="modal_props_body3">
		Выбраны свойства: <span id="propList2GB"></span>
		<?=$groups;?>
	</div>
	<div class="modal-footer" style="text-align:right;padding-right:15px;">
		<span class="btn btn-small" data-dismiss="modal">Отмена</span>
		<span class="btn btn-warning switchers" id="assign">Назначить</span>

	</div>
</div>

<script type="text/javascript">
<!--
	var list = [];

	function setProps(mode){
		var names = [];
		list      = [];
		$('#modal_props2').modal('show');

		$(".mainProp:checked, .extProp:checked").each(function(){
			names.push($(".selfname[ref=" + $(this).attr("ref") + "]").html());
			list.push($(this).attr("ref"));
		});
		$("#propertyAnnounce2").html('Вы выбрали ' + names.length + ' свойств:<br>' + names.join(',<br>') + '.<br>Что вы намерены с ними сделать?');
		$(".switchers").unbind().click(function(){
			$.ajax({
				url       : "/admin/savePropertyFields",
				data      : {
					mode  : mode,
					og    : <?=$object_group;?>,
					value : ($(this).attr('id') === "turnOn") ? 1 : 0,
					ids   : list
				},
				type      : "POST",
				dataType  : "html",
				success   : function (data) {
					$('#modal_props2').modal('hide');
					getListOfProperties();
				},
				error: function (data, stat, err) {
					console.log([data, stat, err].join("<br>"));
				}
			});
		})
	}

	function getListOfProperties() {
		$.ajax({
			url          : "/admin/show_semantics",
			data         : {
				objGroup : <?=$object_group;?>,
				obj      : <?=$property;?>

			},
			type         : "POST",
			dataType     : "html",
			success      : function (data) {
				$("#listOfProperties").empty().append(data);
				$(".activeRow").unbind().click(function() {
					$("#ch" + $(this).attr('ref')).prop("checked", !$("#ch" + $(this).attr('ref')).prop("checked"));
					if ( $("#ch" + $(this).attr('ref')).prop("checked")) {
						$(this).addClass("info");
						return true;
					}
					$(this).removeClass("info");
					return true;
				});
			},
			error        : function (data, stat, err) {
				console.log([data, stat, err].join("<br>"));
			}
		});
	}

	$("#ogp6").change(function(){
		if ($(this).val() === 'le' || $(this).val() === 'me') {
			$("#additionalFields").removeClass("hide");
		} else {
			$("#additionalFields").addClass("hide");
		}
	});

	$(".setProperty").click(function(){
		var mode = $(this).attr('ref');
		if (mode === 'search' || mode === 'onoff') {
			setProps(mode);
			return true;
		}
		$.ajax({
			url      : "/admin/aggregatePropertyFields",
			data     : {
				mode : mode
			},
			type     : "POST",
			dataType : "html",
			success  : function (data) {
				trycount = 0;
				$("#applyProps").removeClass("btn-warning").addClass("btn-primary").html("Применить");
				$("#newPropertyVal").val("");
				$("#propertyAnnounce").empty();
				$("#propertyVal").empty().append(data);
				$("#propertyVal").change(function(){
					if ( $(this).val() !== "0" ) {
						$("#newPropertyVal").prop('disabled', true);
						return true;
					}
					$("#newPropertyVal").prop('disabled', false);
				});
				$('#modal_props').modal('show');
				$("#applyProps").unbind().click(function(){
					var propValue = ($("#newPropertyVal").attr('disabled')) ? $("#propertyVal").val() : $("#newPropertyVal").val(),
						list  = [],
						names = [],
						modes = {
							labels  : '"Метка"',
							groups  : '"Категория"',
							subcats : '"Субкатегория"'
						},
						checks = $(".mainProp:checked, .extProp:checked");
					if (!checks.length) {
						$("#propertyAnnounce").empty().html('Выберите свойства для заполнения');
						return false;
					}
					$(checks).each(function(){
						names.push($(".selfname[ref=" + $(this).attr("ref") + "]").html());
						list.push($(this).attr("ref"));
					});
					$("#propertyAnnounce").html('Вы действительно хотите заменить значение поля ' + modes[mode] + ' на "' + propValue + '" у ' + names.length + ' свойств:<br>' + names.join(', ') + '?');
					if (trycount == 1) {
						$.ajax({
							url       : "/admin/savePropertyFields",
							data      : {
								mode  : mode,
								value : propValue,
								ids   : list
							},
							type      : "POST",
							dataType  : "html",
							success   : function (data) {
								$('#modal_props').modal('hide');
								getListOfProperties();
							},
							error: function (data, stat, err) {
								console.log([data, stat, err].join("<br>"));
							}
						});
					}
					$("#applyProps").removeClass("btn-primary").addClass("btn-warning").html("Да, применить!");
					trycount = 1;
				});

			},
			error    : function (data, stat, err) {
				console.log([data, stat, err].join("<br>"));
			}
		});
	});

	$(".assigner").click(function(){
		var names = [];
		list = [];
		$(".mainProp:checked, .extProp:checked").each(function() {
			names.push($(".selfname[ref=" + $(this).attr("ref") + "]").html());
			list.push($(this).attr("ref"));
		});
		$("#propList2GB").html(names.join(', ') + ' ');
		$('#modal_props3').modal('show');
	});

	$("#assign").click(function(){
		//alert(1)
		var groups = [];
		$("#modal_props_body3 input[type=checkbox]:checked").each(function(){
			groups.push($(this).val())
		});

		$.ajax({
			url        : "/admin/addPropertiesToGroups",
			data       : {
				groups : groups,
				list   : list
			},
			type       : "POST",
			dataType   : "html",
			success    : function () {
				$('#modal_props3').modal('hide');
				getListOfProperties();
			},
			error      : function (data, stat, err) {
				console.log([data, stat, err].join("<br>"));
			}
		});
	});

	$(".modal").modal({ show : false });

	getListOfProperties();
//-->
</script>