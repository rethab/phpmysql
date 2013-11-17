<?php
$this->breadcrumbs=array(
	'Message'=>array('/message'),
	'Hello',
);
?>
<h1>Hello <?= $name ?></h1>
<p><?= CHtml::link('Goodbye', array('message/goodbye')); ?></p>
