<?php

$page = "insert";
include_once("www/Employee/headerE.php");
echo "<h1>Insert</h1>";
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(function() {
        const add = "<?php echo $_GET["add"] ?>";
        const $form = $(".form");

        // Helper to create input fields
        function createInput(label, id, type = "text", required = true, placeholder = "") {
            return `
                <div class="mb-3">
                    <label for="${id}" class="form-label">${label}</label>
                    <input type="${type}" id="${id}" name="${id}" class="form-control" ${required ? "required" : ""} placeholder="${placeholder}">
                </div>
            `;
        }

        // Helper to create select fields
        function createSelect(label, id, options = [], required = true) {
            let opts = options.map(opt => `<option value="${opt.value}">${opt.text}</option>`).join('');
            return `
                <div class="mb-3">
                    <label for="${id}" class="form-label">${label}</label>
                    <select id="${id}" name="${id}" class="form-select" ${required ? "required" : ""}>
                        <option value="" disabled selected>Select ${label.toLowerCase()}</option>
                        ${opts}
                    </select>
                </div>
            `;
        }

        // Clear and re-render form fields
        function resetForm(html) {
            $form.empty().append(html);
        }

        // Product
        if (add === "product") {
            let formHtml = createInput("Product Name", "product_name");
            formHtml += createSelect("Brand", "brand_id");
            formHtml += createSelect("Category", "category_id");
            formHtml += createInput("Product Price", "product_price", "number");
            formHtml += createInput("Model Year", "model_year", "number", false, );
            resetForm(formHtml);

            // Populate brands
            $.getJSON("https://sae401thibault.alwaysdata.net/api/api.php?actionGet=brands", function(data) {
                data.forEach(brand => {
                    $("#brand_id").append(`<option value="${brand.brand_id}">${brand.brand_name}</option>`);
                });
            });

            // Populate categories
            $.getJSON("https://sae401thibault.alwaysdata.net/api/api.php?actionGet=categories", function(data) {
                data.forEach(category => {
                    $("#category_id").append(`<option value="${category.category_id}">${category.category_name}</option>`);
                });
            });

            $("#submit").off("click").on("click", function(e) {
                e.preventDefault();
                $.ajax({
                    url: `https://sae401thibault.alwaysdata.net/api/api.php?actionPost=insertProduct&name=${$("#product_name").val()}&brand=${$("#brand_id").val()}&category=${$("#category_id").val()}&modelyear=${$("#model_year").val()}&listprice=${$("#product_price").val()}&KEY=e8f1997c763`,
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            $("#error").text("Error inserting product: " + response.error);
                            $("#success").text("");
                        } else {
                            $("#error").text("");
                            $("#success").text("Product inserted successfully!");
                            resetForm(formHtml);
                        }
                    },
                    error: function() {
                        $("#error").text("Error inserting product. Please try again.");
                        $("#success").text("");
                    }
                });
            });
        }

        // Brand
        else if (add === "brand") {
            let formHtml = createInput("Brand Name", "brand_name");
            resetForm(formHtml);

            $("#submit").off("click").on("click", function(e) {
                e.preventDefault();
                $.ajax({
                    url: `https://sae401thibault.alwaysdata.net/api/api.php?actionPost=insertBrand&name=${$("#brand_name").val()}&KEY=e8f1997c763`,
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            $("#error").text("Error inserting brand: " + response.error);
                            $("#success").text("");
                        } else {
                            $("#success").text("Brand inserted successfully!");
                            $("#error").text("");
                            resetForm(formHtml);
                        }
                    },
                    error: function() {
                        $("#error").text("Error inserting brand. Please try again.");
                        $("#success").text("");
                    }
                });
            });
        }

        // Category
        else if (add === "category") {
            let formHtml = createInput("Category Name", "category_name");
            resetForm(formHtml);

            $("#submit").off("click").on("click", function(e) {
                e.preventDefault();
                $.ajax({
                    url: `https://sae401thibault.alwaysdata.net/api/api.php?actionPost=insertCategorie&name=${$("#category_name").val()}&KEY=e8f1997c763`,
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            $("#error").text("Error inserting category: " + response.error);
                            $("#success").text("");
                        } else {
                            $("#success").text("Category inserted successfully!");
                            $("#error").text("");
                            resetForm(formHtml);
                        }
                    },
                    error: function() {
                        $("#error").text("Error inserting category. Please try again.");
                        $("#success").text("");
                    }
                });
            });
        }

        // Stock
        else if (add === "stock") {
            let formHtml = createSelect("Product", "product_id");
            formHtml += createSelect("Store", "store_id");
            formHtml += createInput("Stock Quantity", "stock_quantity", "number");
            resetForm(formHtml);

            // Populate products
            $.getJSON("https://sae401thibault.alwaysdata.net/api/api.php?actionGet=products", function(data) {
                data.forEach(product => {
                    $("#product_id").append(`<option value="${product.product_id}">${product.product_name}</option>`);
                });
            });

            // Populate store (only one for employee)
            $.getJSON("https://sae401thibault.alwaysdata.net/api/api.php?actionGet=store&id=<?php echo $_SESSION["StoreEmployee"] ?>", function(data) {
                data.forEach(store => {
                    $("#store_id").append(`<option value="${store.store_id}">${store.store_name}</option>`);
                });
            });

            $("#submit").off("click").on("click", function(e) {
                e.preventDefault();
                $.ajax({
                    url: `https://sae401thibault.alwaysdata.net/api/api.php?actionPost=insertStock&product=${$("#product_id").val()}&store=${$("#store_id").val()}&quantity=${$("#stock_quantity").val()}&KEY=e8f1997c763`,
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            $("#error").text("Error inserting stock: " + response.error);
                            $("#success").text("");
                        } else {
                            $("#error").text("");
                            $("#success").text("Stock inserted successfully!");
                            resetForm(formHtml);
                        }
                    },
                    error: function() {
                        $("#error").text("Error inserting stock. Please try again.");
                        $("#success").text("");
                    }
                });
            });
        }

        // Store
        else if (add === "store") {
            let formHtml = createInput("Store Name", "store_name");
            formHtml += createInput("Store Phone", "store_phone", "text", true, "8 number min");
            formHtml += createInput("Store Email", "store_email", "email");
            formHtml += createInput("Store Street", "store_street");
            formHtml += createInput("Store State", "store_state");
            formHtml += createInput("Store City", "store_city");
            formHtml += createInput("Store Zip", "store_zip");
            resetForm(formHtml);

            $("#submit").off("click").on("click", function(e) {
                e.preventDefault();
                $.ajax({
                    url: `https://sae401thibault.alwaysdata.net/api/api.php?actionPost=insertStore&name=${$("#store_name").val()}&phone=${$("#store_phone").val()}&email=${$("#store_email").val()}&street=${$("#store_street").val()}&state=${$("#store_state").val()}&city=${$("#store_city").val()}&zip=${$("#store_zip").val()}&KEY=e8f1997c763`,
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            $("#error").text("Error inserting store: " + response.error);
                            $("#success").text("");
                        } else {
                            $("#error").text("");
                            $("#success").text("Store inserted successfully!");
                            resetForm(formHtml);
                        }
                    },
                    error: function() {
                        $("#error").text("Error inserting store. Please try again.");
                        $("#success").text("");
                    }
                });
            });
        }
    });
</script>
<div class="card shadow p-4">
    <h2 class="text-center mb-4">Insert</h2>
    <div class="insertion">
        <form method="POST" class="form row g-3">
        </form>
        <div class="d-flex justify-content-center">
            <input type="submit" value="Insert" id="submit" class="btn btn-secondary mt-3">
        </div>
        <p id="error" class="text-danger mt-3 text-center"></p>
        <p id="success" class="text-success mt-3 text-center"></p>
    </div>
</div>
</main>
<?php include_once("www/footer.php");?>