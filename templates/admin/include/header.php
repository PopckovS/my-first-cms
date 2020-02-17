<div id="adminHeader">
    <h2>Widget News <?php echo htmlspecialchars( $_SESSION['username']) ?></h2>
    <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>.
        <a href="admin.php?action=listArticles">Edit Articles</a> 
        <a href="admin.php?action=listCategories">Edit Categories</a> 
        <a href="admin.php?action=listUsers">Edit Users</a> 
        <a href="admin.php?action=listSubCategories">Edit SubCategories</a> 
        <a href="admin.php?action=logout"?>Log Out</a>
    </p>
</div>
