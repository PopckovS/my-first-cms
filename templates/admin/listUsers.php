
<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>
      
            <h1>Users Categories</h1>
      
    <?php if ( isset( $results['errorMessage'] ) ) { ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
    <?php } ?>
      
      
    <?php if ( isset( $results['statusMessage'] ) ) { ?>
            <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
    <?php } ?>
      

            <table>
                <tr>
                    <th>User</th>
                    <th>Password</th>
                    <th>active</th>
                </tr>


        <?php foreach ( $results['users'] as $user ) { ?>

                <tr onclick="location='admin.php?action=editUser&amp;userId=<?php echo $user->id ?>'">
                    <td>
                        <?php 
                            echo $user->login;
                        ?>
                    </td>

                     <td>
                        <?php 
                            echo $user->password;
                        ?>
                    </td>

                     <td>
                        <?php 
                            echo $user->active;
                        ?>
                    </td>

                </tr>

        <?php } ?>

            </table>


            <p><?php echo $results['totalRows']?> users<?php echo ( $results['totalRows'] != 1 ) ? 'ies' : 'y' ?> in total.</p>

            <p><a href="admin.php?action=newUser">Add a New User</a></p>
      
    <?php include "templates/include/footer.php" ?>
