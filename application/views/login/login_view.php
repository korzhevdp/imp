<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
	<TITLE> ���������������� ������� ����� </TITLE>
	<META NAME="Generator" CONTENT="EditPlus">
	<META NAME="Author" CONTENT="">
	<META NAME="Keywords" CONTENT="">
	<META NAME="Description" CONTENT="">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<SCRIPT type="text/javascript" SRC="/jscript/mechanization.js"></SCRIPT>
	<SCRIPT type="text/javascript" SRC="/jscript/jquery.js"></SCRIPT>
	<SCRIPT type="text/javascript" SRC="/jscript/jquery-ui.js"></SCRIPT>
	<SCRIPT type="text/javascript" SRC="/jscript/jquery.ui.datepicker-ru.js"></SCRIPT>
	<link rel="stylesheet" type="text/css" href="/css/backstyle.css">
	<link rel="stylesheet" type="text/css" href="/css/loginstyle.css">

</HEAD>
<BODY>
<TABLE style="height:70px;width:100%;border-spacing:0px;">
<TR style="background-color:#FFFFFF; height:40px;">
	<TD style="border:0px;"></TD>
	<TD style="width:200px;vertical-align:middle;text-align:left;border:0px;">
&nbsp;
	</TD>
</TR>
<TR style="background-color: #00CC00;height:30px;">
	<TD colspan=2>&nbsp;</TD>
	</TR>
</TABLE>

<table style="width:100%;">
<tr>
	<td style="width:10%;height:400px;vertical-align:top;">&nbsp;</td>
	<td style="border:1px solid #000000;">
<?if(!isset($reg) || !$reg):?>
<FORM METHOD=POST ACTION="/login">
<DIV class="fcontainer">
	<FIELDSET id="form1">
		<LEGEND>�������������</LEGEND>
		<LABEL>��� ������������:</LABEL><INPUT TYPE="text" NAME="name">
		<LABEL>������:</LABEL><INPUT TYPE="password" NAME="pass">
		<CENTER><INPUT TYPE="submit" value="����"></CENTER>
		<DIV class="errorlist"><?=$errorlist;?></DIV>
		<DIV class="header">������ �����������</DIV>
		<DIV class="relink">��� ���� ��� ���������� � ���������� �� �����, �� �� ��� �� ����������������? 
			<SPAN CLASS="pseudolink" id="link1" onclick="window.location = '/login/index/reg'">����� ��� ����</SPAN>
		</DIV>
		<DIV class="relink">������ ������? 
			<SPAN CLASS="pseudolink" id="link2" onclick="window.location = '/login/rpass/form'">������������</SPAN>
		</DIV>
		<DIV CLASS="relink">�� ���� ������? 
			<SPAN CLASS="pseudolink" id="link2" onclick="window.location = '<?=base_url();?>'">������� �� ������� ��������</SPAN>
		</DIV>
	</FIELDSET>

</DIV>

</FORM>
<?else:?>

<DIV class="fcontainer">
<FORM METHOD=POST ACTION="/login/register">
	<FIELDSET id="form2">
		<LEGEND>��� ������ ����������� ��������� ��� �����</LEGEND>
		<LABEL TITLE="��� ������������ ����� �������������� ��� ����� � �������">��� ������������:<SPAN style="color:red">*</SPAN></LABEL>
		<INPUT TYPE="text" ID="name" NAME="name" value="<?=$this->input->post('name',TRUE);?>">
		<div style="font-size:8pt;color:red;text-align:center;margin-bottom:20px;">� ����� ������������ ����������� ����� ���������� ��������</div>
		<LABEL TITLE="������� ������">������:<SPAN style="color:red">*</SPAN></LABEL>
		<INPUT TYPE="password" ID="pass" NAME="pass">

		<LABEL TITLE="��������� ������">��������� ������:<SPAN style="color:red">*</SPAN></LABEL>
		<INPUT TYPE="password" ID="pass2" NAME="pass2">

		<LABEL TITLE="������� ����� ����������� �����, ���� ����� ���������� ������ ��� ���������� �������������� �����������">����� e-mail:<SPAN style="color:red">*</SPAN></LABEL>
		<INPUT TYPE="text" ID="email" NAME="email" value="<?=$this->input->post('email',TRUE);?>">

		<LABEL TITLE="����� ���� ���� ��������� �������� �� ������������">������� ������� � ��������:<SPAN style="color:red">*</SPAN></LABEL>
		<INPUT TYPE="text" ID="cpt" NAME="cpt">
		
		<IMG SRC="/<?=$captcha;?>" width="100" height="50" border="1" alt="captcha" style="margin-left:150px;border:1px solid #000000;">
		
		<CENTER><INPUT TYPE="submit" value="�����������"></CENTER>
		<DIV CLASS="relink">�� ��� ����������������? 
			<SPAN CLASS="pseudolink" id="link2" onclick="window.location = '/login/index/auth'">����� ��� ����</SPAN>
		</DIV>
		<?=$errorlist;?>

	</FIELDSET>
</FORM>
</DIV>
<?endif?>


<P>������������������� �� ����� ��� ��������� �����, �� ��������� ����������� ���������� ���� ����������� �� �����-����� ������. � ����� ������� ����� ��������� ������������������ �����, ������� �������� ��� ���������� � ���������� �������� ������ �����������, �������� ������� ��� ���������� ������������� ��� ������� ����������� � ������ ����������� ��� ������� ����������.</P>

<P>������������� ������������� �����, ���������� ���������� ���������� �� �������� �������������� ������, ��������������� � ��������������� �������, ����� ������������ ������ ����� ����� �������� ����������� �������� ������ ������ ������ �����������. ��� ������ ���������� � ��� �� ������ �������� ����� ������, ��� ������ ��� ������� ������ ���.</P>

<P>����� ���� ������, �������� ��� ��������� ��� �����������!</P>

</td>
	<td style="width:10%;">&nbsp;</td>
</tr>
</table>

<DIV id="announcer"></DIV>
</BODY>
</HTML>