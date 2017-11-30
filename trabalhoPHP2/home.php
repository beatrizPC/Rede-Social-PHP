<?php
	require_once "bancodedados.php";
	session_start();
		
	if(isset($_SESSION['usuario'])&& !isset($_GET['uid'] ))
	{
		$u = $_SESSION['usuario'];
	}
	else if(isset($_SESSION['usuario'])&& isset($_GET['uid'] ))
	{
		$u = bd_obter_usuario_por_id( $con, $_GET['uid'] );
		if(!$u) {
			header('Location: erro.php');
			die();
		}
	}
	else if(!isset($_SESSION['usuario'])&& isset($_GET['uid'] ))
	{
		$u = bd_obter_usuario_por_id( $con, $_GET['uid'] );
		if(!$u) {
			header('Location: erro.php');
			die();
		}
	}
	else
	{
		header('location:erro.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="css/home.css"/>
		<link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet">
	</head>
	<body>
		<div class="fotos">
		<div class="ftPerfil">
			<img class="perfil" src= <?php echo '"dados/'.$u['apelido'].'/perfil.jpg"'?>/>
		</div>
		<div class="ftFundo">
			<img class="fundo" src= <?php echo '"dados/'.$u['apelido'].'/fundo.jpg"'?>/>
		</div>
			<button class="cad"><a href="logout.php">Sair</a></button>
		</div>
	
		<div class="sobre">
					<h1>Sobre</h1> <br/>
				<label> <?php echo $u['nome']; ?> </label> 
				<label> <?php echo $u['sobrenome']; ?> </label> <br/>
				<label> Sexo: <?php echo $u['sexo'];	?>	</label><br/>
				<label> <?php echo $u['email']; ?> </label>
		</div>
			<?php 
				if(isset($_SESSION['usuario']) && isset($_GET['uid'] ))
				{ 
					if(!bd_verificar_amizade_existe( $con, $_SESSION['usuario'],[ 'id' => $_GET['uid'] ])){
			?>
			<form action="funcaoadd.php" method="get">
				<input type="submit" value="Adicionar" name="add" class="cad1"/></br></br>
				<input type="hidden" name="uid" value=<?php echo '"'.$_GET['uid'].'"';?>/>
			</form>	

			<?php 
				}
				else{
					echo "Esse contato já está na sua lista de amigos";
				}
			?>
			<?php 
				}
				
				if(isset($_SESSION['usuario']))
				{
					//if( isset( $_GET[ 'uid' ] ) )
					//	$u = bd_obter_usuario_por_id( $con, $_GET['uid'] );
					//else
					//	$u = $_SESSION[ 'usuario' ];
					//var_dump( $_SESSION['usuario'] );
					$amigos=bd_obter_amigos_usuario( $con, $u );
			?>
			
				<h2>Amigos</h2>
				
			<?php 
				foreach ($amigos as $amigo)
				{
			?>
			
			<div class="amigo">
			<?php echo $amigo['nome'];?>
			<div class="ftmigo">
				<img class="ftamigo" src="./dados/<?php echo $amigo['apelido'] ?>/perfil.jpg"/>
			</div>
			</div>
	</div>
	</div>
			<?php
				}
				}
			?>
		</ul>
	</body>
</html>