<span class="control-group form-inline">
	<div class="input-prepend typeControl">
		<span class="add-on">Тип объекта</span>
		<select name="type" id="type"><?=$typelist;?></select>
	</div>
</span>

<span id="cpanel1" class="panels controls form-inline hide">

	<!-- <div class="btn-group">
			<a href="#" id="setCenter" class="btn btn-info" title="Перемещает центр карты в точку с указанными координатами">Центровать карту</a>
			<a href="#" id="moveTo"    class="btn btn-info" title="Перемещает маркер в точку с указанными координатами">Переместить метку</a>
	</div> -->

	<label class="checkbox" title="Запрашивать и обновлять адрес объекта при перемещении его метки" for="traceAddress">
		<input type="checkbox" id="traceAddress">Отслеживать адрес
	</label>
</span>

<!--  -->

<span id="cpanel2" class="panels controls form-inline hide">
	Длина: <span class="f_len">0</span> м.&nbsp;&nbsp;Вершин: <span class="f_vtx">0</span>
</span>

<!--  -->

<span id="cpanel3" class="panels controls form-inline hide">
	<small>Длина периметра: <span class="f_len">0</span> м.</small>
	<small>Количество вершин: <span class="f_vtx">0</span></small>
</span>

<!--  -->

<span id="cpanel4" class="panels controls form-inline hide">
	<span class="input-prepend">
		<span class="add-on">Ш</span><input type="text" id="cir_lat" placeholder="широта центра" title="широта центра" class="circlecoord">
	</span>
	<span class="input-prepend">
		<span class="add-on">Д</span><input type="text" id="cir_lon" placeholder="долгота центра" title="долгота центра" class="circlecoord">
	</span>
	<span class="input-prepend input-append">
		<span class="add-on">радиус</span><input type="text" id="cir_radius" placeholder="радиус круга" title="радиус" class="circlecoord" value="100"><span class="add-on" title="Установка радиуса круга">м.</span>
	</span>
	<span class="btn btn-info btn-block" id="cir_setter">Установить</span>
	<small>Площадь: <span id="cir_field">0</span> м.<sup>2</sup></small>
	<small>Окружность: <span id="cir_len">0</span> м.</small>
</span>

<span id="cpanel5" class="panels controls form-inline hide" style="margin:3px;">
</span>

