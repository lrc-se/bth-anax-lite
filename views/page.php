<?php 

if (!empty($msg)) {
    $this->renderView('incl/warning', ['msg' => $msg]);
}

?>
        <h1><?= $app->esc($content->title) ?></h1>
<? $app->renderContent($content) ?>
