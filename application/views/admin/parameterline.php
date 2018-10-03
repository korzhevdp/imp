<tr <?=$infoclass;?> ref="<?=$id;?>">
	<td><input type="checkbox" class="<?=$checkref;?>" id="ch<?=$id;?>" ref="<?=$id;?>" readonly="readonly"></td>
	<td><?=$property_group;?></td>
	<td><?=$label;?>&nbsp;&nbsp;&nbsp;&nbsp;<small>[<?=implode(array($page, $row, $element), ", ");?>]</small></td>
	<td class="selfname" ref="<?=$id;?>"><?=$selfname;?></td>
	<td><?=$cat;?></td>
	<td><?=$algoritm;?></td>
	<td>
		<? if ($object_group) { ?>
		<span objectGroup="<?=$object_group;?>" typeID="<?=$type_id;?>" oid="<?=$id;?>" class="btn btn-mini search" title="Статус для поиска">
			<i class="<?=($active) ? "icon-search" : "icon-ban-circle";?>"></i>
		</span>
		<? } ?>
	</td>
	<td>
		<span objectGroup="<?=$object_group;?>" typeID="<?=$type_id;?>" oid="<?=$id;?>" class="btn btn-mini onoff" title="Статус для назначения">
			<i class="<?=$pic2;?>"></i>
		</span>
	</td>
	<td>
		<a href="/admin/library/<?=$object_group;?>/<?=$type_id;?>/<?=$id;?>/2" class="btn btn-primary btn-mini">Редактировать</a>
	</td>
</tr>