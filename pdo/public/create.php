<?php
/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $new_user = array(
      "UserID"    => $_POST ['UserID'],
     "FirstName"  => $_POST['FirstName'],
      "LastName"  => $_POST['LastName'],
      "HouseID"  => $_POST['HouseID'],
      "ActivityID"  => $_POST['ActivityID'],
      "LocationID" => $_POST['LocationID']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "Hogwarts",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['FirstName']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h2>Add a user</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="UserID">User ID</label>
    <input type="text" name="UserID" id="UserID">
    <label for="FirstName">First Name</label>
    <input type="text" name="FirstName" id="FirstName">
    <label for="LastName">Last Name</label>
    <input type="text" name="LastName" id="LastName">
    <label for="HouseID">HouseID</label>
    <input type="text" name="HouseID" id="HouseID">
    <label for="ActivityID">ActivityID</label>
    <input type="text" name="ActivityID" id="ActivityID">
    <label for="LocationID">LocationID</label>
    <input type="text" name="LocationID" id="LocationID">
    <input type="submit" name="submit" value="Submit">
  </form>

  <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
