<?php

function endsWith($haystack, $needle){
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}
function test_extension ($Entry){
	$found=false;
	//liste des extensions de fichiers autorisées
	$autorized_extensions_str=".htm|.html";
	$autorized_extensions = explode ("|",$autorized_extensions_str);
	//liste des noms de fichiers à supprimer
	$exception_endofname_str="links.html";
	$exception_endofname = explode ("|",$exception_endofname_str);
	//liste des noms de fichiers partiels à supprimer
	$exception_wordinname_str="google";
	$exception_wordinname = explode ("|",$exception_wordinname_str);
	foreach ($autorized_extensions as $ext) {
		if (endswith(strtolower($Entry),$ext)) {
			$found=true;
		}
	}
	foreach ($exception_endofname as $end) {
		if (endswith(strtolower($Entry),$end)) {
			echo "refus : ".$Entry."\n";
			$found=false;
		}
	}
	foreach ($exception_wordinname as $word) {
		if (strpos(strtolower($Entry),$word) !== false) {
			echo "refus : ".$Entry."\n";
			$found=false;
		}
	}
	return $found;
}
function ScanDirectory($Directory,$TextControl, $TextToSearch, $TextToAdd){
  $MyDirectory = opendir($Directory) or die('Erreur');
	while($Entry = @readdir($MyDirectory)) {
		if(is_dir($Directory.'/'.$Entry)&& $Entry != '.' && $Entry != '..') {
			ScanDirectory($Directory.'/'.$Entry,$TextControl, $TextToSearch, $TextToAdd);
		}
		elseif (test_extension(strtolower($Entry))){
			AddContentBefore($Directory.'/'.$Entry,$TextControl, $TextToSearch, $TextToAdd);
        }
	}
  closedir($MyDirectory);
}
function AddContentBefore ($filename,$TextControl, $TextToSearch, $TextToAdd){
	$handle = fopen($filename, "r");
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	if (strpos ($contents,$TextControl) === false) {
		$file = file_get_contents($filename);
		file_put_contents($filename, str_replace($TextToSearch,$TextToAdd.$TextToSearch,$file));
	}



echo $filename."\n";


}

// debut du programme principal_______________________________________________

$SourceDir=$argv[1];
$TextControl= $argv[2];
$TextToSearch= $argv[3];
$TextToAdd=$argv[4];

chdir($SourceDir);

ScanDirectory('.',$TextControl, $TextToSearch, $TextToAdd);


?>