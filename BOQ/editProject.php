

<?php
$MainContent .='
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <style>
        
        /* Make the table scrollable on smaller screens */
        .table-responsive {
            overflow-x: auto;
            width: 100%;
        }

        /* Apply styling to table headers */
        thead tr td {
            background-color: #17C664 !important;
            color: black;
            text-align: center;
            font-weight: bold;
        }

        /* Responsive adjustments for table elements */
        .table td, .table th {
            padding: 8px;
            white-space: nowrap;
        }
        .material-icons { cursor: pointer; color:#17C664; }
        .total-cost {
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }


        @media (max-width: 768px) {
            .card-head .col-md-4 {
                font-size: 14px;
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .card-head .col-md-4 input {
                width: 100%;
            }
        }

        /* For screens with max-width: 576px */
        @media (max-width: 576px) {
            .form-group {
                display: flex;
                align-items: center;  /* Vertically center the label and input */
                margin-bottom: 15px; /* Add some margin between fields */
            }

            .form-group label {
                margin-bottom: 0;  /* Remove default margin from the bottom */
                margin-right: 10px;  /* Space between label and input */
                width: 30%;  /* Make the label take up 30% of the container */
                font-weight: bold;  /* Make label bold */
            }

            .form-group input {
                width: 65%;  /* Make the input field take up the remaining 65% of the container */
                padding: 8px;  /* Add padding for the input */
            }

            /* Adjusting padding for smaller screens */
            .col-12 {
                padding-left: 0;
                padding-right: 0;
            }
        }

        /* For larger screens, ensure proper spacing and alignment */
        @media (min-width: 576px) {
            .form-group {
                display: flex;
                justify-content: space-between;  /* Distribute space evenly between label and input */
                align-items: center;
                margin-bottom: 15px;
            }

            .form-group label {
                width: 25%;  /* Label takes up 25% of the container */
                font-weight: bold;
            }

            .form-group input {
                width: 70%;  /* Input takes up 70% of the container */
            }
        }
        @media (max-width: 767px) {
            .card-head {
                text-align: center;
            }
            .form-group {
                padding-left: 0 !important;
            }
            .table th, .table td {
                font-size: 12px;
            }
            .material-icons {
                font-size: 18px;
            }
        }

        @media (max-width: 576px) {
            hr{
                width: 93.2%;
                margin-left: 12px;
            }
        }
    </style>

    <div class="card mb-3">
        <div class="card-head row responsive">
            <div  class="text-center">
                <h3 style="margin: auto; background-color: #037837; margin-bottom: -2px; color:white;" >Project, Construction Of Residential Building</h3>
                <h3 style="margin: auto; background-color: #037837; margin-bottom: -2px; color:white;">Quantity and Cost Estimate</h3>

            </div>
            <hr style="margin: 20px;  margin-bottom: 20px; width: 98.2%;  margin-left: 12px; ">
            <div class="col-12 col-md-4 d-flex align-items-center mb-3 margin:auto form-group" style="padding-left: 2rem; font-weight:bold">
                <label class="me-2">Project </label>
                <input type="text"
                       class="form-control projectInput ProjectName"
                       data-project_id=""
                       data-columnName="ProjectName"
                       placeholder="Project Name"
                       value=""
                       style="border: 2px solid  #90A4AE"
                />
            </div>
            <div class="col-12 col-md-4 d-flex align-items-center mb-3 form-group" style="padding-left: 2rem; font-weight:bold">
                <label class="me-2">BOQ </label>
                <input type="text"
                       class="form-control projectInput BOQTitle"
                       data-project_id=""
                       data-columnName="BOQTitle"
                       placeholder="BOQ Title"
                       value=""
                       style="border: 2px solid #90A4AE"
                />
            </div>
            <div class="col-12 col-md-4 d-flex align-items-center mb-3 form-group" style="padding-left: 2rem; font-weight:bold">
                <label class="me-2">Date </label>
                <input type="date"
                       class="form-control projectInput DateInserted"
                       data-project_id=""
                       data-columnName="DateInserted"
                       placeholder="Date"
                       value=""
                       style="border: 2px solid #90A4AE"
                />
            </div>

        </div>


        <div class="card-body table-responsive">
            <table class="table table-bordered " style="width: 100%">
                <thead style="background-color: green">
                <tr>
                    <td scope="col">SL</td>
                    <td scope="col" style="padding: 10px 150px; text-align: center;" >Description </td>
                    <td scope="col" style="padding: 10px 60px; text-align: center;" >Unit</td>
                    <td scope="col" style="padding: 10px 60px; text-align: center;" >Quantity</td>
                    <td scope="col" style="padding: 10px 60px; text-align: center;" >Rate</td>
                    <td scope="col" style="padding: 10px 60px; text-align: center;" >Cost</td>
                    <td style="border-radius:5px; border: none; font-weight: normal; background-color: #17C664 !important;"><button style="background-color: #17C664; color:white; border:none" type="button" class="material-icons addNewCategory" value="" >add_circle</button></td>
                </tr>
                </thead>
                <tbody id="tableBody">
                <!--        code goes here-->
                </tbody>
            </table>
        </div>
    </div>
';
$MainContent .='
<script>
        $(document).ready(function () {
        let scrollPosition = window.scrollY;

        $(document).on("change", ".projectInput", function () {
          //  console.log("enter into project insertion.");
            let BoqID = $(this).attr("data-project_id") || null;
            let projectValue = $(this).val();
            let columnName = $(this).attr("data-columnName");

            const payload = {
                BoqID: BoqID,
                projectValue: projectValue,
                columnName: columnName,
            };

         //   console.log("project payload :", payload);
            insertProjectAjax(payload);
        });
        function insertProjectAjax(payload) {
            $.ajax({
                type: "POST",
                url: "projectInclution.php", // PHP script to insert category
                data: payload,
                dataType: "JSON",
                success: function (response) {
                 //   console.log("project Insert Server Response", response);


                    if (response.success) { // Check if the response indicates success
                        const Date = response.DateInserted.substring(0, 10);

                        $(".projectInput").attr("data-project_id", response.BoqID);
                        $(".ProjectName").val(response.projectName);
                        $(".BOQTitle").val(response.BOQTitle);
                        $(".DateInserted").val(Date);
                        $(".addNewCategory").attr("value", response.BoqID);
                        // $("#tableBody").html(response.loadedHTML);
                    } else {
                        console.error("Insert/update failed", response);
                    }
                },
                error: function (XHR, status, error) {
                    console.log("Errors", XHR.responseText);
                }
            });
        }
        $(document).on("click", ".addNewCategory", function (){
          //  console.log("clicked");
            let BoqID = $(this).attr("value");
         //   console.log("Project Id :", BoqID);
            const payload = {
                type : "category",
                BoqID: BoqID
            }
            console.log("click on add category button :", payload);
            insertCategoryAjax(payload);
            
        });
        // Category Update and insert
        function insertCategoryAjax(data = null){
          //  console.log(" after clicked for add new come in insertCategoryAjax, and there data is : ", data);
            // $("#tableBody").html(null);
            $.ajax({
                type: "POST",
                url: "insertCategory.php", // PHP script to insert category
                data: data,
                dataType:"JSON",
                success: function (response) {
                    console.log("Category Insert Server Response", response);
                    // $("#tableBody").html(response.loadedHTML);
                    console.log("categoryID, after add a category : ",response.category_id);
                    addSubCategory(response.BoqID, response.category_id);
                },
                error:function (XHR,status,error){
                    console.log("Errors", XHR.responseText);
                }
            });
        }

        $(document).on("change",".categoryInput", function (e){
            let BoqID = $(this).attr("data-project_id");
            let categoryId = $(this).attr("data-category_id");
            let categoryValue = $(this).val();
            let categoryrowId = $(this).attr("data-category_row_id");
            const payload = {
                BoqID : BoqID,
                BoqCategoryID : categoryId,
                CategoryName  : categoryValue,
                type          :"category_update"
            }
            updateCategoryAjax(payload, categoryrowId);
            console.log("Category Title : ", categoryValue,"Category ID ", categoryId);
        });
        function updateCategoryAjax(data = null, categoryrowId){
        // $("#tableBody").html(null);
            $.ajax({
                type: "POST",
                url: "insertCategory.php", // PHP script to insert category
                data: data,
                dataType:"JSON",
                success: function (response) {
                console.log("Category Insert Server Response", response);
                $(`#${categoryrowId}.categoryInput`).val(response.CategoryName);
                },
                    error:function (XHR,status,error){
                    console.log("Errors", XHR.responseText);
                }
            });
        }
        // Sub Category input update
        $(document).on("change",".subcategoryInput", function (e){1
            e.preventDefault();
            let BoqID = $(this).attr("data-project_id");
            let subCostRow               =  $(this).attr("data-subCostRow");
            let BoqSubCategoryID         = $(this).attr("data-sub_category_id");
            let BoqCategoryID            = $(this).attr("data-category_id");
            let SubCategoryColumnName    = $(this).attr("data-columnName");
            let SubCategoryInputValue    = $(this).val(); // rate,

            let CategoryRowID         = $(this).attr("data-category_row_id");
            let SubCategoryRowID         = $(this).attr("data-sub_category_row_id");

            const payload = {
                BoqID : BoqID,
                BoqSubCategoryID      : BoqSubCategoryID,
                BoqCategoryID         : BoqCategoryID,
                SubCategoryColumnName : SubCategoryColumnName,
                SubCategoryInputValue : SubCategoryInputValue,
            }

            console.log("subcategoryInput Value : ",payload);
            console.log("CategoryRowID :",CategoryRowID);
            console.log("SubCategoryRowID :",SubCategoryRowID);

            updateSubCategoryAjax(payload, BoqSubCategoryID, SubCategoryRowID, subCostRow );
          //  updateGrandTotal(BoqID);
        });
        function updateSubCategoryAjax(data, BoqSubCategoryID, SubCategoryRowID, subCostRow) {
          // console.log("subCostRow :", subCostRow);
            const focusedElement = document.activeElement;

            const columnName = $(focusedElement).data("columnname");
            const subCategoryRowId = $(focusedElement).data("sub_category_row_id");

            $.ajax({
                type: "POST",
                url: "updateSubcategory.php",
                data: data,
                dataType: "JSON",
                success: function (response) {
                     console.log("Server Response................................................", response);

                    if (response) {
                        if (response.SubcategoryName !== undefined) {
                            $(`#${SubCategoryRowID}`).find(".SubcategoryName").val(response.SubcategoryName);
                        }

                        if (response.SubcategoryUnit !== undefined) {
                            // Check if the value contains "m3" and modify it if needed
                            let unitValue = response.SubcategoryUnit;
                            if (unitValue === "m3" || unitValue === "M3" || unitValue === "m^3" || unitValue === "M^3") {
                                unitValue = "m&#179;"; // Unicode for superscript 3 (³)
                            }
                            // Set the value of the input field
                            $(`#${SubCategoryRowID}`).find(".SubcategoryUnit").val(unitValue);
                        }


                        if (response.SubcategoryQty !== undefined) {
                            $(`#${SubCategoryRowID}`).find(".SubcategoryQty").val(response.SubcategoryQty);
                        }

                        if (response.SubcategoryRate !== undefined) {
                            $(`#${SubCategoryRowID}`).find(".SubcategoryRate").val(response.SubcategoryRate);
                        }
                        if (response.SubcategoryCost !== undefined) {
                            $(`#${SubCategoryRowID}`).find(".subcategoryCost").val(response.SubcategoryCost);
                        }
                        if (response.TotalCosts !== undefined) {
                            $(`#${subCostRow}`).find(".subcategoryTotal").text(response.TotalCosts);
                        }
                        if (response.GrandTotalCost !== undefined) {
                            $(`#grandTotalRow`).find("#grandTotal").text(response.GrandTotalCost);
                        }
                    }


                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                }
            });

        }

        window.insertCategoryField = function (input, rowId, fieldType) {
            let BoqID = $(this).attr("data-project_id");
            let categoryName = $(input).val();
            let data = {
                BoqID : BoqID,
                type: "category",
                category_name: categoryName,
                field_type: fieldType
            };
            insertCategoryAjax(data);
        }
        function emptyTableKeepLast() {
            var tableBody = document.querySelector("#tableBody");
            var rows = tableBody.querySelectorAll("tr");

            // Loop through all rows except the last one and remove them
            for (var i = 0; i < rows.length - 1; i++) {
                tableBody.removeChild(rows[i]);
            }
        }
        $(document).on("click",".addSubcategoryRow", function (e){
            e.preventDefault();
            //scrollPosition = window.scrollY;
            let BoqID = $(this).attr("data-project_id");
            let addSubcategoryRowID    = $(this).attr("data-sub_category_row_id");
            let BoqCategoryID          = $(this).attr("data-category_id");
            addSubCategory(BoqID, BoqCategoryID, addSubcategoryRowID);

        });
        function addSubCategory(BoqID, categoryId, categoryRowId = null){
            console.log("categoryId : ", categoryId);
            $.ajax({
                type: "POST",
                url: "insertSubcategory.php", // PHP file to handle the insertion of subcategory
                data: {
                    BoqID:BoqID,
                    categoryId: categoryId
                }, // Send the categoryId to associate with the new subcategory
                dataType:"JSON",
                success: function (response) {
                    // console.log("Server Response", response.loadedHTML);
                   // updateGrandTotal(BoqID);
                    $("#tableBody").html(response.loadedHTML);
                },
                error: function (xhr, status, error) {
                    console.error("Failed to insert subcategory:", error);
                }
            });
        }


        $(document).on("click",".deleteSubcategoryRow", function (e){
            e.preventDefault();
            console.log("Hellooooooooooooooo");

            //scrollPosition = window.scrollY;
            let BoqID = $(this).attr("data-project_id");
            let addSubcategoryRowID    = $(this).attr("data-subcategory_id");
            let BoqCategoryID          = $(this).attr("data-category_id");

            console.log( BoqID );
            deleteSubcategory(BoqID, BoqCategoryID, addSubcategoryRowID);

        });


        function deleteSubcategory(BoqID,BoqCategoryID,BoqSubcategoryID ){
            $.ajax({
                type: "POST",
                url: "deleteSubcategory.php",
                data: {
                    BoqID : BoqID,
                    BoqSubcategoryID: BoqSubcategoryID,
                    BoqCategoryID: BoqCategoryID
                },
                dataType:"JSON",
                success: function (response) {
                    console.log("Delete Server Response :", response.loadedHTML);
                    $("#tableBody").html(response.loadedHTML);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                }
            });
        }

        $(document).on("click",".deleteProject", function (e){
            e.preventDefault();

            let BoqID = $(this).attr("data-project_id");
            deleteProject(BoqID);
        });
        function deleteProject(BoqID) {
            $.ajax({
                type: "POST",
                url: "deleteProject.php",
                data: {
                    BoqID : BoqID,
                },
                dataType:"JSON",
                success: function (response) {
                    if(response.success){
                        console.log("Delete Server Response :", response.message);
                        $("#projectTableBody").html(response.loadedHTML);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                }
            });
        }


        $(document).on("click",".copyProject", function (e){
            e.preventDefault();
            let BoqID = $(this).attr("data-project_id");

            copyProject(BoqID);
        });
        function copyProject(BoqID) {
            $.ajax({
                type: "POST",
                url: "copyProject.php",
                data: {
                    BoqID : BoqID,
                },
                dataType:"JSON",
                success: function (response) {
                    if(response.success){
                        console.log("Copy Server Response :", response.message);
                        $("#projectTableBody").html(response.loadedHTML);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                }
            });
        }








        // GRAND TOTAL


        function updateGrandTotal(productId) {
            let productID = productId;
            $.ajax({
                type: "POST",
                url: "grandTotal.php",
                data: {
                    BoqID : productID,
                },
                dataType:"JSON",

                success: function (response) {
                    if(response.success){
                        console.log("Copy Server Response :", response.message);
                        $("#grandTotal").text(response.TotalCost.toFixed(2));
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                }
            });

        }

    });
</script>
<script>
    $(document).ready(function () {
        const urlParams = new URLSearchParams(window.location.search);
        const BoqID = urlParams.get("BoqID"); // Adjust "BoqID" to match your query parameter name

        loadExistingData(BoqID);

    function loadExistingData(BoqID) {
        // scrollPosition = window.scrollY;
        $.ajax({
            type: "GET",
            url: "editloadData.php", // Fetch existing categories and subcategories from the database
            data: {
                BoqID:BoqID
            },
            dataType:"JSON",
            success: function (response) {
                const formattedDate = response.DateInserted.split(" ")[0];
                $(".ProjectName").val(response.ProjectName);
                $(".BOQTitle").val(response.BOQTitle);
                $(".DateInserted").val(formattedDate);
                $(".addNewCategory").attr("value", response.BoqID);
                $("#tableBody").html(response.LoadHTML);
                $(".projectInput").attr("data-project_id", response.BoqID);
                //updateGrandTotal(BoqID);
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
            }
        });
    }
        function updateGrandTotal(productId) {
            let productID = productId;
            $.ajax({
                type: "POST",
                url: "grandTotal.php",
                data: {
                    BoqID : productID,
                },
                dataType:"JSON",

                success: function (response) {
                    if(response.success){
                        console.log("Copy Server Response :", response.message);
                        $("#grandTotal").text(response.TotalCost.toFixed(2));
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                }
            });

        }
    });
</script>

<script>
    // Delete Category and all its subcategories
$(document).ready(function() {
    $(document).on("click", ".deleteCategoryRow", function() {
        if(confirm("Are you sure you want to delete this category and all its subcategories?")) {
            var categoryId = $(this).data("category_id");
            var BoqID = $(this).data("project_id");
            var rowId = $(this).data("sub_category_row_id");

            console.log("categoryId:", categoryId);
            console.log("BoqID:", BoqID);
            console.log("rowId:", rowId);

            $.ajax({
                url: "deleteCategory.php",
                type: "POST",
                dataType: "json",
                data: {
                    category_id: categoryId,
                    BoqID: BoqID,
                    is_category: 1
                },
                success: function(response) {
                    console.log("Response:", response);
                    if (response.success) {
                        $("#" + rowId).nextUntil("tr.category-tr").remove();
                        $("#" + rowId).remove();
                        location.reload();
                    } else {
                        alert("Error deleting category: " + (response.error || "Unknown error"));
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    alert("AJAX Error: " + error);
                }
            });
        }
    });
});
</script>';
