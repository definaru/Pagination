<?php
use yii\helpers\Html;
use budyaga_cust\users\models\Pagination;
$this->title = $get->title;
// чтобы вывести пагинацию, нужен следующий код:
?>



<?php Pagination::countPag($get->id); Pagination::getNext($get->id); Pagination::getPrev($get->id);?>
<?=Pagination::getPanel($get->id);?>
