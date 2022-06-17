<?php

// cut & paste from symfony project so might not work as-is

use Flow\Runner;
use Flow\Node\RandomNumberNode;
use Flow\Node\CodeNode;
use Flow\Node\DumpNode;
use Flow\Node\AdderNode;
use Flow\Node\SubtractorNode;


$runner = new Runner();

$random1 = new RandomNumberNode('rand 1');
$random2 = new RandomNumberNode('rand 2');
$random3 = new RandomNumberNode('rand 3');
$runner->addNode($random1);
$runner->addNode($random2);
$runner->addNode($random3);

$code = new CodeNode('codenode');
$random1->addNode($code, ['number' => 'foo']);
$code->addNode(new DumpNode('codedump'), ['bar' => 'input']);

$adder = new AdderNode('adder');
$random1->addNode($adder, ['number' => 'number1']);
$random2->addNode($adder, ['number' => 'number2']);

$subber = new SubtractorNode('subber');
$adder->addNode($subber, ['result' => 'number1']);
$random3->addNode($subber, ['number' => 'number2']);


$dumper = new DumpNode('dump');
$adder->addNode($dumper, ['result' => 'input']);

$dumper2 = new DumpNode('dump2');
$subber->addNode($dumper2, ['result' => 'input']);

$runner->run();
