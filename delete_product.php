<?php
include "cfg/dbconnect.php";
$delete_id = $_POST['id'];
$sql = "delete from usuarios where id='$delete_id'";
$result = mysqli_query($conn, $sql);
if ($result)
	$succ_msg = "Usuario eliminado correctamente";
else
	$err_msg = "Error: No se pudo eliminar el usuario";
?>
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
	<?php	$select = "select * from usuarios order by id";
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
				<td><?php echo $user['birthdate']; ?></td>				<td>
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
<script>
	<?php if (!empty($succ_msg)) { ?>
		$('#showMsg').html("<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button><?= $succ_msg; ?></div>");
		clearValues();
	<?php }
	if (!empty($err_msg)) { ?>
		$('#showMsg').html("<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button><?= $err_msg; ?></span");
	<?php } ?>
</script>