<?php require_once("connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>PCRMs</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="css/style.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

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
			<a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#"><i class="fa fa-search" style="font-size:20px"></i>Detailed Search</a>
            <div class="dropdown-menu">
            <a class="dropdown-item" href="DS_get_genes_closest_crm.php">Search closest CRMs for genes</a>
            <a class="dropdown-item" href="DS_get_crm_in_genes_range.php">Search CRMs in a range of genes</a>
            <a class="dropdown-item" href="DS_get_tf.php">Search TFBSs for transcriptional factor</a>
            </div>      
		</li>
		<li class="nav-item">
			<a class="nav-link" href="download_data.php"><i class="fa fa-download" style="font-size:20px"></i>Download Data</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="https://sulab.uncc.edu/zhengchang-su-phd"><i class="fa fa-flask" style="font-size:20px"></i>Su Lab</a>
		</li>
		</ul>
    </nav>

    <div class="jumbotron py-6 bg-info mb-1 jumbotron-fluid"></div>

    <div class="container">

        <div class="row">
            <div class="col">
                <div class="card border-dark p-4">
                    <div class="row">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header text-white bg-primary">
                                    <h5>Search closest CRMs for genes</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                    <ul>
                                        <li>Select a specie</li>
                                        <li>Input gene symbol/ID eg. CSTP1 or CTP, ENSG00000228476</li>
                                        <li>Select the p value threshold of CRMs, ..</li>
                                    </ul>                        
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <form action="/get_genes_closest_crm.php" method="POST">
                                    <div class="form-group">
                                        <label for="genome_id">Select a specie:</label>
                                        <select name="genome_id" class="form-control" id="gene_genome_id">
                                        <option disabled selected>Select species..</option>
                                        <option value="1">Homo sapiens</option>
                                        <option value="2">Mus musculus</option>
                                        <option value="3">Caenorhabditis elegans</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="gene_id">Input gene:</label>
                                        <input type="text" class="form-control" name="gene_id" id="gene_id" value="CSTP1,ENSG00000228476..">
                                    </div>

                                    <div class="form-group">
                                        <label for="p_value">Input p value threshold of CRMs:</label>
                                        <select class="custom-select" name="p_value" id="p_value">
                                            <option disabled selected>Select p value..</option>
                                            <option value="0.05">0.05</option>
                                            <option value="0.01">0.01</option>
                                            <option value="0.000005">5E-06</option>
                                            <option value="0.000001">1E-06</option>
                                        </select>
                                    </div>
                                    
                                    <button class="btn btn-primary" type="submit">Search</button>
                            </form>  
                        </div>

                    </div>

                </div>
            </div>
        </div>


    </div>

    <script src="dynamics_detail_search.js"></script>
    <div class="wrapper flex-grow-1"></div>
	<footer class="page-footer font-small blue">
		<!-- Copyright -->
		<div class="footer-copyright text-center py-3">© Copyright 2020:
		<a href="https://sulab.uncc.edu/zhengchang-su-phd"> Sulab at UNC at Charoltte</a>
		</div>
		<!-- Copyright -->
	</footer>
</body>

</html> 
