<?php


include "grandTotal1.php";
function loadData($insertedBoqID = null, $insertCategoryId = null, $insertSubcategoryId = null)
{
    ob_start();
    $tbodyTR = "";
    $categoryId = '';

    if (is_null($insertedBoqID)) {
        $tbodyTR .= "Empty Project Id";
        return $tbodyTR;
    } else {
        $sql = "SELECT BoqCategoryID FROM tblboqcategory WHERE BoqID='$insertedBoqID'";
        $result = @mysql_query($sql);
        if ($category = @mysql_fetch_array($result)) {
            $categoryId = $category['BoqCategoryID'];
        }
    }

    if (is_null($insertCategoryId) && is_null($categoryId)) {
        $tbodyTR .= "Empty Category";
        return $tbodyTR;
    } else {
        $sql = "SELECT * FROM tblboqcategory WHERE BoqID='$insertedBoqID' ORDER BY BoqCategoryID ASC";
        $result = @mysql_query($sql);

        $romanNumerals = [
            "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X",
            "XI", "XII", "XIII", "XIV", "XV", "XVI", "XVII", "XVIII", "XIX", "XX",
            "XXI", "XXII", "XXIII", "XXIV", "XXV", "XXVI", "XXVII", "XXVIII", "XXIX", "XXX",
            "XXXI", "XXXII", "XXXIII", "XXXIV", "XXXV", "XXXVI", "XXXVII", "XXXVIII", "XXXIX", "XL",
            "XLI", "XLII", "XLIII", "XLIV", "XLV", "XLVI", "XLVII", "XLVIII", "XLIX", "L"
        ];

        $categoryLoop = 1;

        while ($category = @mysql_fetch_array($result)) {
            $categoryId = $category["BoqCategoryID"];
            $romanCount = $romanNumerals[$categoryLoop - 1];
            $categoryRowId = 'category-row-' . $categoryLoop;
            $subCostRow = 'subcategory-cost-row-' . $categoryLoop;

            // Category TR
            $tbodyTR .= "<tr id='$categoryRowId' style='background-color: cadetblue' class='category-tr'>
                <td style='background-color: #5FB786; font-weight: bold;'>$romanCount</td>
                <td style='background-color: #5FB786; font-weight: bold;'>
                    <input style='background-color: #92F6BE; width: 100%; font-weight: bold; border: 2px solid #90A4AE;'
                           type='text'
                           class='form-control categoryInput'
                           data-project_id='$insertedBoqID'
                           data-category_id='$categoryId'
                           data-category_row_id='$categoryRowId'
                           placeholder='Category'
                           value='{$category['CategoryName']}'
                    />
                </td>
                <td colspan='5' style='background-color: #5FB786'>
                    <div style='display: flex; align-items: center; gap: 10px; float:right;'>
                        <div>
                            <button style='background-color: #17C664; color:white; border:none' type='button' class='material-icons addNewCategory' value='$insertedBoqID'>add_circle</button>
                        </div>
                        <div>
                            <span class='material-icons deleteCategoryRow'
                                  data-project_id='$insertedBoqID'
                                  data-category_row_id='$categoryRowId'
                                  data-category_id='$categoryId'>
                                remove_circle
                            </span>
                        </div>
                    </div>
                </td>
            </tr>";

            // Subcategory
            $sub_sql = "SELECT * FROM tblboqsubcategory WHERE BoqCategoryID = '$categoryId' ORDER BY BoqSubcategoryID ASC";
            $sub_result = @mysql_query($sub_sql);
            $subcategoryLoop = 1;
            $subCategoryTotalCost = 0;

            while ($subcategory = @mysql_fetch_array($sub_result)) {
                $subcategoryId = $subcategory["BoqSubcategoryID"];
                $rowId = 'subcategory-row-' . $subcategoryId;
                $rate = $subcategory["SubcategoryRate"];
                $qty = $subcategory["SubcategoryQty"];
                $rate = ($rate <= 0) ? 0 : $rate;
                $qty = ($qty <= 0) ? 0 : $qty;

                $cost = $rate * $qty;
                $subcategoryCost = number_format($cost, 2, '.', '');
                $subCategoryTotalCost += $cost;

                $unit = '';
                if (isset($subcategory['SubcategoryUnit'])) {
                    $unit = in_array(strtolower($subcategory['SubcategoryUnit']), ['m3', 'm^3']) ? "m&#179;" : $subcategory['SubcategoryUnit'];
                }

                $tbodyTR .= "<tr id='$rowId' class='subcategory-tr'>
                    <td>" . $subcategoryLoop . ".</td>
                    <td><input type='text' class='form-control subcategoryInput SubcategoryName'
                               data-project_id='$insertedBoqID'
                               data-category_id='$categoryId'
                               data-sub_category_id='$subcategoryId'
                               data-columnName='SubcategoryName'
                               data-category_row_id='$categoryRowId'
                               data-subCostRow='$subCostRow'
                               data-sub_category_row_id='$rowId'
                               placeholder='Sub Name'
                               value='{$subcategory['SubcategoryName']}'
                               style='border: 2px solid #90A4AE' /></td>
                    <td><input type='text' class='form-control subcategoryInput SubcategoryUnit'
                               data-project_id='$insertedBoqID'
                               data-category_id='$categoryId'
                               data-sub_category_id='$subcategoryId'
                               data-columnName='SubcategoryUnit'
                               data-category_row_id='$categoryRowId'
                               data-subCostRow='$subCostRow'
                               data-sub_category_row_id='$rowId'
                               placeholder='Unit'
                               value='$unit'
                               style='border: 2px solid #90A4AE' /></td>
                    <td><input type='text' class='form-control subcategoryInput SubcategoryQty'
                               data-project_id='$insertedBoqID'
                               data-category_id='$categoryId'
                               data-sub_category_id='$subcategoryId'
                               data-columnName='SubcategoryQty'
                               data-category_row_id='$categoryRowId'
                               data-subCostRow='$subCostRow'
                               data-sub_category_row_id='$rowId'
                               placeholder='Number'
                               value='{$subcategory['SubcategoryQty']}'
                               style='border: 2px solid #90A4AE' /></td>
                    <td><input type='text' class='form-control subcategoryInput SubcategoryRate'
                               data-project_id='$insertedBoqID'
                               data-category_id='$categoryId'
                               data-sub_category_id='$subcategoryId'
                               data-columnName='SubcategoryRate'
                               data-category_row_id='$categoryRowId'
                               data-subCostRow='$subCostRow'
                               data-sub_category_row_id='$rowId'
                               placeholder='Number'
                               value='{$subcategory['SubcategoryRate']}'
                               style='border: 2px solid #90A4AE' /></td>
                    <td><input type='text' class='form-control subcategoryCost'
                               data-project_id='$insertedBoqID'
                               data-category_id='$categoryId'
                               data-subCostRow='$subCostRow'
                               data-category_row_id='$categoryRowId'
                               data-sub_category_row_id='$rowId'
                               value='$subcategoryCost'
                               style='border: 2px solid #90A4AE' readonly /></td>
                    <td>
                        <div style='display: flex; align-items: center; gap: 10px;'>
                            <span class='material-icons addSubcategoryRow'
                                  data-project_id='$insertedBoqID'
                                  data-sub_category_row_id='$rowId'
                                  data-category_id='$categoryId'>add_circle</span>
                            <span class='material-icons deleteSubcategoryRow'
                                  data-project_id='$insertedBoqID'
                                  data-sub_category_row_id='$rowId'
                                  data-category_id='{$category["BoqCategoryID"]}'
                                  data-subcategory_id='{$subcategory['BoqSubcategoryID']}'>remove_circle</span>
                        </div>
                    </td>
                </tr>";

                $subcategoryLoop++;
            }

            // Total row for this category
            $tbodyTR .= "<tr id='$subCostRow'>
                <td colspan='5' align='right'><b>Total Cost: </b></td>
                <td style='text-align: center;'><span class='subcategoryTotal' data-project_id='$insertedBoqID'>" . number_format($subCategoryTotalCost, 2) . " /=</span></td>
            </tr>";

            $categoryLoop++;
        }

        // Grand total row
        $grandTotal = grandTotal($insertedBoqID); // You must ensure this function is available
        $tbodyTR .= "<tr id='grandTotalRow'>
            <td colspan='5' align='right' style='background-color:#17C664'><b>Grand Total Cost: </b></td>
            <td style='background-color: #17C664; text-align: center;'><span id='grandTotal' data-project_id='$insertedBoqID'>" . number_format($grandTotal, 2) . " /=</span></td>
        </tr>";


        ob_end_clean();
        return $tbodyTR;
    }
}

