<?php require_once __DIR__ . '/../src/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Presentation master</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="js/autobahn.min.js"></script>
	<script type="text/javascript">
		var wsHost = '<?php echo $hostUri; ?>';
	</script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/presentation_master.js" type="text/javascript"></script>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/css/presentaion_master.css"/>
</head>
<body>


    <div class="container">

        <form class="form-controls">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Controls</h3>
                </div>
                <div class="panel-body">
					<div class="form-group">
						<div class="btn-group btn-group-justified">
							<a class="btn btn-default btn-primary btn-block slide-next">Next</a>
						</div>
					</div>
					<div class="form-group">
						<div class="btn-group btn-group-justified">
							<a class="btn btn-default slide-prev">Previous</a>
							<div class="btn btn-default disabled slide-count">1</div>
							<a class="btn btn-default btn-primary slide-next">Next</a>
						</div>
					</div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Settings</h3>
                </div>
                <div class="panel-body">
                    <ul class="settings list-unstyled">
                        <li>
                            <a class="btn btn-link control"><span class="badge">off</span>Guest controls</a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>

    </div> <!-- /container -->
</body>
</html>
