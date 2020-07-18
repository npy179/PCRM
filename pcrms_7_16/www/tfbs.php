<?php session_start();?>
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

<body>

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
        if(isset($_GET['crmId']) && isset($_GET['chrome'])){
            $crmId = $_GET['crmId'];
            $_SESSION['crmID'] = $crmId;

            $chrome = $_GET['chrome'];
            $_SESSION['chrome'] = $chrome;


            $genome_id = $_GET['genome_id'];
            $_SESSION['genome_id'] = $genome_id;
        }else{
            $crmId = $_SESSION['crmID'];
            $chrome = $_SESSION['chrome'];
            $genome_id = $_SESSION['genome_id'];
        }
	?>


    <?php 
        //$tfbs_sql  = "SELECT TFBS_Start, TFBS_End, umID FROM tfbss WHERE crmID=\"{$crmId}\" ORDER BY TFBS_Start ASC";
        $tfbs_sql  = "SELECT tfbss.TFBS_Start, tfbss.TFBS_End, tfbss.umID, tfbss.Binding_Score, umotif_tfs_association_multiple.tfNames FROM tfbss INNER JOIN 
        umotif_tfs_association_multiple ON tfbss.umID=umotif_tfs_association_multiple.umID
        WHERE tfbss.crmID=\"{$crmId}\" AND umotif_tfs_association_multiple.Genome={$genome_id} ORDER BY tfbss.TFBS_Start";

        $rs = $mysqli->query($tfbs_sql);   
    ?>


    <div class="jumbotron py-6 bg-info mb-1 jumbotron-fluid"></div>

    <div class="container">
            <div class="row">
                <div class="col">
                    <table class="table table-striped table-hover table-sm" width="100%" id="tfbss_table">
                    <thead>
                        <tr>

                            <th scope="col">Chromosome</th>
							<th scope="col">TFBS Start</th>
							<th scope="col">TFBS End</th>
                            <th scope="col">Umotif ID</th>
                            <th scope="col">TF Binding Score</th>
                            <th scope="col">Umotif logo</th>
                            <th scope="col">Match TFs</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($tfbs_row = $rs->fetch_assoc()){
                            //foreach($tfbs_results->data as $tfbs_row){
                                echo "<tr>";
                                echo "<td style=\"text-align:left\" >{$chrome}</td>";
                                echo "<td>{$tfbs_row['TFBS_Start']}</td>";
                                echo "<td>{$tfbs_row['TFBS_End']}</td>";
                                //echo "<th><a data-toggle=\"popover-hover\" data-img=\"/motifs_version/{$genome_id}/{$tfbs_row['umID']}.png\" href=umotif.php?umID={$tfbs_row['umID']}&genome_id={$genome_id}>{$tfbs_row['umID']}</a></th>";
                                echo "<td>{$tfbs_row['umID']}</td>";
                                echo "<td>{$tfbs_row['Binding_Score']}</td>";
                                $img_path = "/motifs_version/{$genome_id}/{$tfbs_row['umID']}.png";
                                echo "<td><img src=\"{$img_path}\" alt=\"\" border=3 height=30 width=150></img></td>";
                                echo "<td style=\"word-wrap: break-word;min-width: 50px;max-width: 250px;\">{$tfbs_row['tfNames']}</td>";
                                echo "</tr>";
                            }

                        ?>
                    
                    </tbody>

                    <tfoot>
                        <tr>
                            <th scope="col">Chromosome</th>
							<th scope="col">TFBS Start</th>
							<th scope="col">TFBS End</th>
                            <th scope="col">Umotif ID</th>
                            <th scope="col">TF Binding Score</th>
                            <th scope="col">Umotif logo</th>
                            <th scope="col">Match TFs</th>
                        </tr>
                    </tfoot>


                </table>        
                
                </div>

                    
            </div>

    
    
    </div>

    <script>
        $(document).ready(function() {
            var tableX = $('#tfbss_table').DataTable( {
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

</body>
</html>