<?php 
    $host = "localhost";
    $user = "drsulab";
    $pass = "drsulab";
    $db = "PCRMSV4";
    $mysqli = new mysqli($host, $user, $pass, $db);

?>

<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>TFBSs</title>
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

	<div class="sticky-top">
		<div class="jumbotron py-6 bg-info mb-1 jumbotron-fluid"></div>
	</div>
	
	
	<?php
	

        if(isset($_POST['genome_id']) && isset($_POST['tf_id']) && isset($_POST['chr_id'])){
            $genome_id = $_POST['genome_id'];
			$tf_id = $_POST['tf_id'];
			$chr_id = $_POST['chr_id'];
			
			$_SESSION['back_genome_id'] = $genome_id;
			$_SESSION['back_tf_id'] = $tf_id;
			$_SESSION['back_chr_id'] = $chr_id;
			
            
        }else{
			$genome_id = $_SESSION['back_genome_id'];
			$tf_id = $_SESSION['back_tf_id'];
			$chr_id = $_SESSION['back_chr_id'];
			
		}

		$tf_sql  = "SELECT c.crmID, c.Chromosome, t.TFBS_Start, t.TFBS_End, t.umID, t.Binding_Score, u.tfID, u.Genome FROM tfbss t,
			umotif_tfs_association u, crms c WHERE (u.Genome = {$genome_id} AND c.Genome = {$genome_id} AND c.Chromosome IN ('".implode("','",$chr_id)."')) 
			AND t.umID = u.umID AND c.crmID = t.crmID AND u.tfID LIKE \"%{$tf_id}%\"";
		

		$rs = $mysqli->query($tf_sql);
    ?>

	<div class="container">
		<div class="row">
			<div class="col">
				<div class="card border-dark p-2">
					<div class="row">
						<div class="col">
							<form action="/get_tf.php" method="POST">
								<div class="form-row align-items-top">
									<div class="col-3">
										<div class="form-group">
											<label for="genome_id">Select a specie:</label>
											<select name="genome_id" class="form-control" id="genome_id">
												<option disabled selected>Select species</option>
												<option value="1">Homo sapiens</option>
												<option value="2">Mus musculus</option>
												<option value="3">Caenorhabditis elegans</option>
											</select>
										</div>
									</div>
									<div class="col-4">
										<div class="form-group">
											<label for="tf_id">Input TF:</label>
											<input type="text" class="form-control" name="tf_id" id="tf_id" value='RUNX1..'>
										</div>
									</div>

									<div class="col-4">
										<div class="form-group">
											<label for="chr_id">Select chromosomes:</label>
											<select multiple class="custom-select" name="chr_id[]" id="chr_id">
												<option disabled selected>Select chromosome</option>
											</select>
										</div>
									</div>

									<div class="col-1 mt-4 pt-2">
										<button class="btn btn-primary" type="submit">Search</button>
									</div>
								</div>
                			</form>
						</div>
					</div>

				</div>
			</div>

		</div>

		<hr/>

		<div class="row">
			<div class="col">
				<table class="table table-striped table-hover table-sm" width="100%" id="tfs_table">
					<thead>
						<tr>
							<th scope="col">CRM ID</th>
							<th scope="col">Chromosome</th>
							<th scope="col">TFBS Start</th>
							<th scope="col">TFBS End</th>
							<th scope="col">Umotif ID</th>
							<th scope="col">Binding TF</th>
							<th scope="col">Binding Score</th>
							<th scope="col">Umotif logo</th>
						</tr>
					</thead>
					<tbody>
						<?php
							while($row = $rs->fetch_assoc()){
								echo "<tr>";
								echo "<td><a href=crm.php?crmId={$row['crmID']}&genome_id={$genome_id}>{$row['crmID']}</td>";
								echo "<td style=\"text-align:left\">{$row['Chromosome']}</td>";
								echo "<td>{$row['TFBS_Start']}</td>";
								echo "<td>{$row['TFBS_End']}</td>";
								echo "<td>{$row['umID']}</td>";
								echo "<td>{$row['tfID']}</td>";
								echo "<td>{$row['Binding_Score']}</td>";

								$img_path = "/motifs_version/{$row['Genome']}/{$row['umID']}.png";

								echo "<td><img src=\"{$img_path}\" alt=\"\" border=3 height=30 width=150></img></td>";
								echo "</tr>";
							}

						?>
					
					</tbody>

					<tfoot>
						<tr>
							<th scope="col">CRM ID</th>
							<th scope="col">Chromosome</th>
							<th scope="col">TFBS Start</th>
							<th scope="col">TFBS End</th>
							<th scope="col">Umotif ID</th>
							<th scope="col">Binding TF</th>
							<th scope="col">Binding Score</th>
							<th scope="col">Umotif logo</th>

						</tr>
					</tfoot>



				</table> 

			</div>


		</div>


	</div>
	
	<script src="dynamics_detail_search.js"></script>
	<script>
        $(document).ready(function() {
            var tableX = $('#tfs_table').DataTable( {
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
