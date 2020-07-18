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
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<body>
    <nav class="navbar py-0 navbar-expand-sm bg-light fixed-top">
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
        session_start();    
        if(isset($_POST['genome_id']) && isset($_POST['chr_id']) && isset($_POST['p_value'])){
            $genome_id = $_POST['genome_id'];
            $chr_id = $_POST['chr_id'];
            $p_value = $_POST['p_value'];
            $_SESSION['back_genome_id'] = $genome_id;
            $_SESSION['back_chr_id'] = $chr_id;
            $_SESSION['back_p_value'] = $p_value;
            //print_r($chr_id);

        }else{
            $genome_id = $_SESSION['back_genome_id'];
            $chr_id = $_SESSION['back_chr_id'];
            $p_value = $_SESSION['back_p_value'];
        }
    ?>

    <div class="jumbotron py-6 bg-info mb-1 jumbotron-fluid"></div>

    <div class="container py-2 mt-2">

        <?php
            $crm_query  = "SELECT crmID, Chromosome, Start_Pos, End_Pos, Score, P_value, Genes_Symbol FROM crms_genes WHERE 
            Genome={$genome_id} AND Chromosome IN ('".implode("','",$chr_id)."') AND P_value<=\"{$p_value}\"";

            $rs = $mysqli->query($crm_query);

        ?>


        <div class="row">
            <div class="col">
                <div class="card border-dark p-2">
                    <div class="row">
                        <div class="col">
                        <form action="get_crms.php" method="POST">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="genome_id">Select species:</label>
                                            <select name="genome_id" class="form-control" id="genome_id">
                                                <option selected>Select species</option>
                                                <option value="1">Homo sapiens</option>
                                                <option value="2">Mus musculus</option>
                                                <option value="3">Caenorhabditis elegans</option>
                                            </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="chr_id">Select chromosome:</label>
                                        <select multiple class="custom-select" name="chr_id[]" id="chr_id">
                                            <option selected>Select chromosome</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
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
            <table class="display order-column compact" width="100%" id="crms_table">
                <thead>
                    <tr>
                        <th scope="col">CRM ID</th>
                        <th scope="col">CRM coordinates</th>
                        <th scope="col">Closest Gene</th>
                        <th scope="col">Score</th>
                        <th scope="col">P value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($row = $rs->fetch_assoc()){
                            echo "<tr>";
                            echo "<td><a href=crm.php?crmId={$row['crmID']}&genome_id={$genome_id}>{$row['crmID']}</td>";
                            echo "<td>{$row['Chromosome']}:{$row['Start_Pos']}-{$row['End_Pos']}</td>";
                            echo "<td style=\"word-wrap: break-word;min-width: 100px;max-width: 500px;\">{$row['Genes_Symbol']}</td>";
                            echo "<td>{$row['Score']}</td>";
                            echo "<td>{$row['P_value']}</td>";
                            echo "</tr>";
                        }

                    ?>
                
                </tbody>


                <tfoot>
                <tr>
                    <th scope="col">CRM ID</th>
                    <th scope="col">CRM coordinates</th>
                    <th scope="col">Closest Gene</th>
                    <th scope="col">Score</th>
                    <th scope="col">P value</th>

                </tr>
                </tfoot>
            </table>  
            </div>
        </div>

    </div>

    <script src="dynamics.js"></script>
    <script>
        $(document).ready(function(){

            $('#crms_table').dataTable({
                "lengthMenu": [[ 100, 200, 500, 1000, -1], [100, 200, 500, 1000, "All"]],
                "scrollY":        "1200px",
                "scrollCollapse": true,
                "dom": '<"wrapper"fltip>',
            });
        });   
    </script>

    
</body>
</html>
