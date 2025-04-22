<?php
/**
 * Management page for entities for BikeStores employees.
 * Harmonized logic and style with gestionEC (Chef).
 */
$page = "gestionE";
include_once("www/Employee/headerE.php");
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    // Select entity logic (like gestionEC)
    $("#entity-select").on("change", function() {
        const entity = $(this).val();
        loadEntity(entity);
    });

    // Initial load if click param is present
    const click = "<?php echo isset($_GET['click']) ? $_GET['click'] : ''; ?>";
    if (click) {
        $("#entity-select").val(click).trigger("change");
    }

    // Populate select options
    const entities = [
        { value: "produit", text: "Product" },
        { value: "brand", text: "Brand" },
        { value: "category", text: "Category" },
        { value: "stock", text: "Stock" },
        { value: "store", text: "Store" }
    ];
    $("#entity-select").empty().append('<option value="">Choose entity</option>');
    entities.forEach(e => {
        $("#entity-select").append(`<option value="${e.value}">${e.text}</option>`);
    });

    // Load entity table and insert button
    function loadEntity(entity) {
        $(".insert").empty();
        $("#table").empty();

        if (!entity) {
            $("#table").html("Please choose an option");
            return;
        }

        let insertLabel = "";
        let insertAdd = "";
        let apiUrl = "";
        let tableHead = "";
        let rowBuilder = null;

        if (entity === "produit") {
            insertLabel = "Add Product";
            insertAdd = "product";
            apiUrl = "https://sae401thibault.alwaysdata.net/api/api.php?actionGet=products";
            tableHead = "<thead><tr><th>id</th><th>Product Name</th><th>Brand</th><th>Category</th><th>Model Year</th><th>List Price</th><th></th><th></th></tr></thead>";
            rowBuilder = product => `
                <tr>
                    <td>${product.product_id}</td>
                    <td>${product.product_name}</td>
                    <td>${product.brand.brand_name}</td>
                    <td>${product.category.category_name}</td>
                    <td>${product.model_year}</td>
                    <td>${product.list_price} €</td>
                    <td><a href='index.php?action=update&modif=produit&id=${product.product_id}'>Update</a></td>
                    <td><a href='index.php?action=delete&sup=produit&id=${product.product_id}'>Delete</a></td>
                </tr>
            `;
        } else if (entity === "brand") {
            insertLabel = "Add Brand";
            insertAdd = "brand";
            apiUrl = "https://sae401thibault.alwaysdata.net/api/api.php?actionGet=brands";
            tableHead = "<thead><tr><th>id</th><th>Brand Name</th><th></th><th></th></tr></thead>";
            rowBuilder = brand => `
                <tr>
                    <td>${brand.brand_id}</td>
                    <td>${brand.brand_name}</td>
                    <td><a href='index.php?action=update&modif=brand&id=${brand.brand_id}'>Update</a></td>
                    <td><a href='index.php?action=delete&sup=brand&id=${brand.brand_id}'>Delete</a></td>
                </tr>
            `;
        } else if (entity === "category") {
            insertLabel = "Add Category";
            insertAdd = "category";
            apiUrl = "https://sae401thibault.alwaysdata.net/api/api.php?actionGet=categories";
            tableHead = "<thead><tr><th>id</th><th>Category Name</th><th></th><th></th></tr></thead>";
            rowBuilder = category => `
                <tr>
                    <td>${category.category_id}</td>
                    <td>${category.category_name}</td>
                    <td><a href='index.php?action=update&modif=category&id=${category.category_id}'>Update</a></td>
                    <td><a href='index.php?action=delete&sup=category&id=${category.category_id}'>Delete</a></td>
                </tr>
            `;
        } else if (entity === "stock") {
            insertLabel = "Add Stock";
            insertAdd = "stock";
            apiUrl = "https://sae401thibault.alwaysdata.net/api/api.php?actionGet=stockbystore&id=<?php echo $_SESSION['StoreEmployee']; ?>";
            tableHead = "<thead><tr><th>id</th><th>Product</th><th>Store</th><th>Quantity</th><th></th><th></th></tr></thead>";
            rowBuilder = stock => `
                <tr>
                    <td>${stock.stock_id}</td>
                    <td>${stock.product.product_name}</td>
                    <td>${stock.store.store_name}</td>
                    <td>${stock.quantity}</td>
                    <td><a href='index.php?action=update&modif=stock&id=${stock.stock_id}'>Update</a></td>
                    <td><a href='index.php?action=delete&sup=stock&id=${stock.stock_id}'>Delete</a></td>
                </tr>
            `;
        } else if (entity === "store") {
            insertLabel = "Add Store";
            insertAdd = "store";
            apiUrl = "https://sae401thibault.alwaysdata.net/api/api.php?actionGet=store&id=<?php echo $_SESSION['StoreEmployee']; ?>";
            tableHead = "<thead><tr><th>id</th><th>Store Name</th><th>Phone</th><th>Email</th><th>Street</th><th>City</th><th>State</th><th>Zip Code</th><th></th><th></th></tr></thead>";
            rowBuilder = store => `
                <tr>
                    <td>${store.store_id}</td>
                    <td>${store.store_name}</td>
                    <td>${store.phone}</td>
                    <td>${store.email}</td>
                    <td>${store.street}</td>
                    <td>${store.city}</td>
                    <td>${store.state}</td>
                    <td>${store.zip_code}</td>
                    <td><a href='index.php?action=update&modif=store&id=${store.store_id}'>Update</a></td>
                    <td><a href='index.php?action=delete&sup=store&id=${store.store_id}'>Delete</a></td>
                </tr>
            `;
        }

        // Insert button
        if (insertLabel && insertAdd) {
            $(".insert").html(`<a href='index.php?action=insert&add=${insertAdd}' class="btn btn-primary">${insertLabel}</a>`);
        }

        // Load table
        if (apiUrl && rowBuilder) {
            $.ajax({
                url: apiUrl,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $("#table").html(tableHead);
                    // For store, data may be a single object in array
                    if (entity === "store" && Array.isArray(data) && data.length === 1) {
                        $("#table").append(rowBuilder(data[0]));
                    } else {
                        data.forEach(item => {
                            $("#table").append(rowBuilder(item));
                        });
                    }
                },
                error: function(xhr, status, error) {
                    $("#table").html("Error while retrieving " + entity + "s.");
                }
            });
        }
    }
});
</script>

<div class="container my-4">
    <h1 class="text-center mb-4">Management</h1>
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
        <select id="entity-select" class="form-select w-auto"></select>
    </div>
    <div class="insert mb-3"></div>
    <div class="table-responsive">
        <table id="table" class="table table-striped table-hover"></table>
    </div>
</div>
</main>
<?php include_once("www/footer.php"); ?>