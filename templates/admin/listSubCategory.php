<?php


?>

<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>
	  
            <h1>Article Sub Categories</h1>
	  
	<?php if ( isset( $results['errorMessage'] ) ) { ?>
	        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
	<?php } ?>
	  
	  
	<?php if ( isset( $results['statusMessage'] ) ) { ?>
	        <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
	<?php } ?>
	  
            <table>
                <tr>
                    <th>Name</th>
                    <th>Parent Category</th>
                </tr>

        <?php foreach ( $results['subCategory'] as $subCategory ) { ?>

                <tr onclick="location='admin.php?action=editSubCategory&amp;subCategoryId=<?php echo $subCategory->id?>'">
                    <td>
                        <?php echo $subCategory->name?>
                    </td>
                    <td>
                        <?php echo $subCategory->categoryId?>
                    </td>
                </tr>

        <?php } ?>

            </table>

            <p><?php echo $results['totalRows']?> categor<?php echo ( $results['totalRows'] != 1 ) ? 'ies' : 'y' ?> in total.</p>

            <p><a href="admin.php?action=newSubCategory">Add a New Sub Category</a></p>
	  
	<?php include "templates/include/footer.php" ?>
