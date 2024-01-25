<?php

use form\Form;
use form\type\RadioButton;
use form\type\Submit;
use form\type\Text;

require "classes/autoload.php";

$form = new Form("/", Form::GET, "form_id");
$form->addInput((new Text("", true, "user", "user"))->setLabel("Nom"));
$form->addInput((new RadioButton("test1", true, "id", "test1"))->setLabel("Test 1"));
$form->addInput((new RadioButton("test1", true, "id", "test2"))->setLabel("Test 2"));

$form->addInput(new Submit("Valider"));

echo $form;