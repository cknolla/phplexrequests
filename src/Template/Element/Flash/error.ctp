<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>

<div class="alert alert-danger showAlert"><?= $message ?></div>