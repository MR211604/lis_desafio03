<!DOCTYPE html>
<html lang="en">

<head>
	<title>LIS desafio 3</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="all" />

	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<div class="container">
		<h2>CRUD de usuarios usando Ajax</h2>
		<div id="showMsg"></div>
		<?php
		session_start();
		include "cfg/dbconnect.php";
		$user_id = $id = $name = $password = $email = $birthdate = $flag = "";
		$user_found = false;

		// Mostrar mensajes de sesión si existen
		if (isset($_SESSION['succ_msg'])) {
			echo "<script>
					$(document).ready(function() {
						$('#showMsg').html(\"<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button>{$_SESSION['succ_msg']}</div>\");
					});
				</script>";
			unset($_SESSION['succ_msg']);
		}

		if (isset($_SESSION['err_msg'])) {
			echo "<script>
					$(document).ready(function() {
						$('#showMsg').html(\"<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button>{$_SESSION['err_msg']}</div>\");
					});
				</script>";
			unset($_SESSION['err_msg']);
		}

		if (isset($_REQUEST['flag']) && $_REQUEST['flag'] == 'edit') {
			$flag = $_REQUEST['flag'];
			if (isset($_REQUEST['id'])) {
				$id = $_REQUEST['id'];
				$sql = "select * from usuarios where id='$id'";
				$rs = mysqli_query($conn, $sql);
				if (mysqli_num_rows($rs) > 0) {
					$user_found = true;
					$row = mysqli_fetch_array($rs);
					$name = $row['name'];
					$password = $row['password'];
					$email = $row['email'];
					$birthdate = $row['birthdate'];
				}
			}
		}
		?>
		<div class="row">
			<div class="col-md-8">
				<h4>Lista de usuarios</h4>
				<div class="table-responsive" id="usuarios">
					<table class="table table-bordered table-striped">
						<tr>
							<thead>
								<th>ID</th>
								<th>Nombre Completo</th>
								<th>Contraseña</th>
								<th>Correo</th>
								<th>Fecha de nacimiento</th>
								<th>Acción</th>
							</thead>
						</tr>
						<?php						$select = "select * from usuarios order by id";
						$usuarios = mysqli_query($conn, $select);
						$counter = 0;
						if (mysqli_num_rows($usuarios) > 0) {
							foreach ($usuarios as $user) {
								$counter++;
								$user_id = $user['id'];
								$username = $user['name'];
						?>
								<tr>
									<td><?php echo $user['id']; ?></td>
									<td><?php echo $user['name']; ?></td>
									<td><?php echo $user['password']; ?></td>
									<td><?php echo $user['email']; ?></td>
									<td><?php echo $user['birthdate']; ?></td>									<td>
										<a class="fa fa-edit" title="Edit" href="index.php?id=<?php echo $user_id; ?>&flag=edit"></a> &nbsp;&nbsp;
										<a class="fa fa-remove" title="Delete" href="javascript:void(0)" onClick="delUser('<?php echo $user_id; ?>','<?php echo $username; ?>')"></a>
									</td>
								</tr>
							<?php }
						} else { ?>
							<tr>
								<td colspan="7">Ningun usuario encontrado</td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
			<?php if ($flag == "edit" && $user_found == true) {
			?>
				<div class="col-md-4">
					<h4>Actualizar usuario</h4>
					<form id="frm">
						<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
						<div class="form-group col-md-12">
							<label>Nombre</label>
							<input type="text" name="name" id="name" class="form-control" maxlength="255" value="<?php echo $name; ?>">
							<div class="error" id="user_err"></div>
						</div>
						<div class="form-group col-md-12">
							<label>Contraseña</label>
							<input type="password" name="password" id="password" class="form-control" maxlength="255" value="<?php echo $password; ?>">
							<div class="error" id="password_err"></div>
						</div>
						<div class="form-group col-md-12">
							<label>Correo</label>
							<input type="email" name="email" id="email" class="form-control" maxlength="255" value="<?php echo $email; ?>">
							<div class="error" id="email_err"></div>
						</div>
						<div class="form-group col-md-12">
							<label>Fecha de nacimiento</label>
							<input type="date" name="birthdate" id="birthdate" class="form-control" maxlength="255" value="<?php echo $birthdate; ?>">
							<div class="error" id="birthdate_err"></div>
						</div>
						<div class="col-md-12 text-right">
							<a href="index.php" class="btn btn-danger">Cancel</a>&nbsp;
							<input type="button" class="btn btn-primary" onclick="updateUser()" value="Save">
						</div>
					</form>
				</div>
			<?php } else {
			?>
				<div class="col-md-4">
					<h4>Agregar usuario</h4>
					<form id="frm">
						<div class="form-group col-md-12">
							<label>Nombre</label>
							<input type="text" name="name" id="name" class="form-control" maxlength="255" value="<?php echo $name; ?>">
							<div class="error" id="user_err"></div>
						</div>
						<div class="form-group col-md-12">
							<label>Contraseña</label>
							<input type="password" name="password" id="password" class="form-control" maxlength="255" value="<?php echo $password; ?>">
							<div class="error" id="password_err"></div>
						</div>
						<div class="form-group col-md-12">
							<label>Correo</label>
							<input type="email" name="email" id="email" class="form-control" maxlength="255" value="<?php echo $email; ?>">
							<div class="error" id="email_err"></div>
						</div>
						<div class="form-group col-md-12">
							<label>Fecha de nacimiento</label>
							<input type="date" name="birthdate" id="birthdate" class="form-control" maxlength="255" value="<?php echo $birthdate; ?>">
							<div class="error" id="birthdate_err"></div>
						</div>
						<div class="col-md-12 text-right">
							<input type="button" class="btn btn-primary" onclick="addUser()" value="Add">
						</div>
					</form>
				</div>
			<?php } ?>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="js/product.js"></script>
</body>

</html>