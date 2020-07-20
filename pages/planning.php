<?php
	require_once('header.php');
?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Planning des réservations</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			<div class="container" style="background-color:white">

				<div class="page-header">

					<div class="pull-right form-inline">
						<div class="btn-group">
							<button class="btn btn-primary" data-calendar-nav="prev"><< Précédent</button>
							<button class="btn" data-calendar-nav="today">Aujourd'hui</button>
							<button class="btn btn-primary" data-calendar-nav="next">Suivant >></button>
						</div>
						<div class="btn-group">
							<button class="btn btn-warning" data-calendar-view="year">Année</button>
							<button class="btn btn-warning active" data-calendar-view="month">Mois</button>
							<button class="btn btn-warning" data-calendar-view="week">Semaine</button>
							<button class="btn btn-warning" data-calendar-view="day">Jour</button>
						</div>
					</div>

					<h3></h3>
					<small>To see example with events navigate to march 2013</small>
				</div>

				<div class="row">
					<div class="span9">
						<div id="calendar"></div>
					</div>
				</div>

				<div class="clearfix"></div>
				<br><br>

				<script type="text/javascript" src="components/jquery/jquery.min.js"></script>
				<script type="text/javascript" src="components/underscore/underscore-min.js"></script>
				<script type="text/javascript" src="components/bootstrap2/js/bootstrap.min.js"></script>
				<script type="text/javascript" src="components/jstimezonedetect/jstz.min.js"></script>
				<script type="text/javascript" src="js/language/bg-BG.js"></script>
				<script type="text/javascript" src="js/language/nl-NL.js"></script>
				<script type="text/javascript" src="js/language/fr-FR.js"></script>
				<script type="text/javascript" src="js/language/de-DE.js"></script>
				<script type="text/javascript" src="js/language/el-GR.js"></script>
				<script type="text/javascript" src="js/language/it-IT.js"></script>
				<script type="text/javascript" src="js/language/hu-HU.js"></script>
				<script type="text/javascript" src="js/language/pl-PL.js"></script>
				<script type="text/javascript" src="js/language/pt-BR.js"></script>
				<script type="text/javascript" src="js/language/ro-RO.js"></script>
				<script type="text/javascript" src="js/language/es-CO.js"></script>
				<script type="text/javascript" src="js/language/es-MX.js"></script>
				<script type="text/javascript" src="js/language/es-ES.js"></script>
				<script type="text/javascript" src="js/language/es-CL.js"></script>
				<script type="text/javascript" src="js/language/es-DO.js"></script>
				<script type="text/javascript" src="js/language/ru-RU.js"></script>
				<script type="text/javascript" src="js/language/sk-SR.js"></script>
				<script type="text/javascript" src="js/language/sv-SE.js"></script>
				<script type="text/javascript" src="js/language/zh-CN.js"></script>
				<script type="text/javascript" src="js/language/cs-CZ.js"></script>
				<script type="text/javascript" src="js/language/ko-KR.js"></script>
				<script type="text/javascript" src="js/language/zh-TW.js"></script>
				<script type="text/javascript" src="js/language/id-ID.js"></script>
				<script type="text/javascript" src="js/language/th-TH.js"></script>
				<script type="text/javascript" src="js/calendar.js"></script>
				<script type="text/javascript" src="js/app.js"></script>
					<script type="text/javascript">
					var disqus_shortname = 'bootstrapcalendar'; // required: replace example with your forum shortname
					(function() {
						var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
						dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
						(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
					})();
				</script>
				
				<!--<link rel="stylesheet" href="components/bootstrap2/css/bootstrap.css">
				<link rel="stylesheet" href="components/bootstrap2/css/bootstrap-responsive.css">-->
				<link rel="stylesheet" href="css/calendar.css">
				
			</div>
		</div>
	</body>
</html>
