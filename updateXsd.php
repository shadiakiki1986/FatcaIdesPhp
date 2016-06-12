<?php

require __DIR__."/vendor/autoload.php";

#echo "Creating temp dir\n";
#$fnH = tempnam("/tmp","");
#unlink($fnH);
#mkdir($fnH);
$fnH="cache";

echo "Downloading into $fnH\n";
$dl = new \FatcaIdesPhp\Downloader($fnH);
$dl->download();

echo "Converting xsd to php\n";
use com\mikebevz\xsd2php\LegkoXML;
$legko = new LegkoXML();
$schema = $fnH."/FATCA XML Schema v1.1/FatcaXML_v1.1.xsd";
assert(file_exists($schema));
$dest = "src/FatcaXsdPhp";
assert(is_dir($dest));
$legko->compileSchema($schema, $dest);

exec("sed -i 's/<?php/<?php namespace FatcaXsdPhp;/g' $dest/*php"); // $dest/oecd/ties/isofatcatypes/v1/*php $dest/oecd/ties/stf/v4/*php $dest/oecd/ties/stffatcatypes/v1/*php");
echo "Done\n";