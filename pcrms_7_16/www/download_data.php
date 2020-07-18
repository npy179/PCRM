<?php require_once("connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>PCRMs</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- <link href="css/mdb.min.css" rel="stylesheet"> -->

  <link href="css/style.css" rel="stylesheet">

  <style>

	@media (min-width: 1405px) {
		.container-fluid{
			width: 1200px;
		}
	}
  </style>

</head>

<body>

	<nav class="navbar py-1 navbar-expand-sm bg-light">
		<a class="navbar-brand" href="">
		<img src="/images/UNCC.png" class="rounded" alt="Logo" style="width:80px">
		</a>
		<ul class="nav nav-pills">
		<li class="nav-item">
			<a class="nav-link" href="index.php"><i class="fa fa-home" style="font-size:20px"></i>Home</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="browse_dataset.php"><i class="fa fa-list-alt" style="font-size:20px"></i>Browse Database</a>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-search" style="font-size:20px"></i>Detailed Search</a>
			<div class="dropdown-menu">
			<a class="dropdown-item" href="DS_get_genes_closest_crm.php">Search closest CRMs for genes</a>
			<a class="dropdown-item" href="DS_get_crm_in_genes_range.php">Search CRMs in a range of genes</a>
			<a class="dropdown-item" href="DS_get_tf.php">Search TFBSs for transcriptional factor</a>
			</div>      
		</li>

		<li class="nav-item">
			<a class="nav-link active" href="download_data.php"><i class="fa fa-download" style="font-size:20px"></i>Download Data</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="https://sulab.uncc.edu/zhengchang-su-phd"><i class="fa fa-flask" style="font-size:20px"></i>Su Lab</a>
		</li>
		</ul>
 	</nav>


	<div class="jumbotron py-6 bg-info mb-1 jumbotron-fluid"></div>

    <div class="container-fluid">

		<div class="row">
				<div class="col">
					<div class="card">
						<div class="card-header text-white bg-primary">
							<h5>Homo sapiens</h5>
						</div>
						<div class="card-body">
							<h5 class="card-title">Predicted CRMs of Homo sapiens(hs38) p value=0.05 (score cutoff=56)</h5>
							<p class="card-text">
							<ul>
								<li>Coordinates of enhancers</li>
								<li>Coordinates and UmotifId of TFBSs</li>
								<li>Score/P value of enhancers</li>

							</ul>
							
							</p>
							<a href="/human_56.bed.gz" class="card-link">human_56.bed.gz(17M)</a>
						</div>
					</div>

				</div>

				<div class="col">
					<div class="card">
						<div class="card-header text-dark bg-warning">
							<h5>Mus musculus</h5>
						</div>
						<div class="card-body">
							<h5 class="card-title">Predicted CRMs of Mus musculus(mm10) at p value=0.05 (score cutoff=79)</h5>

							<p class="card-text">
								<ul>
									<li>Coordinates of enhancers</li>
									<li>Coordinates and UmotifId of TFBSs</li>
									<li>Scores/P value of enhancers</li>
								</ul>
							
							</p>
							<a href="/mouse_79.bed.gz" class="card-link">mouse_79.bed.gz(12M)</a>
						</div>
					</div>
				</div>


				<div class="col">
					<div class="card">
							<div class="card-header text-white bg-success">
								<h5>Caenorhabditis elegans</h5>
							</div>
						<div class="card-body">
							<h5 class="card-title">Predicted CRMs of Caenorhabditis elegans(ce10) at p value=0.05 (score cutoff=275)</h5>

							<p class="card-text">
							<ul>
								<li>Coordinates of enhancers</li>
								<li>Coordinates and UmotifId of TFBSs</li>
								<li>Scores/P value of enhancers</li>
							</ul>
							
							</p>
							<a href="/ce_275.bed.gz" class="card-link">ce_275.bed.gz(0.17M)</a>
						</div>
					</div>
				</div>

		</div>


    </div>

	<div class="wrapper flex-grow-1"></div>
	<footer class="page-footer font-small fixed-bottom">
		<!-- Copyright -->
		<div class="footer-copyright text-center py-3">© Copyright 2020:
		<a href="https://sulab.uncc.edu/zhengchang-su-phd"> Sulab at UNC at Charoltte</a>
		</div>
		<!-- Copyright -->
	</footer>

</body>

</html>