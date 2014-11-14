<?php
// search if a string is at the end of another string
function endsWith($haystack, $needle){
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
}
//Return if the filename $entry is to be considered or not
function test_extension ($Entry){
	$found=false;
	//list of autorised extensions
	$autorized_extensions_str=".htm|.html";
	$autorized_extensions = explode ("|",$autorized_extensions_str);
	//list of filenames of the good extension but that we don't want to modify
	$exception_endofname_str="test3.html";
	$exception_endofname = explode ("|",$exception_endofname_str);
	//list of names that we don't want to find in the filename of the files to modifiy
	$exception_wordinname_str="name1|name2";
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
//List all the files that need to be modified and run the modification
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
// Insert the text in the good place in the file, only if necessary
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

// main program_______________________________________________
if ($argc != 5) {
    die("Usage: insertBefore.php <directory_source> <TextControl> <TextToSearch> <TextToBeInserted>\n".
	"<TextControl> est une chaine dont on verifie la presence pour eviter d'inserer plusieurs fois le contenu\n".
	"<TextToSearch> est le texte avant lequel on veut inserer du contenu\n".
	"<TextToBeInserted> est le texte à inserer\n\n
	Use: insertBefore.php <directory_source> <TextControl> <TextToSearch> <TextToBeInserted>\n".
	"<TextControl> is a string that we test le presence in the files, avoiding multiple insertion if the script is called many times\n".
	"<TextToSearch> is the string before which we want to insert our content\n".
	"<TextToBeInserted> is the text to be inserted\n\n");
}

$SourceDir=$argv[1];
$TextControl= $argv[2];
$TextToSearch= $argv[3];
$TextToAdd=$argv[4];

chdir($SourceDir);

ScanDirectory('.',$TextControl, $TextToSearch, $TextToAdd);


?>