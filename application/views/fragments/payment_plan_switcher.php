<table id="section6_3" style="margin-top:20px;">
	<tr style="height: 20px;">
		<td class="adm_cell_1st"><label for="payment_plan">������� ������� ��� ����������� �����</label></td>
		<td class="adm_cell_2nd" style="vertical-align:middle;">
			<SELECT NAME="payment_plan" ID="payment_plan" onchange="show_payment_plan(this.value);" CLASS="doublewidth" title="�������� ����� ���. ��� ����� ����������� ��� ���� ���������� ����������">
				<OPTION VALUE=0 SELECTED>-- �������� ����� ��� --</OPTION>
				<OPTION VALUE=1>�� �������</OPTION>
				<OPTION VALUE=2>�� 2 ������</OPTION>
				<OPTION VALUE=3>��������</OPTION>
				<!-- <OPTION VALUE=4>�����������</OPTION> -->
			</SELECT>
		</td>
	</tr>
	<?if($has_child) :?>
	<tr style="height: 20px;">
		<td class="adm_cell_1st"><label for="frm_pp_traverse">��������� ��� ���� �������/������</label></td>
		<td class="adm_cell_2nd" style="vertical-align:middle;">
			<input type="checkbox" class="checkbox" name="frm_pp_traverse" id="frm_pp_traverse" style="vertical-align: middle;">&nbsp;&nbsp;��������� ������� ��� � ������������ � ������������ �����
		</td>
	</tr>
	<? endif ?>
</table>
