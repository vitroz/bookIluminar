<?php
require 'PHPMailer/PHPMailerAutoload.php';

header('Content-Type: text/html; charset=utf-8');

	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	    $_POST = [];
	}

	$cdgs_array = ['850834','713684','259207','553831','936959','553875',
					'327596','416868','683902','941604','886568','189475',
					'749622','674729','873147','375941','703183','116903',
					'974555','518039','956587','710721','487711','520914',
					'593425','564442','599946','231398','823371','794700',
					'781691','176358','419039','874843','491769','312736',
					'193628','966934','225368','822239','879191','546938',
					'512425','393420','698722','968507','168938','579869',
					'898881','548826','614690','834835','886050','146138',
					'170779','152351','327362','559130','330367','740324',
					'615115','896257','795392','423394','693732','911633',
					'279522','776777','542761','618106','659442','368557',
					'592320','123468','173157','615861','975916','602272',
					'139497','760514','745805','153123','736000','568882',
					'312361','811464','933674','320738','157261','184735',
					'975168','721042','181552','827955','132795','680536',
					'964797','700887','889464','825281'];

	function gera_codigo($cdgs_array){

		$random_number = $cdgs_array[array_rand($cdgs_array)];

		return $random_number;		
	}

	if($_SERVER['REQUEST_METHOD'] === 'POST' AND $_POST['type'] == 'SENDMAIL'){

		$emailUser = $_POST['emailUser'];

		$mail = new PHPMailer;
		$mail->isSMTP();                                   // Setando protocolo STMP
		$mail->Host = 'smtp.gmail.com';                    // Servidor SMTP
		$mail->SMTPAuth = true;                            // Autenticacao SMTP TRUE
		$mail->Username = 'saimpluss@gmail.com';           // Email de origem 
		$mail->Password = 'daniel321'; // Senha do Email de Origen
		$mail->SMTPSecure = 'tls';                         // Encriptacao TlS, `ssl` tambem permitido
		$mail->Port = 587;                                 // Porta TCP utilizada (SMTP)
		$mail->setFrom('someothermail@gmail.com', 'Instituto Iluminar');
		$mail->addReplyTo('someothermail@gmail.com', 'Instituto Iluminar');
		$mail->addAddress($emailUser); // Email que recebera as mensagens
		$mail->isHTML(true);  // Conteudo formatado em HTML

		$codigo = gera_codigo($cdgs_array);

		$bodyContent = '<h1>Para efetuar o download do livro copie o codigo abaixo e cole-o na pagina de download.</h1>';
		$bodyContent .= '<p>Código:<h1>'.$codigo.'</h1></p>';
		$mail->Subject = '=?UTF-8?B?'.base64_encode('Instituto Iluminar - Código de Verificação').'?=';
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

		$cdgUser = $_POST['codigo'];

		if (in_array($cdgUser, $cdgs_array)) {
		    echo "CDG_SUC";
		    exit();
		}else{
			echo "CDG_ERR";
		    exit();
		}

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
				<button type="button" class="btn btn-primary" id="btnEmail"><b>Enviar código e baixar E-book</b></button>				
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
	        postMail.push({name: 'emailUser', value: email});

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
								'<button type="button" class="btn btn-default" id="btnValidacao"> Validar Código </button>'+
								'<button type="button" class="btn btn-default" id="btnCheck"></button>';

					$("#validacaoDownload").append(htmlValida);

		        	console.log(response);                 

		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		           console.log(textStatus, errorThrown);
		        }

		    });
		}else{
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

        $('#btnCheck').html('<i class="fa fa-spinner fa-spin" style="font-size:14px"></i>');

 		$.ajax({
	        url: "iluminar.php",
	        type: "post",
	        data: postCdg,
	        success: function (response) {
	        	if(response == 'CDG_SUC'){
	        		$('#btnCheck').removeClass();
					$('#btnCheck').addClass('btn-success');
					$('#btnCheck').html("<i class='fa fa-check'></i>");
    				$('#msgs').html("<i class='fa fa-check'></i> Obrigado! O seu download está disponivel agora.");
					$('#validacaoDownload').fadeOut(1000);

	        	}else{
	        		$('#btnCheck').removeClass();
					$('#btnCheck').addClass('btn-danger');
					$('#btnCheck').html("<i class='fa fa-times'></i>");

	        	}    
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	           console.log(textStatus, errorThrown);
	        }

	    });

	});

</script>