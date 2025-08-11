$(document).ready(function() {
    // Handle category deletion
    $(document).on('click', '.deleteCategoryRow', function() {
        if (confirm('Are you sure you want to delete this category and all its subcategories?')) {
            const categoryId = $(this).data('category_id');
            const BoqID = $(this).data('project_id');
            const categoryRowId = $(this).data('category_row_id');
            
            $.ajax({
                url: 'delete-category.php',
                type: 'POST',
                data: {
                    category_id: categoryId,
                    project_id: BoqID
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Remove the category row and all its subcategories
                        $(`#${categoryRowId}`).nextUntil('tr.category-tr').remove();
                        $(`#${categoryRowId}`).remove();
                        
                        // Update grand total
                        updateGrandTotal(BoqID);
                        
                        alert('Category deleted successfully');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error occurred while deleting category');
                }
            });
        }
    });
    
    // Function to update grand total
    function updateGrandTotal(BoqID) {
        $.ajax({
            url: 'get-grand-total.php',
            type: 'POST',
            data: { project_id: BoqID },
            success: function(total) {
                $('#grandTotal').text(total + ' /=');
            }
        });
    }
}); 