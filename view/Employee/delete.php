
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        let sup = "<?php echo $_GET['sup']; ?>";
        let id = "<?php echo $_GET['id']; ?>";

        if (sup == "produit") {

            $.ajax({
                url: `https://sae401thibault.alwaysdata.net/api/api.php?actionDelete=deleteProduct&id=${id}&KEY=e8f1997c763`,
                type: "DELETE",
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        alert("Deletion successful!");
                        window.location.href = "index.php?action=GestionE&click=produit";
                    } else {
                        alert("Error during deletion because there is still stock in the store!");

                        window.location.href = "index.php?action=GestionE&click=produit";
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error during deletion because there must still be stock in the store!");
                    window.location.href = "index.php?action=GestionE&click=produit";
                }
            });
        } else if (sup == "brand") {
            $.ajax({
                url: `https://sae401thibault.alwaysdata.net/api/api.php?actionDelete=deleteBrand&id=${id}&KEY=e8f1997c763`,
                type: "DELETE",
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        alert("Deletion successful!");
                        window.location.href = "index.php?action=GestionE&click=brand";
                    } else {
                        alert("Error during deletion because a product in the store belongs to this brand!");

                        window.location.href = "index.php?action=GestionE&click=brand";
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error during deletion because there must still be stock in the store!");
                    window.location.href = "index.php?action=GestionE&click=brand";
                }
            });
        } else if (sup == "category") {
            $.ajax({
                url: `https://sae401thibault.alwaysdata.net/api/api.php?actionDelete=deleteCategorie&id=${id}&KEY=e8f1997c763`,
                type: "DELETE",
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        alert("Deletion successful!");
                        window.location.href = "index.php?action=GestionE&click=category";
                    } else {
                        alert("Error during deletion because a product in the store belongs to this category!");

                        window.location.href = "index.php?action=GestionE&click=category";
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error during deletion because a product in the store belongs to this category!");
                    window.location.href = "index.php?action=GestionE&click=category";
                }
            });
        } else if (sup == "stock") {
            $.ajax({
                url: `https://sae401thibault.alwaysdata.net/api/api.php?actionDelete=deleteStock&id=${id}&KEY=e8f1997c763`,
                type: "DELETE",
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        alert("Deletion successful!");
                        window.location.href = "index.php?action=GestionE&click=stock";
                    } else {
                        alert("Error during deletion.");

                        window.location.href = "index.php?action=GestionE&click=stock";
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error during deletion.");
                    window.location.href = "index.php?action=GestionE&click=stock";
                }
            });
        } else if (sup == "store") {
            $.ajax({
                url: `https://sae401thibault.alwaysdata.net/api/api.php?actionDelete=deleteStore&id=${id}&KEY=e8f1997c763`,
                type: "DELETE",
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        alert("Deletion successful!");
                        window.location.href = "index.php?action=GestionE&click=store";
                    } else {
                        alert("Error during deletion because there is still stock and employees in the store!");

                        window.location.href = "index.php?action=GestionE&click=store";
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error during deletion because there is still stock and employees in the store!");
                    window.location.href = "index.php?action=GestionE&click=store";
                }
            });
        }
    });
</script>