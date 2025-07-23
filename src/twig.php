<?php

try {
	require_once realpath(__DIR__ . '/vendor/autoload.php');

	if (!sizeof($argv)) 
		throw new Exception("Invalid number of args.");

	if (!$argv[1])
		throw new Exception("Invalid TWIG template passed.");

	if (!$argv[2])
		throw new Exception("JSON template wasnt pass.");

	$decodedData = json_decode($argv[2], true);

	if (json_last_error() !== JSON_ERROR_NONE)
		throw new Exception("Invalid JSON template passed.");

	$loader = new \Twig\Loader\ArrayLoader(['index' => $argv[1]]);
	$twig = new \Twig\Environment($loader);

	$renderTemplate = $twig->render('index', $decodedData);

	$handler = fopen(__DIR__ . "/output.md", "w");
	$wasWritetable = fwrite($handler, $renderTemplate);
	fclose($handler);

	var_dump($wasWriteblae);

	if (!$wasWritetable)
		throw new Exception("It wasnt possible to write passed template.");

	exit(0);
} catch (Exception $err) {
	echo $err->getMessage();
	exit(1);
}
