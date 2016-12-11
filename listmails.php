<?php 
require 'config.php';

 function getEmails(){
	try{
		$db = getDB();
		$stmt = $db->prepare("SELECT * FROM emails"); 
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_OBJ); //User data
		return $data;
		exit();
		}catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	$emails = getEmails();

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
 	<title></title>
 </head>
 <body>

 	<table id="tableEmails" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Data de Cadastro (ANO-MES-DIA)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($emails as $email): ?>
            	<tr>
            		<td><?php echo $email->id ?></td>
            		<td><?php echo $email->email ?></td>
            		<td><?php echo $email->dtcadastro ?></td>
            	</tr>
            <?php endforeach;?>
        </tbody>
    </table>
 
 </body>
 </html>

 <script type="text/javascript">

	$('#tableEmails').DataTable();

 </script>