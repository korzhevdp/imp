<div class="stdViewHeader">
	<?=$location_name;?>&nbsp;&nbsp;-&nbsp;&nbsp;<?=$name;?>
</div>
<div class="stdView">
	<img src="<?=$statmap;?>" alt="minimap">
	<?=(isset($all_images) && strlen($all_images)) ? $all_images : "" ;?>
	<div class="address"><i class="icon-home"></i><?=$address;?></div>
	<div class="contacts"><i class="icon-envelope"></i><?=$contact;?></div>
	<div class="coordinates"><i class="icon-map-marker"></i><span class="coord1"><?=((strlen($lat) > 68) ? substr($lat, 0, 62)."..." : $lat);?></span><br>
	<span class="coord2"><?=((strlen($lon) > 68) ? substr($lon, 0, 62)."..." : $lon);?></span></div>
</div>
<div class="stdViewContent">
	<?=$content;?>
</div>

