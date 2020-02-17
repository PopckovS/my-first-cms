
<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>

        <h1><?php echo $results['pageTitle']?></h1>

        <form action="admin.php?action=<?php echo $results['formAction']?>" method="post"> 
          <!-- Обработка формы будет направлена файлу admin.php ф-ции newCategory либо editCategory в зависимости от formAction, сохранённого в result-е -->
        <input type="hidden" name="userId" value="<?php echo $results['user']->id ?>"/>

    <?php if ( isset( $results['errorMessage'] ) ) { ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
    <?php } ?>


        <ul>
          <li>
            <label for="login">User Login</label>
            <input type="text" name="login" id="login" placeholder="Login of the user" required autofocus maxlength="255" 
            value="<?php echo $results['user']->login ?>"/>
          </li>


          <li>
            <label for="password">Password</label>
            <input type="text" name="password" id="password" placeholder="Password of the user" required autofocus maxlength="255" 
           value="<?php echo $results['user']->password ?>"/>
          </li>

          <li>
              <label for="content">Active</label>
              <?php 

              if ($results['user']->active == 1) {
                echo "-Yes<input type='radio' name='active' checked='checked'  value='1'>";
                echo "-No<input type='radio'  name='active' value='0'>";
              }else{
                echo "-Yes<input type='radio' name='active' value='1'>";
                echo "-No<input type='radio' name='active' checked='checked'  value='0'>";
              }

              ?>

          </li>
        </ul>


        <div class="buttons">
          <input type="submit" name="saveChanges" value="Save Changes" />
          <input type="submit" formnovalidate name="cancel" value="Cancel" />
        </div>

      </form>

    <?php if ( $results['user']->id ) { ?>
          <p><a href="admin.php?action=deleteUser&amp;userId=<?php echo $results['user']->id ?>" onclick="return confirm('Delete This User?')">
                  Delete This User
              </a></p>
    <?php } ?>

<?php include "templates/include/footer.php" ?>

