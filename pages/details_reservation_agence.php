<?php
	require_once('header.php');
	require_once('includes/connection_agence.php');
?>
		<div class="modal fade" id="ChampsModal" role="dialog">
			<div class="modal-dialog">
			
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning">
						Merci de remplir les champs obligatoires !!
					</div>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
				</div>
			  </div>
			  
			</div>
		</div>
		<div class="modal fade" id="salonModal" role="dialog">
			<div class="modal-dialog">
			
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-danger" style="text-align:center">
						<h3>Attention !!</h3>
						<h4>Cette réservation a été effectuée dans un salon différent du vôtre</h4>
					</div>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
				</div>
			  </div>
			  
			</div>
		  </div>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Détails réservation</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<?php
			function multiexplode ($delimiters,$string) {
                $ready = str_replace($delimiters, $delimiters[0], $string);
                $launch = explode($delimiters[0], $ready);
                return  $launch;
            }
          
			if(isset($_GET['id']) && (trim($_GET['id']) != ''))
			{
				$id_resa = $_GET['id'];
			}
			else
			{
				echo "<script type='text/javascript'>document.location.replace('../pages/new_reservation_agence.php');</script>";
			}
			
			//Create query
			$qry="SELECT date, t.id, c.civilite, c.nom, c.prenom,  r.vol, compagnie, porte, s.id, o.nom, r.date_validation, c.email, c.telephone, c.nationnalite, c.num_passeport, c.naissance, c.delivrance, r.`id_client`,m.fname, m.lname, r.`date_ajout`, m2.fname, m2.lname, r.`date_update`, m3.fname, m3.lname, r.agence, a.nom ";
			$qry.="FROM `reservation_agence` r, tranche t, client_agence c, statut s, origine o, member_agence m, member_agence m2, member_agence m3, agence a ";
			$qry.="where r.`id_client` = c.id and r.`statut` = s.id and r.`id_tranche` = t.id and r.id_origine = o.id and r.id ='$id_resa' and r.`user_validation`=m.mem_id and r.`user_ajout`=m2.mem_id and r.`user_update`=m3.mem_id and a.`id`=r.agence;";
			$result=mysqli_query($bd, $qry);
			//Check whether the query was successful or not
			if($result) {
				if(mysqli_num_rows($result) > 0) {
					$resa = mysqli_fetch_array($result, MYSQLI_BOTH);
					$civilite = $resa[2];
					$nom = $resa[3];
					$prenom = $resa[4];					
					$nationalite = $resa[13];
					$num_pass = $resa[14];
					$email = $resa[11];
					$telephone = $resa[12];
					$vol = $resa[5];
					$compagnie = $resa[6];
					$porte = $resa[7];
					$dateresa = $resa[0];
					$tranche = $resa[1];
					$statut = $resa[8];
					$origine = $resa[9];					
					$dateValid = $resa[10];
					$id_client = $resa[17];
					$user_validation = $resa[18]." ".$resa[19];
					$date_ajout = $resa[20];
					$user_ajout = $resa[21]." ".$resa[22];
					$date_update = $resa[23];
					$user_update = $resa[24]." ".$resa[25];
					$salon = $resa[26];
					$agence = $resa[27];
					
					$disabled = "disabled";
					// if ($statut != '1')
						// $disabled = "disabled";
					// else
						// $disabled = "";
					
					if ($resa[15]!= '' && $resa[15] != "0000-00-00")
					{
						list($year, $month, $day) = multiexplode(array("/",".","-",":"), $resa[15]);
						$jour = $day;
						$mois = $month;
						$annee = $year;
					}
					if ($resa[16] != '' && $resa[16] != "0000-00-00")
					{
						list($year, $month, $day) = multiexplode(array("/",".","-",":"), $resa[16]);
						$jour_pass = $day;
						$mois_pass = $month;
						$annee_pass = $year;
					}
					if ($dateresa != '')
					{
						list($year, $month, $day) = multiexplode(array("/",".","-",":"), $dateresa);
						$dateresa = $day.'/'.$month.'/'.$year ;
					}
				}
			}
			
			?>
			
			<form name="reservation" id="reservation" action="includes/update_reservation_agence.php?id=<?php echo $id_resa ?>&id_client=<?php echo $id_client ?>" method="post">
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default" style="height:470px">
                        <div class="panel-heading" style="font-size: 20px;">
                            <i class="fa fa-user fa-fw"></i>Réservation agence - <?php echo $agence ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
								<div class="col-lg-4">                                    
									<div class="form-group">
										<label>Civilité</label>
										<select class="form-control" name="civilite" id="civilite" title="obligatoire" <?php echo $disabled ?>>
											<option <?php if($civilite=="Mr") echo 'selected="selected"' ?>>Mr</option>
											<option <?php if($civilite=="Mme") echo 'selected="selected"' ?>>Mme</option>
											<option <?php if($civilite=="Mlle") echo 'selected="selected"' ?>>Mlle</option>
										</select>
									</div>
								</div>	
								<div class="col-lg-8">                                    
									<div class="form-group">
										<label>Nom</label>
										<input id="nom" name="nom" class="form-control" value="<?php echo $nom ?>" title="obligatoire" <?php echo $disabled ?>>
									</div>
								</div>									
								<div class="col-lg-12">                                    
									<div class="form-group">
										<label>Prénom</label>
										<input id="prenom" name="prenom" class="form-control"  value="<?php echo $prenom ?>" title="obligatoire" <?php echo $disabled ?>>
									</div>
								</div>		
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Date</label>
										<input id="dateresa" name="dateresa" class="form-control" value="<?php echo $dateresa ?>" <?php echo $disabled ?>>
									</div>
								</div>									
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Tranche horaire</label>
										<?php
										$select = mysqli_query($bd,"SELECT id, nom FROM tranche ORDER BY id");
										echo '<select id="tranche" name="tranche" class="form-control" '.$disabled.'>';
										while($fetch = mysqli_fetch_array($select)){
											?>  
											  <option <?php if($tranche==$fetch['id']) echo 'selected="selected" '.$disabled ?> value="<?php echo $fetch['id']; ?>"><?php echo $fetch['nom']; ?></option>      
										<?php
										}
										echo '</select>';
										?>
									</div>
								</div>			
								<div class="col-lg-3">                                    
									<div class="form-group">
										<label>Numéro de billet</label>
										<input id="porte" name="porte" class="form-control" value="<?php echo $porte ?>" <?php echo $disabled ?>>
									</div>
								</div>
								<div class="col-lg-3">                                    
									<div class="form-group">
										<label>Numéro de vol</label>
										<input id="vol" name="vol" class="form-control"  value="<?php echo $vol ?>" title="obligatoire" <?php echo $disabled ?>>
									</div>
								</div>									
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Compagnie</label>
										<input id="compagnie" name="compagnie" class="form-control"  value="<?php echo $compagnie ?>" title="obligatoire" <?php echo $disabled ?>>
									</div>
								</div>						
								<div class="col-lg-12">
									<div class="well well-sm">
										<p>Création : <?php echo $date_ajout.' par '.$user_ajout ?></p>
										<p>Dernière modification : <?php echo $date_update.' par '.$user_update ?></p>
									</div>
								</div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				
                <div class="col-lg-6">
                    <div class="panel panel-default" style="height:380px">
                        <div class="panel-heading" style="font-size: 20px;">
                            <i class="fa fa-phone fa-fw"></i>Informations complémentaires
                        </div>
                        <div class="panel-body">
                            <div class="row">
								<div class="col-lg-8">
									<label>Date de  naissance</label>
									<div class="form-group">
										<div class="col-lg-4">
										<div class="form-group">
											<input id="jour" name="jour" class="form-control" placeholder="Jour"  value="<?php echo $jour ?>" <?php echo $disabled ?>>
											</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
											<select id="mois" name="mois" class="form-control" <?php echo $disabled ?>>
												<option <?php if($mois=='0') echo 'selected="selected"' ?> value="0">Mois</option>
												<option <?php if($mois=='1') echo 'selected="selected"' ?> value="1">Janvier</option>
												<option <?php if($mois=='2') echo 'selected="selected"' ?> value="2">Février</option>
												<option <?php if($mois=='3') echo 'selected="selected"' ?> value="3">Mars</option>
												<option <?php if($mois=='4') echo 'selected="selected"' ?> value="4">Avril</option>
												<option <?php if($mois=='5') echo 'selected="selected"' ?> value="5">Mai</option>
												<option <?php if($mois=='6') echo 'selected="selected"' ?> value="6">Juin</option>
												<option <?php if($mois=='7') echo 'selected="selected"' ?> value="7">Juillet</option>
												<option <?php if($mois=='8') echo 'selected="selected"' ?> value="8">Août</option>
												<option <?php if($mois=='9') echo 'selected="selected"' ?> value="9">Septembre</option>
												<option <?php if($mois=='10') echo 'selected="selected"' ?> value="10">Octobre</option>
												<option <?php if($mois=='11') echo 'selected="selected"' ?> value="11">Novembre</option>
												<option <?php if($mois=='12') echo 'selected="selected"' ?> value="12">Décembre</option>
											</select>
											</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
											<input id="annee" name="annee" class="form-control" placeholder="Année"  value="<?php echo $annee ?>" <?php echo $disabled ?>>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Nationalité</label>
										<input id="nationalite" name="nationalite" class="form-control" value="<?php echo $nationalite ?>" <?php echo $disabled ?>>
									</div>
								</div>
								
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Numéro de passeport</label>
										<input id="num_pass" name="num_pass" class="form-control"  value="<?php echo $num_pass ?>" <?php echo $disabled ?>>
									</div>
								</div>
								<div class="col-lg-8">
									<label>Date de délivrance</label>
									<div class="form-group">
										<div class="col-lg-4">
										<div class="form-group">
											<input id="jour_pass" name="jour_pass" class="form-control" placeholder="Jour"  value="<?php echo $jour_pass ?>" <?php echo $disabled ?>>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
											<select id="mois_pass" name="mois_pass" class="form-control"  <?php echo $disabled ?>>
												<option <?php if($mois_pass=='0') echo 'selected="selected"' ?> value="0">Mois</option>
												<option <?php if($mois_pass=='1') echo 'selected="selected"' ?> value="1">Janvier</option>
												<option <?php if($mois_pass=='2') echo 'selected="selected"' ?> value="2">Février</option>
												<option <?php if($mois_pass=='3') echo 'selected="selected"' ?> value="3">Mars</option>
												<option <?php if($mois_pass=='4') echo 'selected="selected"' ?> value="4">Avril</option>
												<option <?php if($mois_pass=='5') echo 'selected="selected"' ?> value="5">Mai</option>
												<option <?php if($mois_pass=='6') echo 'selected="selected"' ?> value="6">Juin</option>
												<option <?php if($mois_pass=='7') echo 'selected="selected"' ?> value="7">Juillet</option>
												<option <?php if($mois_pass=='8') echo 'selected="selected"' ?> value="8">Août</option>
												<option <?php if($mois_pass=='9') echo 'selected="selected"' ?> value="9">Septembre</option>
												<option <?php if($mois_pass=='10') echo 'selected="selected"' ?> value="10">Octobre</option>
												<option <?php if($mois_pass=='11') echo 'selected="selected"' ?> value="11">Novembre</option>
												<option <?php if($mois_pass=='12') echo 'selected="selected"' ?> value="12">Décembre</option>
											</select>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
											<input id="annee_pass" name="annee_pass" class="form-control" placeholder="Année" value="<?php echo $annee_pass ?>" <?php echo $disabled ?>>
										</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Email</label>
										<input id="email" name="email" class="form-control"  value="<?php echo $email ?>" <?php echo $disabled ?>>
									</div>
								</div>									
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Téléphone</label>
										<input id="telephone" name="telephone" class="form-control"  value="<?php echo $telephone ?>" <?php echo $disabled ?>>
									</div>
								</div>
								<!--<div class="col-lg-12">
									<div class="form-group">
										<div class="checkbox">
											<label>
												<input id="news" name="news" type="checkbox" value="">Je souhaite recevoir par mail les meilleures promotions
											</label>
										</div>
									</div>
								</div>-->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				<div class="col-lg-6">
                    <div class="panel panel-default" style="height:70px">
                        <div class="panel-body">
                            <div class="row">
								<?php
								switch ($statut) {
									case "1":
										?>
								<div class="col-lg-6">                                    
									<div class="form-group" style="text-align:center">
										<button type="submit" id="action" name="action" value="valider" class="btn btn-outline btn-success" >Valider réservation</button>
									</div>
								</div>
								<div class="col-lg-6">                                    
									<div class="form-group" style="text-align:center">
										<button type="submit" id="action" name="action" value="annuler" class="btn btn-outline btn-danger" >Annuler réservation</button>
									</div>
								</div>
										<?php
										
										break;
									case "2":
										?>
								<div class="col-lg-12">                                    
									<div class="form-group" style="text-align:center">
										<button type="submit" id="action" name="action" value="valider" class="btn btn-outline btn-success" disabled>Réservation validée le <?php echo $dateValid ?></button>
									</div>
								</div>
										<?php
										break;
								}
								?>
								
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				
				
                <!-- /.col-lg-12 -->
            </div>
			</form>
            <!-- /.row -->			
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
	<script type="text/javascript">
        $( function() {
			$( "#dateresa" ).datepicker({ dateFormat: "dd/mm/yy" }).val();
			var currentDate = new Date();  
			if($( "#dateresa" ).val() == '')
				$("#dateresa").datepicker("setDate",currentDate);
		  } );
		  
		$('#reservation').submit(function () {
			var allIsOk = true;

			// Check if empty of not
			$(this).find( '[title="obligatoire"]' ).each(function () {
				if ( ! $(this).val() ) { 
					$('#ChampsModal').modal('show');
					$(this).addClass('borderR').focus();
					allIsOk = false;
					return allIsOk;
				}
			});

			return allIsOk
		});
  </script>
    </script>

</body>

</html>
