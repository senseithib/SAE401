<?php

$page = "account";
include_once("www/IT/headerIT.php");

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    $(document).ready(function() {
        let id=<?php echo $_SESSION['AccountEmployee']["id"]; ?>;
        // Load user information
        $.ajax({
            url: "https://sae401thibault.alwaysdata.net/api/api.php?actionGet=employee&id="+id+"&KEY=e8f1997c763",

            type: "GET",
            dataType: "json",
            success: function(data) {
                if (data && data.length > 0) {
                    var user = data[0];
                    $("#username").val(user.employee_name);
                    $("#email").val(user.employee_email);
                    $("#password").val(user.employee_password);
                } else {
                    alert("No user found.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error while retrieving user information:", error);
                console.log(xhr.responseText);
                alert("Error while retrieving user information.");
            }
        });

        let modif=document.getElementById("btn-modif");
        if(modif){
            modif.addEventListener("click", function() {
                $.ajax({
                    url: `https://sae401thibault.alwaysdata.net/api/api.php?actionPut=udapteConnexE&id=${id}&name=${$("#username").val()}&email=${$("#email").val()}&password=${$("#password").val()}&KEY=e8f1997c763`,
                    type: "PUT",
                  
                    success: function(response) {
                        if(response.error){
                            alert("Error while updating information.");
                        }else{
                            alert("Information updated successfully.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error while updating information:", error);
                        console.log(xhr.responseText);
                        alert("Error while updating information.");
                    }
                })

            });

        }
        
        
        });
</script>
<div class="card shadow p-4">
        <h2 class="text-center mb-4">My Account</h2>
        <form method="POST" class="form row g-3">
            <div class="col-md-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="d-flex justify-content-center mt-4">
                <button type="button" id="btn-modif" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</main>
<?php include_once("www/footer.php");?>