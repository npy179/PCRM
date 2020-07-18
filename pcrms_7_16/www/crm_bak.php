<?php //require_once("connection.php"); ?>


<?php include("pagination.php");?>
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
  <title>PCRMs</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script type="text/javascript" src="https://www.ncbi.nlm.nih.gov/projects/sviewer/js/sviewer.js"></script>
 <link rel="stylesheet" type="text/css" href="http://www.ncbi.nlm.nih.gov/projects/sviewer/css/sv-cleanup.css">
</head>





<body>

	<nav class="navbar py-0 navbar-expand-sm bg-light">
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
		<li class="nav-item">
			<a class="nav-link" href="detailed_search.php"><i class="fa fa-search" style="font-size:20px"></i>Detailed Search</a>
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
		if(isset($_GET['crmId']) && isset($_GET['genome_id'])){
			$crmId = $_GET['crmId'];
			$genome_id = $_GET['genome_id'];


			/*
			$crm_query = "SELECT crms.Id, crms.Chromosome AS crmsChromosome, crms.Start_Pos AS crms_Start_Pos, crms.End_Pos AS crms_End_Pos, 
				genes.Chromosome AS genes_Chromosome, genes.Start_Pos AS genes_Start_Pos, genes.End_Pos AS genes_End_Pos, genes.Strand, genes.Symbol FROM crms INNER JOIN genes ON crms.Bracketing_Gene=genes.Id WHERE crms.Genome={$genome_id} AND crms.Id=\"{$crmId}\";";
			*/

			//print_r($crmId);
			//print_r($genome_id);
			//$crm_query  = "SELECT tfbss.TFBS_Start, tfbss.TFBS_End, tfbss.umID FROM tfbss WHERE crmID={$crmId}";

			//$crm_query  = 'SELECT Chromosome, Start_Pos, End_Pos FROM crms WHERE crmID={$crmId} AND Genome={$genome_id}';
			
			
			$crm_query  = "SELECT crms.crmID, crms.Chromosome, crms.Start_Pos, crms.End_Pos, crms.Score, crms.P_value, crms.Distance, genes.Symbol, genes.Start_Pos AS geneStart, 
			genes.End_Pos AS geneEnd FROM crms
			INNER JOIN crms_genes_association ON crms.crmID=crms_genes_association.crmID
			INNER JOIN genes ON crms_genes_association.geneID=genes.geneID
			WHERE crms.crmID=\"{$crmId}\"";



			//echo $crm_query;


			//$crm_query_result = mysqli_query($connection, $crm_query);

			$crm_query_result = $mysqli->query($crm_query);
			$row = $crm_query_result->fetch_assoc();
			//$row = mysqli_fetch_assoc($crm_query_result);
			//print_r($row);

			$pos_array = [$row['Start_Pos'],$row['End_Pos'],$row['geneStart'],$row['geneEnd']];
			$mk_set=$row['Start_Pos'].":".$row['End_Pos']."|".$row['crmID']."|"."#8B0000";

			$gene_start = $row['geneStart'];
			$gene_end = $row['geneEnd'];
			$gene_len = $gene_end-$gene_start;

			
			$crm_len = $row['End_Pos'] - $row['Start_Pos'];

			if($crm_len > $gene_len){
				$padding = 2*$crm_len;
			}else{
				$padding = 2*$gene_len;
			}

			$g_start = min($pos_array) - $padding;
			$g_end = max($pos_array) + $padding; 
			$g_view = "$g_start:$g_end";

			
			$chrome = $row['Chromosome'];

			$chrom_query = "SELECT ncbiName FROM chromosomes WHERE genomeID={$genome_id} AND chromosomeName=\"{$chrome}\";";

			$chrom_query_result = $mysqli->query($chrom_query);
			$chrom_query_result_row = $chrom_query_result->fetch_assoc();
			$ncbi_chrom = $chrom_query_result_row['ncbiName'];

			//print_r("hello:".$ncbi_chrom);

		}
	?>

	<div class="jumbotron py-6 bg-info mb-1 jumbotron-fluid py-3"></div>
	<div id="container-fluid">
		<div class="row px-2">
			<div class="col-3 pr-1">

				<div class="row">
					<div class="col">
					<div class="card">
					<div class="card-header text-primary">
						<h5>CRM ID: <a href=tfbs.php?crmId=<?=$crmId?>&chrome=<?=$chrome?>&genome_id=<?=$genome_id?>><?= $crmId?> </a></h5>
					</div>
					<div class="card-body">
						<h5 class="card-title">Infomation:</h5>
						<p class="card-text">
						<ul>
							<li>CRM coordinate:<?php
								echo "{$chrome}:${row['Start_Pos']}-${row['End_Pos']}";	
							?></li>
							<li>CRM score:<?= $row['Score']?></li>
							<!-- <li>Distance to closest TSS: <?= $row['Distance']?> bp(s)</li> -->
							<li>CRM p value:<?= $row['P_value']?></li>
							<li>Bracketing gene(s): <?= $row['Symbol']?></li>
						</ul>
					
						</p>
					</div>
				</div>
					
					
					
					</div>
				
				</div>

			</div>

			<div class="col-9">
				<div id="mySeqViewer1" class="SeqViewerApp" data-autoload>
    			 <a href="?embedded=true&amp;appname=pcrmsv4&amp;id=<?=$ncbi_chrom?>&amp;v=<?=$g_view?>&amp;mk=<?=$mk_set?>"></a>
	  			 </div>	
			</div>
		</div>
	</div>


</body>
</html>