<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */

require "../models/User.php";
require "../managers/AbstractManager.php";
require "../managers/UserManager.php";

$manager = new UserManager();

echo "<h2>Test 1 : create a UserManager instance :</h2>";
echo "<p>The first warning is normal, let's retry with the second file path</p>";

if(($manager instanceof UserManager) && ($manager->getDb() instanceof PDO))
{
    echo "<p style='color:green'>Test 1 Successful</p>";
}
else
{
    echo "<p style='color:red'>Test 1 failed</p>";
}


echo "<h2>Test 2 : create a User :</h2>";

$password = password_hash("test", PASSWORD_BCRYPT);
$user = new User("Test User", "test-user@test.fr", $password, "USER", new DateTime());

$manager->create($user);

if($user->getId() !== null)
{
    echo "<p style='color:green'>Test 2 Successful</p>";
}
else
{
    echo "<p style='color:red'>Test 2 failed</p>";
}

echo "<h2>Test 3 : récupérer un User depuis la database</h2>";

$userFromDb = $manager->findOne($user->getEmail());

if($userFromDb->getId() !== null && $userFromDb->getUsername() === $user->getUsername())
{
    echo "<p style='color:green'>Test 3 Successful</p>";
}
else
{
    echo "<p style='color:red'>Test 3 failed</p>";
}

