<?php
require 'PHPMailer/PHPMailerAutoload.php';

	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	    $_POST = [];
	}

	if($_SERVER['REQUEST_METHOD'] === 'POST' AND $_POST['type'] == 'SENDMAIL'){

		$mail = new PHPMailer;
		$mail->isSMTP();                                   // Setando protocolo STMP
		$mail->Host = 'smtp.gmail.com';                    // Servidor SMTP
		$mail->SMTPAuth = true;                            // Autenticacao SMTP TRUE
		$mail->Username = 'saimpluss@gmail.com';           // Email de origem 
		$mail->Password = 'daniel321'; // Senha do Email de Origen
		$mail->SMTPSecure = 'tls';                         // Encriptacao TlS, `ssl` tambem permitido
		$mail->Port = 587;                                 // Porta TCP utilizada (SMTP)
		$mail->setFrom('someothermail@gmail.com', 'Site - Contact');
		$mail->addReplyTo('someothermail@gmail.com', 'Site - Contact');
		$mail->addAddress('vitorvqz@gmail.com'); // Email que recebera as mensagens
		$mail->isHTML(true);  // Conteudo formatado em HTML
		$bodyContent = '<h1>Email - Localhost</h1>';
		$bodyContent .= '<p>This is the HTML email sent from localhost using PHP </p>';
		$mail->Subject = 'Test';
		$mail->Body    = $bodyContent;
		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent';
		    exit();
		}
	}

	if($_SERVER['REQUEST_METHOD'] === 'POST' AND $_POST['type'] == 'VALIDACAO'){

		echo "PQP";
		exit();
	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<title>Teste</title>
	<style>
		
		.green{
			color: green;
		}

		.red{
			color: red;
		}

		#btnEmail{
			margin-top: 20px;
		}

		#validacaoDownload{
			margin-top: 20px;
		}

		.rowEmail{
			clear: both;
		}

	</style>
</head>
<body class="container">
	<div>
		<h1>Que tal baixar meu último E-book?</h1>	
		<h5>Esperamos que goste do conteúdo. Ele foi feito com muito carinho!</h5>		
	</div>

		<form>			
			<div class="form-group">
				<input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Endereço de Email">
				<small id="emailHelp" class="form-text text-muted">*Prometemos não utilizar suas informações de contato para enviar qualquer tipo de SPAM</small>
			</div>

			<div>
				<span id="msgs"></span>
			</div>

			<div id="validacaoDownload">
				
			</div>

			<div class="rowEmail">				
				<button type="button" class="btn btn-primary" id="btnEmail">Baixar Livro</button>				
			</div>

		
		</form>


</body>
</html>

<script type="text/javascript">
	function isEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}

	$('#btnEmail').click(function(){
		var email = $('#email').val();

		if(isEmail(email)){
			$('#btnEmail').html('<i class="fa fa-spinner fa-spin" style="font-size:14px"></i>');
			$('#btnEmail').removeClass('btn-primary');
			$('#btnEmail').addClass('btn-default');

			var postMail = [];
	        postMail.push({name: 'type', value: 'SENDMAIL'});

			 $.ajax({
		        url: "iluminar.php",
		        type: "post",
		        data: postMail,
		        success: function (response) {
    				$('#msgs').html("<i class='fa fa-check'></i> Um codigo foi enviado para você. Informe-o para iniciar o download!");
					$('#msgs').removeClass("red");
					$('#msgs').addClass("green");
					$('#btnEmail').removeClass('btn-default');
					$('#btnEmail').addClass('btn-success');
					$('#btnEmail').attr('disabled','true');
					$('#btnEmail').text('Baixar Livro');

					htmlValida = '<div class="form-group col-xs-2">'+
									'<input type="text" class="form-control" id="cdgValidacao" aria-describedby="cdgValidacao" placeholder="Código">'+
								'</div>'+
								'<button type="button" class="btn btn-default" id="btnValidacao"> Validar Código </button>';

					$("#validacaoDownload").append(htmlValida);

		        	console.log(response);                 

		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		           console.log(textStatus, errorThrown);
		        }

		    });
		}else{
			console.log("errado");
			$('#msgs').html("<i class='fa fa-times'></i> Endereço de email invalido!");
			$('#msgs').removeClass("green");
			$('#msgs').addClass("red");
		}
	});

	$(document).on('click','#btnValidacao',function(){
		var cdgValidacao = $('#cdgValidacao').val();

		var postCdg = [];
		postCdg.push({name: 'codigo', value: cdgValidacao});
        postCdg.push({name: 'type', value: 'VALIDACAO'});

 		$.ajax({
	        url: "iluminar.php",
	        type: "post",
	        data: postCdg,
	        success: function (response) {
	        	console.log(response);    
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	           console.log(textStatus, errorThrown);
	        }

	    });

	});

</script>