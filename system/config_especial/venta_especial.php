<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'system/config_especial/Config.php';
include_once 'application/common/Encrypt.php';

?>
<h1 class="h1-responsive">Configuraci&oacuten Especial</h1>
<?php 
echo '<div id="productos">';
Config::VerProductosEspecial($_REQUEST["page"]);
echo '</div>';
?>