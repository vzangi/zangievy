<link rel='stylesheet' href='/inc/css/man-page.css?q=2' /> 

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

<div class='content'>
<?
//print_r($currentMan);
function showMan($k, $man){
	?>
	<table>
		<tbody>
			<tr>
				<td style='font-size:<? if ($k < 7) { echo 15-$k; } else { echo 8; } ?>px; <?
				if ($k == 1) {
					?>padding-top:10px;<?
				}
				?>'>
					<img class='man-foto man-k-<? echo $k; ?>' src='<? if (count($man->manFotos) > 0) {
							echo $man->manFotos[0]['foto']; 
						} else {?>/inc/images/nofoto.png<? } ?>' alt='<? 
							echo $man->man['family'].' ';
							echo $man->man['name']; 
						?>' 
							data-man='<? echo json_encode($man->man); ?>'
							data-foto='<? echo json_encode($man->manFotos); ?>'
						<?
							if ($k == 1) {?>style='width:200px;'<?}
							?>/>
					<b class='man-fio'><a href='/man/<? echo $man->man['id']; ?>'><? 
						echo $man->man['family'].' ';
						echo $man->man['name']; 
						?></a> <a target='_blank' href='/m/<? echo $man->man['id']; ?>'><img class='info' src='/inc/images/icon-info.svg' alt=''/></a>
						<br><small><?
						if (strlen($man->man['birthdate']) > 3){ 
							if (strlen($man->man['birthdate']) <= 4) { echo "&nbsp;"; }
							if (strlen($man->man['birthdate']) == 4) { echo $man->man['birthdate']; }
							if (strlen($man->man['birthdate']) == 10) { echo substr($man->man['birthdate'], 6); }
							if ($man->man['deathdate'] != '') {
								if (strlen($man->man['deathdate']) <= 4) { echo "&nbsp;"; }
								if (strlen($man->man['deathdate']) <= 4) { echo ' - '.$man->man['deathdate']; }
								if (strlen($man->man['deathdate']) == 10) { echo ' - '.substr($man->man['deathdate'], 6); }
							} else {
								echo "&nbsp;";
							}
						} else {
							echo "&nbsp;";
						}
						?></small></b>
						
				</td>
			</tr>
			<tr>
				<td>
					<table>
						<tbody>
							<tr>
							<?
								if ($k < 8) {
									$partners = $man->getPartners();
									foreach($partners AS $partner) {
									?>
									<td class='nsk'>
										<img class='man-foto  woman-k-<? echo $k; ?>' src='<? if (count($partner->manFotos) > 0) {
												echo $partner->manFotos[0]['foto']; 
											} else {
												?>/inc/images/nofoto.png<?
											}?>' alt='<? 
												echo $partner->man['family'].' ';
												echo $partner->man['name']; 
											?>' 
											data-man='<? echo json_encode($partner->man); ?>'
											data-foto='<? echo json_encode($partner->manFotos); ?>'
										/>
									<p style='font-size:<? if ($k < 7) { echo 15-$k; } else { echo 8; } ?>px;'><small class='man-fio'><a href='/man/<? echo $partner->man['id']; ?>'><? 
									if (false) if ($man->man['pol'] == 1) { ?>Жена<? } else {?>Муж<? } ?>
										<? echo $partner->man['family'].' '.$partner->man['name']?></a> 
										<a target='_blank' href='/m/<? echo $partner->man['id']; ?>'><img class='info' src='/inc/images/icon-info.svg' alt=''/></a>
										</small>
										<br><small><?
										if (strlen($partner->man['birthdate']) > 3){ 
											if (strlen($partner->man['birthdate']) <= 4) { echo "&nbsp;"; }
											if (strlen($partner->man['birthdate']) == 4) { echo $partner->man['birthdate']; }
											if (strlen($partner->man['birthdate']) == 10) { echo substr($partner->man['birthdate'], 6); }
											if ($partner->man['deathdate'] != '') {
												if (strlen($partner->man['deathdate']) <= 4) { echo ' - '.$partner->man['deathdate']; }
												if (strlen($partner->man['deathdate']) == 10) { echo ' - '.substr($partner->man['deathdate'], 6); }
											}
										} else {
											echo "&nbsp;";
										}
										?></small></p>
										<?
											$childs = $partner->getChilds( $man );
											if (count($childs) > 0) {
												?><hr><?
											}
										?>
										<table>
											<tr>
											<?
												foreach($childs AS $child) {
													?><td class='nsk'><?
													showMan($k+1, $child);
													?></td><?
												}
											?>
											</tr>
										</table>
									</td>
									<?
									}
								}
							?>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	<?
}

function showFather($f, $fathers){
	if ($f == -1) { 
		global $currentMan;
		?>
		<table class='drevo'>
			<tbody>
				<tr>
					<td>
						<?
						showMan(1, $currentMan);
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<?
	} else {
		$clr = 255 - $f*5;
		//$clr = 255;
	?>
	<table class='father' style='background:rgb(<? echo $clr; ?>,<? echo $clr; ?>,<? echo $clr; ?>);'>
		<tbody>
			<tr>
				<td>
					<p><a href='/man/<? echo $fathers[$f]->man['id']; ?>'><? 
						echo $fathers[$f]->man['family'].' '; 
						echo $fathers[$f]->man['name']; 
					?></a></p>
					<? 
						showFather($f-1, $fathers);
					?>
				</td>
			</tr>
		</tbody>
	</table>
	<?
	}
}

if (count($fathers) == 1) {
	showMan(1, $currentMan);
} else {
	showFather(count($fathers)-2, $fathers);
}

?>
</div>
<footer>
	<img class='gerb-image' src='/inc/images/gerb2.jpg'/>
</footer>
<script src='/inc/js/man-page.js'></script>

<div class="modal fade" tabindex="-1" role="dialog" id='info'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <img class='info-foto' />
		<div class='man-dates'></div>
		<p class='man-desc'></p>
      </div>
    </div>
  </div>
</div>