<?php
	require_once('header.php');
	require_once('includes/connection.php');
?>
		<?php if($_SESSION['SESS_PROFIL']!=$ADMIN_PROFIL) echo "<script type='text/javascript'>document.location.replace('../pages/index.php');</script>"; ?>
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
		<div class="modal fade" id="LoginModal" role="dialog">
			<div class="modal-dialog">
			
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning">
						Login déjà existant. Merci d'en choisir un autre  !!
					</div>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
				</div>
			  </div>
			  
			</div>
		</div>
		<div class="modal fade" id="ErrorModal" role="dialog">
			<div class="modal-dialog">
			
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-error">
						Une erreur est survenue, merci de contacter l'administrateur  !!
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
                    <h1 class="page-header">Nouvelle utilisateur</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<form name="reservation" id="reservation" action="includes/update_user.php" method="post">
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
											<option>Mr</option>
											<option>Mme</option>
											<option>Mlle</option>
										</select>
									</div>
								</div>	
								<div class="col-lg-8">                                    
									<div class="form-group">
										<label>Nom</label>
										<input id="nom" name="nom" class="form-control" title="obligatoire">
									</div>
								</div>									
								<div class="col-lg-12">                                    
									<div class="form-group">
										<label>Prénom</label>
										<input id="prenom" name="prenom" class="form-control" title="obligatoire">
									</div>
								</div>
								<div class="col-lg-4">                                    
									<div class="form-group">
										<label>Login</label>
										<input id="username" name="username" class="form-control" title="obligatoire">
									</div>
								</div>
								<div class="col-lg-4">                                    
									<div class="form-group">
										<label>Mot de passe</label>
										<input id="password" name="password" class="form-control" type="password" title="obligatoire">
									</div>
								</div>
								<div class="col-lg-4">                                    
									<div class="form-group">
										<label>Répéter le mot de passe</label>
										<input id="repassword" name="repassword" class="form-control" type="password" title="obligatoire">
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
										<input id="email" name="email" class="form-control">
									</div>
								</div>									
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Téléphone</label>
										<input id="telephone" name="telephone" class="form-control">
									</div>
								</div>
								<div class="col-lg-6">                                    
									<div class="form-group">
										<label>Salon</label>
										<select id="salon" name="salon" class="form-control">
											<option value="1">INFINITE</option>
											<option value="2">ODYSSEE</option>
											<option value="3">TOPKAPI</option>
										</select>
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
											  <option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['nom']; ?></option>      
										<?php
										}
										echo '</select>';
										?>
									</div>
								</div>	
								<div class="col-lg-12">                                    
									<div class="form-group" style="text-align:center">
										<button type="submit" id="action" name="action" value="valider" class="btn btn-outline btn-success" >Enrergistrer</button>
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
				$('#LoginModal').modal('show');
			if (statut == 'Error')
				$('#ErrorModal').modal('show');
		});
        $( function() {
			$( "#dateresa" ).datepicker({ dateFormat: "dd/mm/yy" }).val();
			var currentDate = new Date();  
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
