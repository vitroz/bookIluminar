<!DOCTYPE html>
<html>
<head>
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

	</style>
</head>
<body class="container">
	<div>
		<h1>Que tal baixar meu último E-book?</h1>	
		<h5>Esperamos que goste do conteúdo. Ele foi feito com muito carinho!</h5>		
	</div>

	<div>
		<div class="form-group">
			<input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="email">
			<small id="emailHelp" class="form-text text-muted">*Prometemos não utilizar suas informações de contato para enviar qualquer tipo de SPAM</small>
		</div>

		<div>
			<span id="msgs"></span>
		</div>

		<input type="button" class="btn btn-primary" id="btnEmail" value="Adquirir Livro">

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
			console.log("certo");
			$('#msgs').html("<i class='fa fa-check'></i> Endereço de email valido!");
			$('#msgs').removeClass("red");
			$('#msgs').addClass("green");
		}else{
			console.log("errado");
			$('#msgs').html("<i class='fa fa-times'></i> Endereço de email invalido!");
			$('#msgs').removeClass("green");
			$('#msgs').addClass("red");
		}
	});
</script>