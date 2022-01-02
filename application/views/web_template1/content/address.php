<?php
	$site = $this->webinfo_model->getOnceWebMain();
	// dieArray(unserialize($site['WD_Address']));
	$WD_Address = array();
	if ($site['WD_Address'] !== '' && $this->serialized_model->is_serialized($site['WD_Address']) === true)
		$site['WD_Address'] = unserialize(preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $site['WD_Address']));
    
	$WD_Tel = array();
	if ($site['WD_Tel'] !== '' && $this->serialized_model->is_serialized($site['WD_Tel']) === true)
		$site['WD_Tel'] = unserialize(preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $site['WD_Tel']));

	$WD_Fax = array();
	if ($site['WD_Fax'] !== '' && $this->serialized_model->is_serialized($site['WD_Fax']) === true)
		$site['WD_Fax'] = unserialize(preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $site['WD_Fax']));

	if (sizeof($site['WD_Address']) 		> sizeof($site['WD_Tel']) 			&& sizeof($site['WD_Address']) 	> sizeof($site['WD_Fax'])) $WD_sizeof = sizeof($site['WD_Address']);
	else 	if (sizeof($site['WD_Tel']) 	> sizeof($site['WD_Address']) 	&& sizeof($site['WD_Tel']) 		> sizeof($site['WD_Fax'])) $WD_sizeof = sizeof($site['WD_Tel']);
	else 	if (sizeof($site['WD_Fax']) 	> sizeof($site['WD_Address']) 	&& sizeof($site['WD_Fax']) 		> sizeof($site['WD_Tel'])) $WD_sizeof = sizeof($site['WD_Fax']);
	else 	$WD_sizeof = sizeof($site['WD_Address']);

	$WD_Addmaps = array(base_url('assets/images/map/luckydoor.jpg'), base_url('assets/images/map/jwood.jpg'));
	// dieArray($site['WD_Address']);
	for ($WD = 0; $WD < $WD_sizeof; ++$WD) { ?>
		<div class="adr-<?php echo ($WD + 1); ?>">
			<p><?php if (isset($site['WD_Address'][$WD])) echo ltrim($site['WD_Address'][$WD], '<br />'); ?>&nbsp;<a class="help" href="<?php echo $WD_Addmaps[$WD]; ?>" target="_blank">>> คลิกเพื่อดูแผนที่</a></p>
			<!-- <p><?php if (isset($site['WD_Address'][$WD])) echo ltrim($site['WD_Address'][$WD], '<br />'); ?></p> -->
			<p>
				<?php
					if (isset($site['WD_Tel'][$WD])) echo 'โทรศัพท์: '.ltrim($site['WD_Tel'][$WD], '<br />').' &nbsp; ';
					if (isset($site['WD_Fax'][$WD])) echo 'โทรสาร: '.ltrim($site['WD_Fax'][$WD], '<br />');
				?>
			</p>
		</div> <?php
	}
?>