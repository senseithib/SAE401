<?php
$header="Employee";
$page = "account";
include_once("www/Chef/headerEC.php");
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        const id = <?php echo $_SESSION['AccountEmployee']["id"]; ?>;
        const $form = $(".form");

        // Helper to create input fields
        function createInput(label, id, value = "", type = "text", required = true) {
            return `
                <div class="mb-3">
                    <label for="${id}" class="form-label">${label}</label>
                    <input type="${type}" id="${id}" name="${id}" class="form-control" value="${value}" ${required ? "required" : ""}>
                </div>
            `;
        }

        // Load user information and render form
        $.ajax({
            url: "https://sae401thibault.alwaysdata.net/api/api.php?actionGet=employee&id=" + id + "&KEY=e8f1997c763",
            type: "GET",
            dataType: "json",
            success: function(data) {
                if (data && data.length > 0) {
                    const user = data[0];
                    let formHtml = createInput("Username", "username", user.employee_name);
                    formHtml += createInput("Email", "email", user.employee_email, "email");
                    formHtml += createInput("Password", "password", user.employee_password, "password");
                    $form.html(formHtml);
                } else {
                    $form.html('<div class="alert alert-danger">No user found.</div>');
                }
            },
            error: function(xhr, status, error) {
                $form.html('<div class="alert alert-danger">Error while retrieving user information.</div>');
            }
        });

        // Handle update
        $(document).off("click", "#btn-modif").on("click", "#btn-modif", function(e) {
            e.preventDefault();
            $.ajax({
                url: `https://sae401thibault.alwaysdata.net/api/api.php?actionPut=udapteConnexE&id=${id}&name=${$("#username").val()}&email=${$("#email").val()}&password=${$("#password").val()}&KEY=e8f1997c763`,
                type: "PUT",
                success: function(response) {
                    if (response.error) {
                        $("#success").text("");
                        $("#error").text("Error while updating information.");
                    } else {
                        $("#error").text("");
                        $("#success").text("Information updated successfully.");
                    }
                },
                error: function() {
                    $("#success").text("");
                    $("#error").text("Error while updating information.");
                }
            });
        });
    });
</script>
<div class="card shadow p-4">
    <h2 class="text-center mb-4">My Account</h2>
    <form method="POST" class="form row g-3"></form>
    <div class="d-flex justify-content-center mt-4">
        <button type="button" id="btn-modif" class="btn btn-success">Update</button>
    </div>
    <p id="error" class="text-danger mt-3 text-center"></p>
    <p id="success" class="text-success mt-3 text-center"></p>
</div>
</main>
<?php include_once("www/footer.php");?>