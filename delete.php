<?php
if (isset($_GET['file']) && isset($_GET['user_id'])) {
    $file = $_GET['file'];
    $user_id = $_GET['user_id'];
    $filePath = 'uploads/' . $user_id . '/' . $file;

    if (file_exists($filePath)) {
        unlink($filePath);
        echo "<script>alert('Arquivo excluído com sucesso!');</script>";
    } else {
        echo "<script>alert('Arquivo não encontrado.');</script>";
    }
}
header('Location: upload.php');
exit();
?>
