<!---->
<?php
//    $conn = mysqli_connect("localhost", "root", "", "boq");//?>
<!---->
<!--<!doctype html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
<!--    <meta http-equiv="X-UA-Compatible" content="ie=edge">-->
<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">-->
<!--    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>-->
<!--    <title>BOQ Table</title>-->
<!--</head>-->
<!--<body>-->
<!--<div class="container">-->
<!--    <table class="table table-bordered" style="width: 100%">-->
<!--        <thead>-->
<!--        <tr class="fw-bold">-->
<!--            <td>No</td>-->
<!--            <td>Description Of Work (Category)</td>-->
<!--            <td>Unit</td>-->
<!--            <td>Quantity</td>-->
<!--            <td>Rate</td>-->
<!--            <td>Cost</td>-->
<!--            <td><span class="add-icon" onclick="addCategoryRow()">[+]</span></td>-->
<!--        </tr>-->
<!--        </thead>-->
<!--        <tbody id="tableBody">-->
<!---->
<!--        <tr id="grandTotalRow">-->
<!--            <td colspan="5" align="right"><b>Grand Total Cost: </b></td>-->
<!--            <td><span id="grandTotal">0.00</span></td>-->
<!--        </tr>-->
<!--        </tbody>-->
<!--    </table>-->
<!--</div>-->
<!---->
<!--<script>-->
<!--    $(document).ready(function () {-->
<!--        //  let scrollPosition = window.scrollY;-->
<!--        loadExistingData();-->
<!---->
<!--        function loadExistingData() {-->
<!--            // scrollPosition = window.scrollY;-->
<!--            $.ajax({-->
<!--                type: "GET",-->
<!--                url: "loadData.php", // Fetch existing categories and subcategories from the database-->
<!--                success: function (response) {-->
<!--                    try {-->
<!--                        let data = JSON.parse(response);-->
<!---->
<!--                        let grandTotal = 0;-->
<!--                        const romanNumerals = [-->
<!--                            "I", "II", "III", "IV", "V",-->
<!--                            "VI", "VII", "VIII", "IX", "X",-->
<!--                            "XI", "XII", "XIII", "XIV", "XV",-->
<!--                            "XVI", "XVII", "XVIII", "XIX", "XX",-->
<!--                            "XXI", "XXII", "XXIII", "XXIV", "XXV",-->
<!--                            "XXVI", "XXVII", "XXVIII", "XXIX", "XXX",-->
<!--                            "XXXI", "XXXII", "XXXIII", "XXXIV", "XXXV",-->
<!--                            "XXXVI", "XXXVII", "XXXVIII", "XXXIX", "XL",-->
<!--                            "XLI", "XLII", "XLIII", "XLIV", "XLV",-->
<!--                            "XLVI", "XLVII", "XLVIII", "XLIX", "L"-->
<!--                        ];-->
<!---->
<!---->
<!--                        data.forEach(function (item, index) {-->
<!---->
<!--                            let categoryCounter = index + 1;-->
<!--                            let romanCount = romanNumerals[Number(categoryCounter) - 1];-->
<!--                            let rowId = `category-row-${categoryCounter}`;-->
<!---->
<!--                            let categoryRow = `<tr id="${rowId}">-->
<!--                                                <td> ${romanCount}</td>-->
<!---->
<!--                                                <td colspan="5"><input type="text" class="form-control" value="${item.category.CategoryName}" onchange="updateCategory(this, '${rowId}', ${item.category.BoqCategoryID})"></td>-->
<!--                                                <td>-->
<!--                                                    <span class="add-icon" onclick="addSubcategoryRow('${rowId}', ${item.category.BoqCategoryID})">[+]</span>-->
<!--                                                </td>-->
<!--                                            </tr>`;-->
<!---->
<!--                            let subCostRow = `subcategory-cost-row-${categoryCounter}`;-->
<!--                            let subcategoryCostRow = `<tr id="${subCostRow}">-->
<!--                                                        <td colspan="5" align="right"><b>Subcategory Total Cost: </b></td>-->
<!--                                                        <td><span class="subcategoryTotal"></span></td>-->
<!--                                                      </tr>`;-->
<!--                            let subTotal = 0;-->
<!---->
<!--                            $('#grandTotalRow').before(categoryRow + subcategoryCostRow);-->
<!---->
<!--                            let subcategoryRow = '';-->
<!--                            let i = 0;-->
<!--                            item.subcategories.forEach(function (subcategory) {-->
<!---->
<!--                                subTotal += parseFloat(parseFloat(subcategory.SubcategoryCost || 0).toFixed(2));-->
<!---->
<!--                                let subcategoryId = `subcategory-row-${subcategory.BoqSubcategoryID}`;-->
<!--                                let subcategoryRowId = `subcategory-row-${categoryId}-${subcategoryCounter}`;-->
<!--                                subcategoryRow += `<tr id="${subcategoryId}">-->
<!--                                                      <td>${++i}</td>-->
<!--                                                      <td><input type="text" class="form-control SubcategoryName" value="${subcategory.SubcategoryName ? subcategory.SubcategoryName : ''}" onchange="updateSubcategoryField(this, '${subcategoryId}', '${rowId}', '${subcategory.BoqSubcategoryID}', 'SubcategoryName', '${subCostRow}')"></td>-->
<!---->
<!--                                                      <td><input type="text" class="form-control SubcategoryUnit" value="${subcategory.SubcategoryUnit ? subcategory.SubcategoryUnit : ''}" onchange="updateSubcategoryField(this, '${subcategoryId}', '${rowId}', ${subcategory.BoqSubcategoryID}, 'SubcategoryUnit', '${subCostRow}')"></td>-->
<!---->
<!--                                                      <td><input type="number" class="form-control SubcategoryQty" value="${subcategory.SubcategoryQty}" onchange="updateSubcategoryField(this, '${subcategoryId}', '${rowId}', ${subcategory.BoqSubcategoryID}, 'SubcategoryQty', '${subCostRow}')"></td>-->
<!---->
<!--                                                      <td><input type="number" class="form-control SubcategoryRate" value="${subcategory.SubcategoryRate}" onchange="updateSubcategoryField(this, '${subcategoryId}', '${rowId}', ${subcategory.BoqSubcategoryID}, 'SubcategoryRate', '${subCostRow}')"></td>-->
<!---->
<!--                                                      <td><input type="number" class="form-control SubcategoryCost" value="${(parseFloat(subcategory.SubcategoryCost) || 0).toFixed(2)}"></td>-->
<!---->
<!--                                                      <td><span class="add-icon" onclick="addSubcategoryRow('${rowId}', ${item.category.BoqCategoryID})">[+]</span> |-->
<!--                                                      <span class="delete-icon" onclick="deleteSubcategoryRow('${subcategory.BoqSubcategoryID}', '${item.category.BoqCategoryID}', '${subCostRow}' )">[-]</span></td>-->
<!--                                                    </tr>`;-->
<!--                            });-->
<!---->
<!--                            $(`#subcategory-cost-row-${categoryCounter} .subcategoryTotal`).text(subTotal.toFixed(2));-->
<!---->
<!--                            $(`#${rowId}`).after(subcategoryRow);-->
<!---->
<!--                            updateGrandTotal();-->
<!--                        });-->
<!--                        //   window.scrollTo(0, scrollPosition);-->
<!--                    } catch (error) {-->
<!--                        console.error('Error: ', error);-->
<!--                    }-->
<!--                },-->
<!--                error: function (xhr, status, error) {-->
<!--                    console.error('AJAX error:', status, error);-->
<!--                }-->
<!--            });-->
<!--        }-->
<!---->
<!--        window.addCategoryRow = function () {-->
<!---->
<!--            let categoryCounter = $('#tableBody tr').length;-->
<!--            let rowId = `category-row-${categoryCounter}`;-->
<!---->
<!--            let categoryRow = `<tr id="${rowId}">-->
<!--                                   <td>${categoryCounter}</td>-->
<!--                                   <td><input type="text" class="form-control" placeholder="Category Description" onchange="insertCategoryField(this, '${rowId}', 'name')"></td>-->
<!--                                   <td colspan="5">-->
<!--                                       <span class="add-icon" onclick="addSubcategoryRow('${rowId}', null)">[+]</span>-->
<!--                                   </td>-->
<!--                               </tr>`;-->
<!---->
<!--            let subcategoryCostRow = `<tr id="subcategory-cost-row-${categoryCounter}">-->
<!--                                        <td colspan="5" align="right"><b>Subcategory Total Cost: </b><span class="subcategoryTotal">0.00</span></td>-->
<!--                                      </tr>`;-->
<!---->
<!--            $('#grandTotalRow').before(categoryRow + subcategoryCostRow);-->
<!--        }-->
<!---->
<!--        window.addSubcategoryRow = function (categoryRowId, categoryId) {-->
<!--            $.ajax({-->
<!--                type: "POST",-->
<!--                url: "insertSubcategory.php",-->
<!--                data: { categoryId: categoryId },-->
<!--                success: function (response) {-->
<!--                    try {-->
<!--                        const subcategory = JSON.parse(response);-->
<!---->
<!--                        // Create a unique subcategory ID or counter-->
<!--                        let subcategoryCounter = $(`#${categoryRowId} ~ tr[data-category-id="${categoryId}"]`).length + 1;-->
<!--                        let subcategoryRowId = `subcategory-row-${categoryId}-${subcategoryCounter}`;-->
<!---->
<!--                        // Create the new subcategory row with required fields-->
<!--                        let subcategoryRow = `<tr id="${subcategoryRowId}" data-category-id="${categoryId}">-->
<!--                                        <td>${subcategoryCounter}</td> <!-- Incrementing number for each subcategory -->-->
<!--                                                      <td><input type="text" class="form-control SubcategoryName" value="${subcategory.SubcategoryName ? subcategory.SubcategoryName : ''}" onchange="updateSubcategoryField(this, '${subcategoryId}', '${rowId}', '${subcategory.BoqSubcategoryID}', 'SubcategoryName', '${subCostRow}')"></td>-->
<!---->
<!--                                                      <td><input type="text" class="form-control SubcategoryUnit" value="${subcategory.SubcategoryUnit ? subcategory.SubcategoryUnit : ''}" onchange="updateSubcategoryField(this, '${subcategoryId}', '${rowId}', ${subcategory.BoqSubcategoryID}, 'SubcategoryUnit', '${subCostRow}')"></td>-->
<!---->
<!--                                                      <td><input type="number" class="form-control SubcategoryQty" value="${subcategory.SubcategoryQty}" onchange="updateSubcategoryField(this, '${subcategoryId}', '${rowId}', ${subcategory.BoqSubcategoryID}, 'SubcategoryQty', '${subCostRow}')"></td>-->
<!---->
<!--                                                      <td><input type="number" class="form-control SubcategoryRate" value="${subcategory.SubcategoryRate}" onchange="updateSubcategoryField(this, '${subcategoryId}', '${rowId}', ${subcategory.BoqSubcategoryID}, 'SubcategoryRate', '${subCostRow}')"></td>-->
<!---->
<!--                                                      <td><input type="number" class="form-control SubcategoryCost" value="${(parseFloat(subcategory.SubcategoryCost) || 0).toFixed(2)}"></td><td>-->
<!--                                            <span class="add-icon" onclick="addSubcategoryRow('${categoryRowId}', ${categoryId})">[+]</span> |-->
<!--                                            <span class="delete-icon" onclick="deleteSubcategoryRow('${subcategory.BoqSubcategoryID}', '${categoryId}', '${subcategoryRowId}')">[-]</span>-->
<!--                                        </td>-->
<!--                                     </tr>`;-->
<!---->
<!--                        // Append the new subcategory row immediately after the corresponding category row-->
<!--                        $(`#${categoryRowId}`).after(subcategoryRow);-->
<!---->
<!--                        // Optionally, you can update the total cost for the category here-->
<!--                        updateCategoryTotalCost(categoryRowId);-->
<!---->
<!--                    } catch (error) {-->
<!--                        console.error('Error parsing response:', error);-->
<!--                    }-->
<!--                },-->
<!--                error: function (xhr, status, error) {-->
<!--                    console.error('Failed to insert subcategory:', error);-->
<!--                }-->
<!--            });-->
<!--        }-->
<!---->
<!---->
<!--        // window.addSubcategoryRow = function (categoryRowId, categoryId) {-->
<!--        //     scrollPosition = window.scrollY;-->
<!--        //     // First, send an AJAX request to insert the subcategory into the database-->
<!--        //     $.ajax({-->
<!--        //         type: "POST",-->
<!--        //         url: "insertSubcategory.php", // PHP file to handle the insertion of subcategory-->
<!--        //         data: {categoryId: categoryId}, // Send the categoryId to associate with the new subcategory-->
<!--        //         success: function (response) {-->
<!--        //             try {-->
<!--        //-->
<!--        //                 emptyTableKeepLast();-->
<!--        //                 loadExistingData();-->
<!--        //             } catch (error) {-->
<!--        //                 console.error('Error parsing response:', error);-->
<!--        //             }-->
<!--        //         },-->
<!--        //         error: function (xhr, status, error) {-->
<!--        //             console.error('Failed to insert subcategory:', error);-->
<!--        //         }-->
<!--        //     });-->
<!--        // }-->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!--        window.insertCategoryField = function (input, rowId, fieldType) {-->
<!--            let categoryName = $(input).val();-->
<!--            let data = {-->
<!--                type: 'category',-->
<!--                category_name: categoryName,-->
<!--                field_type: fieldType-->
<!--            };-->
<!---->
<!--            $.ajax({-->
<!--                type: "POST",-->
<!--                url: "insertCategory.php", // PHP script to insert category-->
<!--                data: data,-->
<!--                success: function (response) {-->
<!--                    let result = JSON.parse(response);-->
<!--                    if (result.status === 'success') {-->
<!--                        console.log("Category inserted with ID: " + result.category_id);-->
<!--                        $(`#${rowId}`).attr('data-category-id', result.category_id);-->
<!---->
<!--                        // Update subcategory to allow insertion-->
<!--                        $(input).off('oninput');-->
<!--                        $(input).on('input', function () {-->
<!--                            updateCategory(this, rowId, result.category_id);-->
<!--                        });-->
<!--                    }-->
<!--                }-->
<!--            });-->
<!--        }-->
<!---->
<!--        function emptyTableKeepLast() {-->
<!--            var tableBody = document.querySelector("#tableBody");-->
<!--            var rows = tableBody.querySelectorAll("tr");-->
<!---->
<!--            // Loop through all rows except the last one and remove them-->
<!--            for (var i = 0; i < rows.length - 1; i++) {-->
<!--                tableBody.removeChild(rows[i]);-->
<!--            }-->
<!--        }-->
<!---->
<!--        window.addSubcategoryRow = function (categoryRowId, categoryId) {-->
<!--            scrollPosition = window.scrollY;-->
<!--            // First, send an AJAX request to insert the subcategory into the database-->
<!--            $.ajax({-->
<!--                type: "POST",-->
<!--                url: "insertSubcategory.php", // PHP file to handle the insertion of subcategory-->
<!--                data: {categoryId: categoryId}, // Send the categoryId to associate with the new subcategory-->
<!--                success: function (response) {-->
<!--                    try {-->
<!---->
<!--                        emptyTableKeepLast();-->
<!--                        loadExistingData();-->
<!--                    } catch (error) {-->
<!--                        console.error('Error parsing response:', error);-->
<!--                    }-->
<!--                },-->
<!--                error: function (xhr, status, error) {-->
<!--                    console.error('Failed to insert subcategory:', error);-->
<!--                }-->
<!--            });-->
<!--        }-->
<!---->
<!--        window.updateSubcategoryField = function (input, subcategoryId, categoryRowId, subcategoryIdValue, fieldType, subCostRow) {-->
<!--            let value = $(input).val();-->
<!--            let categoryId = $(`#${categoryRowId}`).data('category-id'); // Get category ID-->
<!---->
<!--            let subcategoryRow = $(`#${subcategoryId}`);-->
<!---->
<!--            let quantity = parseFloat(subcategoryRow.find('input[type="number"]').eq(0).val());-->
<!--            let rate = parseFloat(subcategoryRow.find('input[type="number"]').eq(1).val());-->
<!---->
<!--            let cost = (isNaN(quantity) || isNaN(rate)) ? 0 : quantity * rate;-->
<!---->
<!---->
<!--            subcategoryRow.find('input[type="number"]').eq(2).val(cost.toFixed(2));-->
<!---->
<!--            let data = {-->
<!--                type: 'update_subcategory',-->
<!--                subcategory_id: subcategoryIdValue,-->
<!--                field_type: fieldType, // The field being updated (e.g., 'SubcategoryName', 'SubcategoryUnit', etc.)-->
<!--                value: value,          // Pass the updated field value (name, unit, etc.)-->
<!--                cost: cost.toFixed(2)  // Pass the calculated cost-->
<!--            };-->
<!---->
<!--            console.log('data :', data);-->
<!---->
<!--            $.ajax({-->
<!--                type: "POST",-->
<!--                url: "updateSubcategory.php", // PHP script to update subcategory-->
<!--                data: data,-->
<!--                success: function (response) {-->
<!--                    console.log('response :', response);-->
<!--                    let result = JSON.parse(response);-->
<!--                    if (result.status === 'success') {-->
<!--                        let updatedSubcategory = result.updatedSubcategory;-->
<!---->
<!--                        subcategoryRow.find('.SubcategoryName').text(updatedSubcategory.SubcategoryName);-->
<!--                        subcategoryRow.find('.SubcategoryUnit').text(updatedSubcategory.SubcategoryUnit);-->
<!--                        subcategoryRow.find('.SubcategoryQty').text(updatedSubcategory.SubcategoryQty);-->
<!--                        subcategoryRow.find('.SubcategoryRate').text(updatedSubcategory.SubcategoryRate);-->
<!--                        let subcategoryCost = Number(updatedSubcategory.SubcategoryCost);-->
<!---->
<!--                        subcategoryRow.find('.SubcategoryCost').text(subcategoryCost.toFixed(2)); // Assuming you want to format the cost-->
<!---->
<!--                        updateSubcategoryTotal(subCostRow);-->
<!---->
<!--                    } else {-->
<!--                        console.error("Error updating subcategory:", result.message);-->
<!--                    }-->
<!---->
<!--                }-->
<!--            });-->
<!---->
<!--        }-->
<!---->
<!--        function updateSubcategoryTotal(subCostRow) {-->
<!--            let i =0;-->
<!--            console.log('updateSubcategoryTotal : ');-->
<!--            let subcategoryRows = $(`#${subCostRow}`).prevUntil(`tr[id^='subcategory-cost-row']`);-->
<!--            let subTotal = 0;-->
<!--            subcategoryRows.each(function () {-->
<!--                let cost = parseFloat($(this).find('input.SubcategoryCost').val()) || 0;-->
<!--                subTotal += cost;-->
<!--                console.log(i++ + ' cost : ' + cost + ' subTotal : ' + subTotal);-->
<!--            });-->
<!---->
<!--            $(`#${subCostRow} .subcategoryTotal`).text(subTotal.toFixed(2));-->
<!--            updateGrandTotal()-->
<!--        }-->
<!---->
<!--        window.deleteSubcategoryRow = function(BoqSubcategoryID, BoqCategoryID){-->
<!--            scrollPosition = window.scrollY;-->
<!--            $.ajax({-->
<!--                type: "POST",-->
<!--                url: "deleteSubcategory.php",-->
<!--                data: {-->
<!--                    BoqSubcategoryID: BoqSubcategoryID,-->
<!--                    BoqCategoryID: BoqCategoryID-->
<!--                },-->
<!--                success: function (response) {-->
<!--                    if (response.success) {-->
<!--                        console.log(response.message); // Logs "Subcategory deleted successfully."-->
<!--                        emptyTableKeepLast();-->
<!--                        loadExistingData();-->
<!---->
<!--                    } else {-->
<!--                        console.error("Error:", response.message); // Logs any error messages-->
<!--                    }-->
<!--                },-->
<!--                error: function (xhr, status, error) {-->
<!--                    console.error("AJAX error:", error);-->
<!--                }-->
<!--            });-->
<!--        }-->
<!---->
<!---->
<!---->
<!---->
<!--        function updateGrandTotal() {-->
<!--            let total = 0;-->
<!--            $('#tableBody .SubcategoryCost').each(function () {-->
<!--                total += parseFloat($(this).val()) || 0;-->
<!--            });-->
<!--            $('#grandTotal').text(total.toFixed(2));-->
<!--        }-->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!--    }); // Add this closing bracket to properly close the document ready function-->
<!--</script>-->
<!---->
<!---->
<!--</body>-->
<!--</html>-->