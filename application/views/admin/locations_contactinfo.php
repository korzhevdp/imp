<label for="frm_name" class="span3">��� �������</label>
	<?=$location_type;?>
<label for="style_override" class="span3" style="margin-top:3px;margin-bottom:-3px;">���������� ���</label>
	<select name="frm_style_override" id="style_override" class="span9">
		<option value="">����������� ����������� ����</option>
	</select>
<label for="frm_name" class="span3" style="margin-top:3px;margin-bottom:-3px;">��������</label>
	<input type="text" class="span9" id="frm_name" name="frm_name" value="<?=htmlspecialchars_decode ($name_text);?>">
<label for="frm_address" class="span3" style="margin-top:3px;margin-bottom:-3px;">�����:</label>
	<input type="text" class="span9" id="frm_address" name="frm_address" value="<?=htmlspecialchars_decode ($address_text);?>">
<label for="frm_contact_info" class="span3" style="margin-top:3px;margin-bottom:-3px;">���������� ����������:</label>
	<input type="text" class="span9" id="frm_contact_info" name="frm_contact_info" value="<?=htmlspecialchars_decode ($locations_contact_info_text);?>">
<label for="frm_location_active" title="������� ��������� ��� ������ � ��������� ������������ �����" class="span3" style="margin-top:3px;margin-bottom:-3px;">������������</label>
	<input type="checkbox" name="frm_location_active" id="frm_location_active" <?=($active)? 'checked' : '';?> value="on" class="span9">
<label for="frm_location_comments" class="span3" style="margin-top:3px;margin-bottom:-3px;">�������� �����������</label>
	<input type="checkbox" name="frm_location_comments" id="frm_location_comments" <?=($comments)? 'checked' : '';?> value="on" class="span9">
<input type="hidden" id="pr_type" value="<?=$pr_type;?>">
<input type="hidden" id="c_style_override" value="<?=$style_override;?>">
