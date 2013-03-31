<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

require_once('supa/mediator.php');
$site = new supa_mediator();
$site->getModule('front')->control();
$site->getModule('layout')->render();
?>
<div id="supa-debug">
    <pre>
        <h1>Supa</h1>
        <?php var_dump($site); ?>

        <h1>Configuration</h1>
        <?php var_dump($site->getConfig()); ?>


        <h1>Spine ($_all)</h1>
        <?php var_dump(supa_mediator::$_all); ?>

    </pre>
</div>
