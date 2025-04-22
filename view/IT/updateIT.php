<?php

$page = "update";
include_once("www/IT/headerIT.php");
echo "<h1>Update</h1>";
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        const modif = "<?php echo $_GET["modif"] ?>";
        const id = "<?php echo $_GET["id"] ?>";
        const $form = $(".form");

        // Helper to create input fields
        function createInput(label, id, value = "", type = "text", required = true, placeholder = "") {
            return `
                <div class="mb-3">
                    <label for="${id}" class="form-label">${label}</label>
                    <input type="${type}" id="${id}" name="${id}" class="form-control" value="${value}" ${required ? "required" : ""} placeholder="${placeholder}">
                </div>
            `;
        }

        // Helper to create select fields
        function createSelect(label, id, options = [], selectedValue = "", required = true) {
            let opts = options.map(opt => `<option value="${opt.value}" ${opt.value == selectedValue ? "selected" : ""}>${opt.text}</option>`).join('');
            return `
                <div class="mb-3">
                    <label for="${id}" class="form-label">${label}</label>
                    <select id="${id}" name="${id}" class="form-select" ${required ? "required" : ""}>
                        ${opts}
                    </select>
                </div>
            `;
        }

        // PRODUCT
        if (modif === "produit") {
            $.getJSON("https://sae401thibault.alwaysdata.net/api/api.php?actionGet=product&id=" + id, function(data) {
                const product = data[0];
                let formHtml = createInput("Product Name", "product_name", product.product_name);
                formHtml += `<input type="hidden" id="product_id" name="product_id" value="${product.product_id}">`;

                // Get brands and categories in parallel
                $.when(
                    $.getJSON("https://sae401thibault.alwaysdata.net/api/api.php?actionGet=brands"),
                    $.getJSON("https://sae401thibault.alwaysdata.net/api/api.php?actionGet=categories")
                ).done(function(brandsData, categoriesData) {
                    let brands = brandsData[0].map(b => ({ value: b.brand_id, text: b.brand_name }));
                    let categories = categoriesData[0].map(c => ({ value: c.category_id, text: c.category_name }));

                    formHtml += createSelect("Brand", "brand_id", brands, product.brand.brand_id);
                    formHtml += createSelect("Category", "category_id", categories, product.category.category_id);
                    formHtml += createInput("Product Price", "product_price", product.list_price, "number");
                    formHtml += createInput("Model Year", "model_year", product.model_year, "number", false, "Optional");

                    $form.html(formHtml);
                });

                // Submit handler
                $("#submit").off("click").on("click", function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: `https://sae401thibault.alwaysdata.net/api/api.php?actionPut=updateProduct&id=${$("#product_id").val()}&name=${$("#product_name").val()}&modelyear=${$("#model_year").val()}&listprice=${$("#product_price").val()}&category=${$("#category_id").val()}&brand=${$("#brand_id").val()}&KEY=e8f1997c763`,
                        type: "PUT",
                        dataType: "json",
                        success: function(resp) {
                            if (resp.error) {
                                $("#success").empty();
                                $("#error").text("Error updating product: " + resp.error);
                            } else {
                                $("#error").empty();
                                $("#success").text("Product updated successfully!");
                            }
                        },
                        error: function() {
                            $("#error").text("Error updating product.");
                            $("#success").text("");
                        }
                    });
                });
            });
        }

        // BRAND
        else if (modif === "brand") {
            $.getJSON("https://sae401thibault.alwaysdata.net/api/api.php?actionGet=brand&id=" + id, function(data) {
                let formHtml = createInput("Brand Name", "brand_name", data[0].brand_name);
                formHtml += `<input type="hidden" id="brand_id" name="brand_id" value="${data[0].brand_id}">`;
                $form.html(formHtml);

                $("#submit").off("click").on("click", function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: `https://sae401thibault.alwaysdata.net/api/api.php?actionPut=updateBrand&id=${$("#brand_id").val()}&name=${$("#brand_name").val()}&KEY=e8f1997c763`,
                        type: "PUT",
                        dataType: "json",
                        success: function(resp) {
                            if (resp.error) {
                                $("#success").empty();
                                $("#error").text("Error updating brand: " + resp.error);
                            } else {
                                $("#error").empty();
                                $("#success").text("Brand updated successfully!");
                            }
                        },
                        error: function() {
                            $("#error").text("Error updating brand.");
                            $("#success").text("");
                        }
                    });
                });
            });
        }

        // CATEGORY
        else if (modif === "category") {
            $.getJSON("https://sae401thibault.alwaysdata.net/api/api.php?actionGet=categorie&id=" + id, function(data) {
                let formHtml = createInput("Category Name", "category_name", data[0].category_name);
                formHtml += `<input type="hidden" id="category_id" name="category_id" value="${data[0].category_id}">`;
                $form.html(formHtml);

                $("#submit").off("click").on("click", function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: `https://sae401thibault.alwaysdata.net/api/api.php?actionPut=updateCategorie&id=${$("#category_id").val()}&name=${$("#category_name").val()}&KEY=e8f1997c763`,
                        type: "PUT",
                        dataType: "json",
                        success: function(resp) {
                            if (resp.error) {
                                $("#success").empty();
                                $("#error").text("Error updating category: " + resp.error);
                            } else {
                                $("#error").empty();
                                $("#success").text("Category updated successfully!");
                            }
                        },
                        error: function() {
                            $("#error").text("Error updating category.");
                            $("#success").text("");
                        }
                    });
                });
            });
        }

        // STOCK
        else if (modif === "stock") {
            $.getJSON("https://sae401thibault.alwaysdata.net/api/api.php?actionGet=stock&id=" + id, function(data) {
                let stock = data[0];
                let formHtml = createInput("Product", "product_name", stock.product.product_name, "text", true);
                formHtml += `<input type="hidden" id="stock_id" name="stock_id" value="${stock.stock_id}">`;
                formHtml += createInput("Store", "store_name", stock.store.store_name, "text", true);
                formHtml += createInput("Quantity", "quantity", stock.quantity, "number");
                $form.html(formHtml);

                $("#product_name, #store_name").prop("disabled", true);

                $("#submit").off("click").on("click", function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: `https://sae401thibault.alwaysdata.net/api/api.php?actionPut=updateStock&id=${$("#stock_id").val()}&quantity=${$("#quantity").val()}&KEY=e8f1997c763`,
                        type: "PUT",
                        dataType: "json",
                        success: function(resp) {
                            if (resp.error) {
                                $("#success").empty();
                                $("#error").text("Error updating stock: " + resp.error);
                            } else {
                                $("#error").empty();
                                $("#success").text("Stock updated successfully!");
                            }
                        },
                        error: function() {
                            $("#error").text("Error updating stock.");
                            $("#success").text("");
                        }
                    });
                });
            });
        }

        // STORE
        else if (modif === "store") {
            $.getJSON("https://sae401thibault.alwaysdata.net/api/api.php?actionGet=store&id=" + id, function(data) {
                let store = data[0];
                let formHtml = createInput("Store Name", "store_name", store.store_name);
                formHtml += `<input type="hidden" id="store_id" name="store_id" value="${store.store_id}">`;
                formHtml += createInput("Store Phone", "store_phone", store.phone, "text", true, "8 number min");
                formHtml += createInput("Store Email", "store_email", store.email, "email");
                formHtml += createInput("Store Street", "store_street", store.street);
                formHtml += createInput("Store City", "store_city", store.city);
                formHtml += createInput("Store State", "store_state", store.state);
                formHtml += createInput("Store Zip", "store_zip", store.zip_code);
                $form.html(formHtml);

                $("#submit").off("click").on("click", function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: `https://sae401thibault.alwaysdata.net/api/api.php?actionPut=updateStore&id=${$("#store_id").val()}&name=${$("#store_name").val()}&phone=${$("#store_phone").val()}&email=${$("#store_email").val()}&street=${$("#store_street").val()}&city=${$("#store_city").val()}&state=${$("#store_state").val()}&zip=${$("#store_zip").val()}&KEY=e8f1997c763`,
                        type: "PUT",
                        dataType: "json",
                        success: function(resp) {
                            if (resp.error) {
                                $("#success").empty();
                                $("#error").text("Error updating store: " + resp.error);
                            } else {
                                $("#error").empty();
                                $("#success").text("Store updated successfully!");
                            }
                        },
                        error: function() {
                            $("#error").text("Error updating store.");
                            $("#success").text("");
                        }
                    });
                });
            });
        }
    });
</script>
<a id="back-link" href="index.php?action=GestionIT" class="btn btn-warning mb-4">Back</a>
<div class="card shadow p-4">
    <div class="modification">
        <form method="POST" class="form row g-3">
        </form>
        <div class="d-flex justify-content-center">
            <input type="submit" value="Update" id="submit" class="btn btn-success mt-3">
        </div>
        <p id="error" class="text-danger mt-3 text-center"></p>
        <p id="success" class="text-success mt-3 text-center"></p>
    </div>
</div>
</main>
<?php include_once("www/footer.php");?>