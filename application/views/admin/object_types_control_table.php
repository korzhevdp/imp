<style type="text/css">
	.modal input,
	.modal select {
		margin-bottom: 0;
	}
	.modal input[type=checkbox] {
		margin-bottom: 2px;
	}
	#attributes option {
		background-repeat:no-repeat;
		background-size: 24px auto;
		text-indent:22px;
	}
</style>
<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/styles2.js"></script>
<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/yandex_styles.js"></script>
<h4>Справочник типов объектов&nbsp;&nbsp;&nbsp;&nbsp;<small> и их свойства</small></h4>


<table class="table table-bordered table-condensed table-hover">
		<tr>
			<th>#</th>
			<th>Название</th>
			<th>Стиль</th>
			<th>Группа объектов</th>
			<th>Действие</th>
		</tr>
		<tbody id="listOfTypes"></tbody>
</table>

<div class="modal hide fade" id="modalTypes">
	<div class="modal-header" >
		<button type="button" class="close" data-dismiss="modal"><i class="icon-remove"></i></button>
		<h4 id="typeName">Cвойства типов объектов</h4>
	</div>
	<div class="modal-body" id="modal_props_body">
		<table class="table table-condensed">
		<tr>
			<td>Название</td>
			<td style="width:30px;"></td>
			<td><input type="text" id="name" value=""></td>
		</tr>
		<tr>
			<td><label for="haschild">Имеет подчинённые объекты</label></td>
			<td style="width:30px;"></td>
			<td><input type="checkbox" id="haschild" value="1"></td>
		</tr>
		<tr>
			<td>Оформление:</td>
			<td style="width:26px;height:26px;" id="imagery"></td>
			<td><select id="attributes"></select></td>
		</tr>
		<tr>
			<td>Группа объектов:</td>
			<td style="width:30px;"></td>
			<td>
				<select id="objectGroup">
				<?=(isset($obj_group)) ? $obj_group : ""; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Индекс свойства</td>
			<td style="width:30px;"></td>
			<td><input type="text" id="pl_num" value="" readonly="readonly"></td>
		</tr>
		<tr>
			<td>Тип представления</td>
			<td style="width:30px;"></td>
			<td>
				<select id="pr_type">
					<option value="1">точка</option>
					<option value="2">линия</option>
					<option value="3">полигон</option>
					<option value="4">круг</option>
					<option value="5">прямоугольник</option>
				</select>
			</td>
		</tr>
		</table>
		<input type="hidden" id="propertyID">
		<span id="propertyAnnounce"><span>
	</div>
	<div class="modal-footer" style="text-align:right;padding-right:15px;">
		<span class="btn btn-small btn-warning" id="createProps">Создать новый тип</span>
		<span class="btn btn-small btn-primary" id="applyProps">Сохранить описание</span>
	</div>
</div>

