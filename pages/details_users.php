<?php
	require_once('header.php');
	require_once('includes/connection.php');
?>
		<?php if($_SESSION['SESS_PROFIL']!=$ADMIN_PROFIL) echo "<script type='text/javascript'>document.location.replace('../pages/index.php');</script>"; ?>
        <div class="modal fade" id="PassModal" role="dialog">
			<div class="modal-dialog">
			
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning">
						Mot de passe incorrect. Merci de réessayer !!
					</div>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
				</div>
			  </div>
			  
			</div>
		</div>   
        <?php
									
			if(isset($_GET['id']) && (trim($_GET['id']) != ''))
			{
				$id_user = $_GET['id'];
			}
			else
			{
				if(isset($_SESSION['SESS_MEMBER_ID']) && (trim($_SESSION['SESS_MEMBER_ID']) != '')) {
					$id_user = $_SESSION['SESS_MEMBER_ID'];
				}
				else
				{
					echo "<script type='text/javascript'>document.location.replace('../pages/new_user.php');</script>";
				}
			}
			
			//Create query
			$qry="SELECT `mem_id`, `gender`, `fname`, `lname`, `contact`, `telephone`, `username`, s.`nom`, p.`nom`, `profil`, `salon`, `password` ";
			$qry.="FROM `member` m, `profil` p, `salon` s ";
			$qry.="where s.`id` = `salon` and p.`id` = `profil` and `mem_id`='$id_user'";
			$result=mysqli_query($bd, $qry);
			//Check whether the query was successful or not
			if($result) {
				if(mysqli_num_rows($result) > 0) {
					$user = mysqli_fetch_array($result, MYSQLI_BOTH);
					$civilite = $user[1];
					$nom = $user[3];
					$prenom = $user[2];
					$username = $user[6];
					$password = $user[11];
					$email = $user[4];
					$telephone = $user[5];
					$salon = $user[10];	
					$profil = $user[9];
					
					$disabled = "";
					
				}
			}
			
			?>
        <form name="reservation" id="reservation" action="includes/update_user.php?id=<?php echo $id_user ?>" method="post">
		<div class="modal fade" id="modalPass" role="dialog">
			<div class="modal-dialog">			
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">						
						<div class="alert alert-info" style="height:150px;">
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Nouveau mot de passe</label>
										<input id="password" name="password" class="form-control" type="password">
									</div>
								</div>
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Répéter le mot de passe</label>
										<input id="repassword" name="repassword" class="form-control" type="password">
									</div>
								</div>
								<div class="col-lg-12">                                    
									<div class="form-group" style="text-align:center">
										<button type="submit" id="action" name="action" value="valider" class="btn btn-outline btn-info" >Enregistrer</button>
									</div>
								</div>
						</div>			
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
					</div>
				</div>			  
			</div>
		</div>
		<div class="modal fade" id="ChampsModal" role="dialog">
			<div class="modal-dialog">
			
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning">
						Merci de remplir tous les champs !!
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
                    <h1 class="page-header">Détails utilisateur</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			
			
			
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-danger" style="height:300px">
                        <div class="panel-heading" style="font-size: 20px;">
                            <i class="fa fa-user fa-fw"></i>Utilisateur
                        </div>
                        <div class="panel-body">
                            <div class="row">
								<div class="col-lg-4">                                    
									<div class="form-group">
										<label>Civilité</label>
										<select class="form-control" name="civilite" id="civilite">
											<option <?php if($civilite=="Mr") echo 'selected="selected"' ?>>Mr</option>
											<option <?php if($civilite=="Mme") echo 'selected="selected"' ?>>Mme</option>
											<option <?php if($civilite=="Mlle") echo 'selected="selected"' ?>>Mlle</option>
										</select>
									</div>
								</div>	
								<div class="col-lg-8">                                    
									<div class="form-group">
										<label>Nom</label>
										<input id="nom" name="nom" class="form-control" title="obligatoire" value="<?php echo $nom ?>">
									</div>
								</div>									
								<div class="col-lg-12">                                    
									<div class="form-group">
										<label>Prénom</label>
										<input id="prenom" name="prenom" class="form-control" title="obligatoire" value="<?php echo $prenom ?>">
									</div>
								</div>
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Login</label>
										<input id="username" name="username" class="form-control" title="obligatoire" value="<?php echo $username ?>">
									</div>
								</div>
								
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Mot de passe</label>
										<input id="oldpassword" name="oldpassword" class="form-control" type="password"  value="<?php echo $password ?>" disabled="disabled">
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
                    <div class="panel panel-success" style="height:300px">
                        <div class="panel-heading" style="font-size: 20px;">
                            <i class="fa fa-phone fa-fw"></i>Coordonnées et Affectation
                        </div>
                        <div class="panel-body">
                            <div class="row">
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Email</label>
										<input id="email" name="email" class="form-control" value="<?php echo $email ?>">
									</div>
								</div>									
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Téléphone</label>
										<input id="telephone" name="telephone" class="form-control" value="<?php echo $telephone ?>">
									</div>
								</div>
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Salon</label>
										<?php
										$select = mysqli_query($bd,"SELECT id, nom FROM salon ORDER BY id");
										echo '<select id="salon" name="salon" class="form-control">';
										while($fetch = mysqli_fetch_array($select)){
											?>  
											  <option <?php if($salon==$fetch['id']) echo 'selected="selected"' ?> value="<?php echo $fetch['id']; ?>"><?php echo $fetch['nom']; ?></option>      
										<?php
										}
										echo '</select>';
										?>
									</div>
								</div>	
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Profil</label>
										<?php
										$select = mysqli_query($bd,"SELECT id, nom FROM profil ORDER BY id");
										echo '<select id="profil" name="profil" class="form-control">';
										while($fetch = mysqli_fetch_array($select)){
											?>  
											  <option <?php if($profil==$fetch['id']) echo 'selected="selected"' ?> value="<?php echo $fetch['id']; ?>"><?php echo $fetch['nom']; ?></option>      
										<?php
										}
										echo '</select>';
										?>
									</div>
								</div>										
								<div class="col-lg-6">                                    
									<div class="form-group" style="text-align:center">
										<button type="button" data-toggle="modal" data-target="#modalPass" class="btn btn-outline btn-info" >Modifier le mot passe</button>
									</div>
								</div>								
								<div class="col-lg-6">                                    
									<div class="form-group" style="text-align:center">
										<button type="submit" id="action1" name="action1" value="valider" class="btn btn-outline btn-success" >Enregistrer</button>
									</div>
								</div>						
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
	   $(document).ready(function() {			
			var getUrlParameter = function getUrlParameter(sParam) {
				var sPageURL = decodeURIComponent(window.location.search.substring(1)),
					sURLVariables = sPageURL.split('&'),
					sParameterName,
					i;

				for (i = 0; i < sURLVariables.length; i++) {
					sParameterName = sURLVariables[i].split('=');

					if (sParameterName[0] === sParam) {
						return sParameterName[1] === undefined ? true : sParameterName[1];
					}
				}
			};
			
			var statut = getUrlParameter('statut');
			if (statut == 'Nok')
				$('#PassModal').modal('show');
		});
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
