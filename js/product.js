$("#frm :input").change(function () {
	$("#frm").data("changed", true);
});
function addUser() {
	var name = $('#name').val();
	var password = $('#password').val();
	var email = $('#email').val();
	var birthdate = $('#birthdate').val();
	if (!validateData(name, password, email, birthdate))
		return false;
	$.ajax({
		url: "add_product.php",
		type: "POST",
		data: { name, password, email, birthdate },
		dataType: "text",
		success: function (response) {
			$("#usuarios").html(response);
		}
	});
}


function updateUser() {
	var id = $('#id').val();
	var name = $('#name').val();
	var password = $('#password').val();
	var email = $('#email').val();
	var birthdate = $('#birthdate').val();

	if (!validateData(name, password, email, birthdate))
		return false;
	if ($("#frm").data("changed")) {
		$.ajax({
			url: "update_product.php",
			type: "POST",
			data: { id, name, password, email, birthdate },
			dataType: "text",
			success: function (response) {
				clearValues();
				window.location.href = "index.php";
			}
		});
	}
	else {
		alert("No cambios para guardar");
		return false;
	}
}

function delUser(id, name) {
	if (confirm("Seguro que quieres eliminar el usuario - " + name + "?")) {
		$.ajax({
			url: "delete_product.php",
			type: "POST",
			data: { id },
			dataType: "text",
			success: function (response) {
				$("#usuarios").html(response);
			}
		});
	}
}
function validateData(name, password, email, birthdate) {
	if (name.trim() == "") {
		$("#user_err").text("El nombre del usuario no puede estar vacío");
		return false;
	}

	if (password.trim() == "") {
		$("#password_err").text("La contraseña no puede estar vacía");
		return false;
	}

	if (email.trim() == "") {
		$("#email_err").text("El email no puede estar vacío");
		return false;
	}

	if (birthdate.trim() == "") {
		$("#birthdate_err").text("La fecha de nacimiento no puede estar vacía");
		return false;
	}
	return true;
}

function clearValues() {
	$("#id").val("");
	$("#name").val("");
	$("#password").val("");
	$("#email").val("");
	$("#birthdate").val("");
	$("#user_err").html("");
	$("#password_err").html("");
	$("#email_err").html("");
	$("#birthdate_err").html("");
}
