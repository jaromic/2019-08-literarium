<?php

session_start();
if (!isset($_SESSION['author'])) {
    $_SESSION['author'] = [];
}

require_once("Model/Author.php");

$siteTitle = 'Literarium';
$pageTitle = 'Übersicht';

$editAuthor = null;

if (isset($_POST['new-author'])) {
    $newAuthor = new Author($_POST['firstname'], $_POST['lastname']);
    $newAuthor->save();
    echo "Autor '{$newAuthor->getFirstname()} {$newAuthor->getLastname()}' hinzugefügt.";
} elseif (isset($_POST['update-author'])) {
    $existingAuthor = Author::find($_POST['id']);
    $existingAuthor->setFirstname($_POST['firstname']);
    $existingAuthor->setLastname($_POST['lastname']);
    $existingAuthor->save();
    echo "Autor '{$existingAuthor->getFirstname()} {$existingAuthor->getLastname()} aktualisiert.";
} elseif (isset($_GET['delete-author'])) {
    $authorToDelete = Author::find($_GET['delete-author']);
    if ($authorToDelete) {
        $authorToDelete->delete();
    }
} elseif (isset($_GET['edit-author'])) {
    $editAuthor = Author::find($_GET['edit-author']);
}

$authors = Author::findAll();

?>
<!doctype html>
<html lang="de">
<head>
    <title><?php echo "{$pageTitle} &ndash; {$siteTitle}" ?></title>
</head>
<body>
<main>
    <h1><?php echo $pageTitle; ?></h1>
    <div>
        <?php if ($editAuthor) { ?>
            <div>
                <h2>Autor bearbeiten</h2>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $editAuthor->getId(); ?>">
                    <input type="text" name="firstname" value="<?php echo $editAuthor->getFirstname(); ?>">
                    <input type="text" name="lastname" value="<?php echo $editAuthor->getLastname(); ?>">
                    <button type="submit" name="update-author">Ändern</button>
                </form>
            </div>
        <?php } else { ?>
        <h2>Autoren</h2>
        <table>
            <tr>
                <th>id</th>
                <th>Vorname</th>
                <th>Nachname</th>
                <th>Löschen</th>
            </tr>
            <?php foreach ($authors as $author) { ?>
                <tr>
                    <td>
                        <?php echo $author->getId(); ?>
                    </td>
                    <td>
                        <a href="?edit-author=<?php echo $author->getId() ?>">
                            <?php echo $author->getFirstname(); ?>
                        </a>
                    </td>
                    <td>
                        <a href="?edit-author=<?php echo $author->getId() ?>">
                            <?php echo $author->getLastname(); ?>
                        </a>
                    </td>
                    <td>
                        <a href="?delete-author=<?php echo $author->getId() ?>">X</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div>
        <h2>Neuer Autor</h2>
        <form method="post">
            <input type="text" name="firstname">
            <input type="text" name="lastname">
            <button type="submit" name="new-author">Hinzufügen</button>
        </form>
    </div>
    <?php } ?>
</main>
</body>
</html>
