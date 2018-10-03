<!DOCTYPE html>
<head>
<title><?=$navigator['title'];?> <?=$title;?></title>
<meta name='yandex-verification' content='74872298f6a53977' />
<?=$this->load->view("shared/shared_js_css", array(), true);?>
</head>
<body>
<!-- navigation -->
	<div class="navbar navbar-inverse">
		<div class="navbar-inner">
			<?=$brand.$menu;?>
		</div>
	</div>
	<div class="well span4 map_name"><?=$map_header;?></div>
<!-- navigation -->
	<table class="main_page_body" id="main_table">
		<tr>
			<td id="YMapsID"><!-- text -->
				<div id="SContainer" class="well">
					<div class="head well">
						<span class="pull-left tag">
							<i class="icon-move icon-white"></i>
							<?=$navigator['header'];?>
						</span>
						<i class="icon-chevron-down icon-white pull-right" id="navdown"></i>
						<i class="icon-chevron-up icon-white pull-right" id="navup"></i>
					</div>
						<ul class="nav nav-tabs" id="navheader">
							<li class="active"><a href="#mainselector" id="iSearch" data-toggle="tab"><?=$navigator['search'];?></a></li>
							<li><a href="#results" id="iFound" data-toggle="tab"><?=$navigator['found'];?> <span id="ResultHead2"></span></a></li>
						</ul>
						
						<div class="tab-content" id="navigator">
							<div id="mainselector" class="tab-pane active">
								<?=$selector;?>
							</div>
							<div id="results" class="tab-pane">
								<div class="grouplabel"><?=$navigator['found'];?></div>
								<input type="text" id="objfilter" title="<?=$navigator['filter_title'];?>" placeholder="<?=$navigator['filter_placeholder'];?>">
								<ul id="resultBody">

								</ul>
							</div>
						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>

<!-- Modal -->
<?=$modals;?>
<!-- Modal -->


<script type="text/javascript">
<!--
	var mp = {
		zoom   : <?=$this->config->item('map_zoom');?>,
		center : [<?=$map_center;?>],
		type   : <?=$this->config->item('map_type');?>,
		lang   : '<?=$this->session->userdata("lang");?>',
		mapset : <?=$mapset;?>,
		headers: ['<?=$headers;?>'],
		otype  : <?=$otype;?>
	},
	<?=$switches?>
//-->
</script>
<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/maps_frontend3.js"></script>
<script type="text/javascript" src="<?=$this->config->item('api');?>/jscript/mapUI.js"></script>
<?=$footer;?>

</body>
</html>