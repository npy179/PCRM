<?php require_once("connection.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PCRMs</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>

</style>
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
			<a class="nav-link active" href="browse_dataset.php"><i class="fa fa-list-alt" style="font-size:20px"></i>Browse Database</a>
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
			<a class="nav-link" href="download_data.php"><i class="fa fa-download" style="font-size:20px"></i>Download Data</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="https://sulab.uncc.edu/zhengchang-su-phd"><i class="fa fa-flask" style="font-size:20px"></i>Su Lab</a>
		</li>
		</ul>
    </nav>

    <?php
        $genome_id_query="SELECT genomeID, genomeName FROM genomes;";
        $genome_id_results=mysqli_query($connection, $genome_id_query);
    ?>

    <div class="jumbotron py-6 bg-info mb-1 jumbotron-fluid"></div>
    <div class="container py-0 mt-0">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Species</th>
                    <th>Number of CRMs</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($genome_id_results)){
                        $id = $row['genomeID'];
                        $Genome_Name = $row['genomeName'];
            
                        $number_crm_query = "SELECT COUNT(crmID) AS CRM_NUMBER FROM crms WHERE Genome={$id};";
            
                        $number_crm_results = mysqli_query($connection, $number_crm_query);
                        $number_row = mysqli_fetch_assoc($number_crm_results);
                        $number_crm = $number_row['CRM_NUMBER'];
                        $Genome_Name = str_replace("_", " ", $Genome_Name);
                        echo "<tr>";
                        echo "<th>{$Genome_Name}</th>";
                        echo "<th>{$number_crm}</th>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>

        <div class="row py-3">

            <div class="col">
                    <div class="card border-dark p-4">
                        <div class="row">
                            <div class="col">
                                <form action="/get_crms.php" method="POST">
                                    <div class="form-group">
                                        <label for="genome_id">Select a specie:</label>
                                        <select name="genome_id" class="form-control" id="genome_id">
                                        <option selected>Select a specie</option>
                                        <option value="1">Homo sapiens</option>
                                        <option value="2">Mus musculus</option>
                                        <option value="3">Caenorhabditis elegans</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="chr_id">Select chromosomes:</label>
                                        <select multiple class="custom-select" name="chr_id[]" id="chr_id">
                                            <option selected>Select chromosomes</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="p_value">Input p value threshold:</label>
                                        <select class="custom-select" name="p_value" id="p_value">
                                            <option selected>Select p value:</option>
                                            <option value="0.05">0.05</option>
                                            <option value="0.01">0.01</option>
                                            <option value="0.000005">5E10-6</option>
                                            <option value="0.000001">1E10-6</option>

                                        </select>
                                    </div>


                                    <button class="btn btn-primary" type="submit">Search</button>
                                </form>
   
                            </div>

                            <div class="col py-2">
                                <div class="card h-100">
                                    <div class="card-header bg-primary text-white">
                                        <h5>Quick Search</h5>
                                    </div>

                                    <div class="card-body">
                                        <p class="card-text">
                                        <ul>
                                            <li>Select species</li>
                                            <li>Select chromosome</li>
                                            <li>Input p value</li>
                                        </ul>                        
                                        </p>
                                    </div>
                                </div>
                            </div>


                                            
                        </div>
                    
                    
                    </div>

            </div>



        </div>    

    </div>
 
    <script src="dynamics.js"></script>

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