<script type="text/javascript">
<!--
	var attributes = '<?=$attributes;?>',
		pr_type    = <?=$pr_type;?>,
		jsData,
		a;
	$("#attributes").prepend('<option value="">Выберите тип</option>');
	for (a in userstyles) {
		if (userstyles.hasOwnProperty(a)) {
			if (a.split("#")[0] !== 'paid') {
				
				//icon = (userstyles[a].iconUrl !== undefined) 
				//	? 'style="background-image:url(' + userstyles[a].iconUrl + ');"'
				//	: '';
				
				string   = '<option value="' + a + '">' + userstyles[a].title + '</option>\n';
				
				$("#attributes").append(string);
			}
		}
	}

	if (pr_type !== undefined && pr_type == 1) {
		$("#attributes").append(yandex_styles.join("\n"));
		$("#attributes").append(yandex_markers.join("\n"));
	}
	$("#attributes option[value=\"" + attributes + "\"]").prop('selected', true);

	function getListOfTypes() {
		$.ajax({
			url: "/admin/showGis",
			type: "GET",
			dataType: "script",
			success: function () {
				$("#listOfTypes").empty();
				$("#imagery").empty();
				for (a in data) {
					prType = $("#objectGroup option[value='" + data[a].og + "']").html(); //адово извращение
					string = '<tr><td>' + a + '</td><td>' + data[a].img + '&nbsp;&nbsp;' + data[a].name + '</td><td>' + data[a].attr + '</td><td>' + prType + '</td><td><span class="btn btn-mini btn-primary callEditor" ref="' + a + '">Редактировать</span></td></tr>';
					$("#listOfTypes").append(string);
				}
				$(".callEditor").unbind().click(function() {
					$('#modalTypes').modal('show');
					id = $(this).attr('ref');

					enumerateUserStyles(id);
					fillFormFields(data[id], id);
					setImagery(pr_type, data[id].attr);

					$("#attributes").unbind().change(function() {
						var style = $(this).val();
						setImagery(pr_type, style);
					});
					
					$("#createProps, #applyProps").unbind().click(function() {
						$.ajax({
							url: "/admin/gisSave",
							type: "POST",
							data: {
								name       : $("#name").val(),
								has_child  : $("#haschild").prop('checked'),
								attributes : $("#attributes").val(),
								obj_group  : $("#objectGroup").val(),
								pl_num     : data[id].pl_num,
								pr_type    : $("#pr_type").val(),
								obj        : ($(this).attr("id") === "applyProps") ? $("#propertyID").val() : false
							},
							dataType: "text",
							success: function (data) {
								$('#modalTypes').modal('hide');
								getListOfTypes();
							},
							error: function (data, stat, err) {
								console.log([data, stat, err].join("<br>"));
							}
						});
					});
				});
			},
			error: function (data, stat, err) {
				console.log([data, stat, err].join("<br>"));
			}
		});
	}

	getListOfTypes();

	function fillFormFields(data, id) {
		$("#typeName").html(data.name);
		$("#haschild").prop('checked', data.haschild);
		$("#name").val(data.name);
		$("#propertyID").val(id);
		$("#pl_num").val(data.pl_num);
		$("#attributes option[value='"  + data.attr    + "']").prop('selected', true);
		$("#objectGroup option[value='" + data.og      + "']").prop('selected', true);
		$("#pr_type option[value='"     + data.pr_type + "']").prop('selected', true);
	}

	function convertRGBAValue(RGBA) {
		//alert(RGBA)
		var RGB = "#" + RGBA.substr(0, 6),
			opacity = parseInt(RGBA.substr(-2), 16) / 256;
		return [RGB, opacity];
		//alert (RGB + " ++ " + opacity);
	}

	function setImagery(type, style) {
		if ( data[id].pr_type === 1 ) {
			if (userstyles[style] !== undefined ) {
				$("#imagery").empty().css({ "outline" : 'none' }).html('<img src="' + userstyles[style].iconUrl + '">');
			}
		}
		if ( data[id].pr_type === 2 ) {
			if (userstyles[style] !== undefined ) {
				colors = convertRGBAValue(userstyles[style].strokeColor);
				$("#imagery").empty().html('&nbsp;').css({
					"outline" : colors[0] + " " + userstyles[style].weight + "px solid",
					"opacity" : colors[1]
				});
			}
		}
		if ( data[id].pr_type === 3 ) {
			if (userstyles[style] !== undefined ){
				colors = convertRGBAValue(userstyles[style].strokeColor);
				fillcolors = convertRGBAValue(userstyles[style].fillColor);
				$("#imagery").empty().html('&nbsp;').css({
					"outline"          : colors[0] + " " + userstyles[style].weight + "px solid",
					"opacity"          : colors[1],
					"background-color" : fillcolors[0]
				});
			}
		}
	}

	function enumerateUserStyles(id) {
		var b;
		$("#attributes").empty().append('<option value="">Выберите тип</option>');
		for (b in userstyles) {
			if (userstyles.hasOwnProperty(b)) {
				if (b.split("#")[0] !== 'paid' && userstyles[b].type === data[id].pr_type) {
					
					icon = (userstyles[b].iconUrl !== undefined) 
						? 'style="background-image:url(' + userstyles[b].iconUrl + ');"'
						: '';
					$("#attributes").append('<option ' + icon + ' value="' + b + '">' + userstyles[b].title + '</option>\n');
				}
			}
		}
	}

	$("#name").keyup(function() {
		$("#typeName").html( $(this).val() );
	});

	$(".modal").modal({ show : false });


//-->
</script>
