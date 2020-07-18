<?php 
    $host = "localhost";
    $user = "drsulab";
    $pass = "drsulab";
    $db = "PCRMSV4";
    $mysqli = new mysqli($host, $user, $pass, $db);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>CRMs</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
	<nav class="navbar py-1 navbar-expand-sm bg-light fixed-top">
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
			<a class="dropdown-item" href="#">Search closest CRMs for genes</a>
			<a class="dropdown-item" href="#">Search CRMs in a range of genes</a>
			<a class="dropdown-item" href="#">Search TFBSs for transcriptional factor</a>
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

  	<div class="sticky-top">
		<div class="jumbotron py-6 bg-info mb-1 jumbotron-fluid"></div>
	</div>

	<?php
		session_start();   
        if(isset($_POST['genome_id']) && isset($_POST['gene_id']) && isset($_POST['p_value'])){
            $genome_id = $_POST['genome_id'];
			$gene_id = $_POST['gene_id'];
			$p_value = $_POST['p_value'];
			$location = $_POST['location'];
			$distance = $_POST['distance'];
			
			
			$_SESSION['back_genome_id'] = $genome_id;
			$_SESSION['back_gene_id'] = $gene_id;
			$_SESSION['back_p_value'] = $p_value;
			$_SESSION['back_location'] = $location;
			$_SESSION['back_distance'] = $distance;
			//echo "Yes";
        }else{
			$genome_id = $_SESSION['back_genome_id'];
			$gene_id = $_SESSION['back_gene_id'];
			$p_value = $_SESSION['back_p_value'];
			$location = $_SESSION['back_location'];
			$distance = $_SESSION['back_distance'];
			//echo "No";
		}

		if ($location == "upstream"){

			$crms_sql  = "SELECT crms.crmID, crms.Chromosome, crms.Start_Pos, crms.End_Pos, crms.Score, crms.P_value FROM crms, genes_ranges 
			WHERE (genes_ranges.Symbol LIKE \"{$gene_id}\" OR genes_ranges.geneID LIKE \"{$gene_id}\") AND 
			(genes_ranges.Genome = {$genome_id} AND genes_ranges.Genome = crms.Genome AND genes_ranges.Chromosome = crms.Chromosome) 
			AND (IF (genes_ranges.Strand=\"+\", crms.Start_Pos >= genes_ranges.Start_Pos_{$distance} AND 
			crms.Start_Pos <= genes_ranges.Start_Pos, crms.End_Pos >= genes_ranges.End_Pos AND 
			crms.End_Pos <= genes_ranges.End_Pos_{$distance})) AND crms.P_value <= {$p_value}";

		} elseif ($location == "downstream"){

			$crms_sql  = "SELECT crms.crmID, crms.Chromosome, crms.Start_Pos, crms.End_Pos, crms.Score,crms.P_value FROM crms, genes_ranges 
			WHERE (genes_ranges.Symbol LIKE \"{$gene_id}\" OR genes_ranges.geneID LIKE \"{$gene_id}\") AND 
			(genes_ranges.Genome = {$genome_id} AND genes_ranges.Genome = crms.Genome AND genes_ranges.Chromosome = crms.Chromosome) 
			AND (IF (genes_ranges.Strand=\"+\", crms.Start_Pos >= genes_ranges.End_Pos AND 
			crms.Start_Pos <= genes_ranges.End_Pos_{$distance}, crms.End_Pos >= genes_ranges.Start_Pos_${distance} AND 
			crms.End_Pos <= genes_ranges.Start_Pos)) AND crms.P_value <= {$p_value}";

		}else {

			$crms_sql  = "SELECT crms.crmID, crms.Chromosome, crms.Start_Pos, crms.End_Pos, crms.Score,crms.P_value FROM crms, genes_ranges 
			WHERE (genes_ranges.Symbol LIKE \"{$gene_id}\" OR genes_ranges.geneID LIKE \"{$gene_id}\") AND 
			(genes_ranges.Genome = {$genome_id} AND genes_ranges.Genome = crms.Genome AND genes_ranges.Chromosome = crms.Chromosome) 
			AND (crms.Start_Pos >= genes_ranges.Start_Pos_{$distance} AND crms.End_Pos <= genes_ranges.End_Pos_{$distance}) 
			AND crms.P_value <= {$p_value}";


		}

		$rs = $mysqli->query($crms_sql);
	?>  


	<div class="container">
		<div class="row">
			<div class="col">
				<div class="card border-dark py-2 px-4">
					<div class="row">
						<div class="col">							
							<form action="/get_crm_in_genes_range.php" method="POST">
								<div class="form-row align-items-start">
									<div class="col">
										<div class="form-group">
											<label for="genome_id">Select a specie:</label>
											<select class="form-control" name="genome_id" id="gene_genome_id">
												<option disable selected>Select a specie</option>
												<option value="1">Homo sapiens</option>
												<option value="2">Mus musculus</option>
												<option value="3">Caenorhabditis elegans</option>
											</select> 
										</div>                               
									</div>

									<div class="col">
										<div class="form-group">
											<label for="gene_id">Input a gene:</label>
											<input type="text" class="form-control" name="gene_id" id="gene_id" value="RUNX1..">
										</div>
									
									</div>

									<div class="col">
										<div class="form-group">
											<label for="p_value">Input a threshold of p value for CRMs:</label>
											<select class="custom-select" name="p_value" id="p_value">
												<option value="0.05">0.05</option>
												<option value="0.01">0.01</option>
												<option value="0.0000005">5e-06</option>
												<option value="0.0000001">1e-06</option>
											</select>
										</div>
									
									</div>
								
								</div>

								<div class="form-row align-items-baseline">
									<div class="col-6">
										<div class="form-group">

											<label for="location">Select the location of CRMs:</label>

											<div class="form-check-inline">
												<label class="form-check-label" for="radio1">
													<input type="radio" class="form-check-input" id="radio1" name="location" value="upstream"> Upstream
												</label>
											</div>

											<div class="form-check-inline">
												<label class="form-check-label" for="radio2">
													<input type="radio" class="form-check-input" id="radio2" name="location" value="downstream"> Downstream
												</label>
											</div>

											<div class="form-check-inline">
												<label class="form-check-label" for="radio3">
													<input type="radio" class="form-check-input" id="radio3" name="location" value="both"> Both
												</label>
											</div>

										</div>
									
									</div>
									
									<div class="col-4">
										<div class="form-group">

											<label for="distance">Range of the gene:</label>

											<div class="form-check-inline">
												<label class="form-check-label" for="radio4">
													<input type="radio" class="form-check-input" id="radio4" name="distance" value="50"> 0.5M
												</label>
											</div>

											<div class="form-check-inline">
												<label class="form-check-label" for="radio5">
													<input type="radio" class="form-check-input" id="radio5" name="distance" value="100"> 1M
												</label>
											</div>

											<div class="form-check-inline">
												<label class="form-check-label" for="radio6">
													<input type="radio" class="form-check-input" id="radio6" name="distance" value="200"> 2M
												</label>
											</div>

										</div>
									
									</div>
									<div class="col">
										<button type="submit" class="btn btn-primary">Search</button>                        
									</div>
								
								</div>
                
                			</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<hr/>
		

		<div class="row mt-4">
			<div class="col">
				<table class="table table-striped table-hover table-sm" width="100%" id="crms_table">
					<thead>
						<tr>
							<th scope="col">CRM ID</th>
							<th scope="col">Chromosome</th>
							<th scope="col">Start</th>
							<th scope="col">End</th>
							<th scope="col">Score</th>
							<th scope="col">P value</th>

						</tr>
					</thead>
					<tbody>
						<?php
							while($row = $rs->fetch_assoc()){
								echo "<tr>";
								echo "<td><a href=crm.php?crmId={$row['crmID']}&genome_id={$genome_id}>{$row['crmID']}</td>";
								echo "<td style=\"text-align:left\">{$row['Chromosome']}</td>";
								echo "<td>{$row['Start_Pos']}</td>";
								echo "<td>{$row['End_Pos']}</td>";
								echo "<td>{$row['Score']}</td>";
								echo "<td>{$row['P_value']}</td>";
								echo "</tr>";
							}

						?>					
					</tbody>


					<tfoot>
                	<tr>
						<th scope="col">CRM ID</th>
						<th scope="col">Chromosome</th>
						<th scope="col">Start</th>
						<th scope="col">End</th>
						<th scope="col">Score</th>
						<th scope="col">P value</th>

                	</tr>
               		</tfoot>

					   
				</table> 
			</div>
		</div>
	</div>

	<script>
        $(document).ready(function() {
            var tableX = $('#crms_table').DataTable( {
            dom: "<'row'<'col-4'l><'col-5'B><'col-2'f>>" + 
                "<'row'<'col-12'tr>>" + 
                "<'row'<'col-6'i><'col-6'p>>",
            "lengthMenu": [[ 100, 200, 500, 1000, -1], [100, 200, 500, 1000, "All"]],
            "scrollY":        "1200px",
            "scrollCollapse": true,

            buttons: [  'copy', 
                    'csv',
                    'excel', 
                    'colvis' ],
            select: true,

        } );

    // tableX.button(0).nodes().css({"background-color": "#0275d8"});
    // tableX.button(1).nodes().css({"background-color": "#0275d8"});
    // tableX.button(2).nodes().css({"background-color": "#0275d8"});
    // tableX.button(3).nodes().css({"background-color": "#0275d8"});

        } );   
	</script>
	
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
