<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * 
            FROM Hogwarts
            WHERE LocationID = :LocationID"; 

    $Location = $_POST['LocationID'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':LocationID', $Location, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>
        
<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table>
      <thead>
        <tr>
          
          <th>UserID</th>
          <th>FirstName</th>
          <th>LastName</th>
          <th>HouseID</th>
          <th>ActivityID</th>
          <th>LocationID</th>
          
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["UserID"]); ?></td>
          <td><?php echo escape($row["FirstName"]); ?></td>
          <td><?php echo escape($row["LastName"]); ?></td>
          <td><?php echo escape($row["HouseID"]); ?></td>
          <td><?php echo escape($row["ActivityID"]); ?></td>
          <td><?php echo escape($row["LocationID"]); ?></td>
          
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['LocationID']); ?>.</blockquote>
    <?php } 
} ?> 

<h2>Find user based on location</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="LocationID">Location</label>
  <input type="text" id="LocationID" name="LocationID">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>