<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

define('DS', DIRECTORY_SEPARATOR);
define('_', '_');
define('PHP', '.php');

date_default_timezone_set('America/New_York');
require_once('supa/mediator.php');
$site = new supa_mediator();
$site->getModule('do')->action();
$site->getModule('front')->control();
$site->getModule('response')->render();
?>

<?php if($site->model('panels/users')->isLoggedIn()): ?>
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
<?php endif; ?>
