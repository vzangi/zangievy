<link rel='stylesheet' href='/inc/css/manstyle.css?v=1' /> 
<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<div class='row'>
				<div class='col-md-12'>
					<h3>Родители</h3>
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-6'>
					<div class='father'>
						<h4>Отец</h4>
						<?
							if ($father) {
								?><a href='/m/<? echo $father->man['id']; ?>'><?
								if (count($father->manFotos) > 0) {
									?>
										<img src='<? echo $father->manFotos[0]['foto']; ?>' alt='' />
									<?
								} else {
									?><img src='/inc/images/nofoto.png' alt='' /><?
								}
								?><a href='/m/<? echo $father->man['id']; ?>'><? 
									echo $father->man['family']." ".$father->man['name'].
										" ".$father->man['fathername']; 
								?></a><?
							} else {
								?><p>Нет информации</p><?
							}
						?>
					</div>
				</div>
				<div class='col-sm-6'>
					<div class='mother'>
						<h4>Мать</h4>
						<?
							if ($mother) {
								?><a href='/m/<? echo $mother->man['id']; ?>'><?
								if (count($mother->manFotos) > 0) {
									?>
										<img src='<? echo $mother->manFotos[0]['foto']; ?>' alt='' />
									<?
								} else {
									?><img src='/inc/images/nofoto.png' alt='' /><?
								}
								?><a href='/m/<? echo $mother->man['id']; ?>'><? 
									echo $mother->man['family']." ".$mother->man['name'].
										" ".$mother->man['fathername']; 
								?></a><?
							} else {
								?><p>Нет информации</p><?
							}
						?>
					</div>
				</div>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<hr>
				</div>
			</div>
			<div class='row'>
				<div class='col-md-<? if ($currentMan->man['description'] != '') { ?>7<? } else {?>12<?}?>'>
					<div class='current-man'>
					<h2><? echo $currentMan->man['family']." ".$currentMan->man['name'].
							" ".$currentMan->man['fathername'];
							if ($currentMan->man['birthdate'] != '') {
								if (strlen($currentMan->man['birthdate']) == 4) {
									echo ", ".$currentMan->man['birthdate'];
								} else {
									echo ", ".substr($currentMan->man['birthdate'], 6);
								}
							}
							if ($currentMan->man['deathdate'] != '') {
								if (strlen($currentMan->man['deathdate']) == 4) {
									echo " - ".$currentMan->man['deathdate'];
								} else {
									echo " - ".substr($currentMan->man['deathdate'], 6);
								}
							}
					?></h2>
					<?
					if (count($currentMan->manFotos) > 0) {
						?>
							<img src='<? echo $currentMan->manFotos[0]['foto']; ?>' alt='' />
						<?
					} else {
						?><img src='/inc/images/nofoto.png' alt='' /><?
					}
					?>
					</div>	
				</div>
				<? if ($currentMan->man['description'] != '') { ?>
				<div class='col-md-5'>
					<div class='current-man'>
						<p><?php echo str_replace(array("\r\n", "\r", "\n"), '<br>', $currentMan->man['description']); ?></p>
					</div>
				</div>
				<? } ?>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<hr>
					<h3 class='family-header'>Семья</h3>
				</div>
			</div>
			<div class='row'>
				<?
					$partnerCount = count($partners);
					
					if ($partnerCount == 0) {
						?>
						<div class='col-md-12'>
							<p>Нет информации</p>
						</div>
						<?
					} else {
						$colsW = 12;
						//if ($partnerCount == 1) $colsW = 12;
						if ($partnerCount == 2) $colsW = 6;
						if ($partnerCount == 3) $colsW = 4;
						if ($partnerCount == 4) $colsW = 3;
						if ($partnerCount >= 5) $colsW = 2;
						
						for ($i = 0; $i < $partnerCount; $i++) {
							?>
							<div class='col-sm-<? echo $colsW; ?>'>
								<div class='partner'>
									<h4><? 
										if ($currentMan->man['pol'] == 1) {
											?>Жена<?
										} else {
											?>Муж<?
										}
										?>
									</h4>
									<a href='/m/<? echo $partners[$i]->man['id']; ?>'><?
									if (count($partners[$i]->manFotos) > 0) {
										?>
											<img src='<? echo $partners[$i]->manFotos[0]['foto']; ?>' alt='' />
										<?
									} else {
										?><img src='/inc/images/nofoto.png' alt='' /><?
									}
									?><a href='/m/<? echo $partners[$i]->man['id']; ?>'><? 
										echo $partners[$i]->man['family']." ".$partners[$i]->man['name'].
											" ".$partners[$i]->man['fathername']; 
									?></a>
								</div>
								<div class='childs'>
									<h5>Дети</h5>
									<ul>
									<? 
										foreach($allChilds[$i] AS $child) {
											?>
											<li class='child'>
											<a href='/m/<? echo $child->man['id']; ?>'><?
											if (count($child->manFotos) > 0) {
												?>
													<img src='<? echo $child->manFotos[0]['foto']; ?>' alt='' />
												<?
											} else {
												?><img src='/inc/images/nofoto.png' alt='' /><?
											}
											?><a href='/m/<? echo $child->man['id']; ?>'><? 
												echo $child->man['family']." ".$child->man['name'].
													" ".$child->man['fathername'];
											?></a>
											</li>
											<?
										}
									?>
									</ul>
									
								</div>
							</div>
							<?
						}
					}
				?>
			</div>
		</div>
	</div>
</div>