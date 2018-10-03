<tr>
	<td>
		<?=$id;?>
	</td> 
	<td>
		<img src="<?=$this->config->item('api');?>/images/<?=$pic;?>" title="<?=$pictitle;?>" style="width:16px;height:16px;border:none;" alt="<?=$pictitle;?>">&nbsp;&nbsp;<?=$name;?>
	</td> 
	<td title="Стиль оформления метки"><?=$attributes;?></td>
	<td title="Группа объектов"><?=$object_group_name;?></td>
	<td>
		<span class="btn btn-primary btn-mini callEditor" style="margin:2px;" ref="<?=$id;?>">Редактировать</span>
	</td>
</tr>