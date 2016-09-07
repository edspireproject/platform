<?php 
if(!isset($_GET['provider']))
	die();
$provider = $_GET['provider'];
if(! preg_match("/^[a-zA-Z0-9]+$/", $provider) == 1)
	die();

ob_end_clean();

$fh = fopen('php://output', 'w');

fwrite($fh, '<?xml version="1.0" encoding="utf-8" ' . '?' . '>');
fwrite($fh, "\n");
fwrite($fh, '<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"');
fwrite($fh, "\n");
fwrite($fh, '         xmlns="http://purl.org/rss/1.0/"');
fwrite($fh, "\n");
fwrite($fh, '         xmlns:dc="http://purl.org/dc/elements/1.1/"');
fwrite($fh, "\n");
fwrite($fh, '         xmlns:enc="http://purl.oclc.org/net/rss_2.0/enc#"');
fwrite($fh, "\n");
fwrite($fh, '         xmlns:media="http://search.yahoo.com/mrss/"');
fwrite($fh, "\n");
fwrite($fh, '         xmlns:nj="http://edspire.com/resources/1.0/">');
fwrite($fh, "\n");
fwrite($fh, '	<channel rdf:about="http://edspire.com/resources/1.0/">');
fwrite($fh, "\n");
fwrite($fh, '	   <link>http://impex/ocw/ocw2rss.php?provider=' . $provider .'</link>');
fwrite($fh, "\n");
fwrite($fh, '	</channel>');
fwrite($fh, "\n");

//OCW Link	URL Hash	Link	Provider	Language	Tags	Author	Title	Description
$tags = array('ignore', 'ignore', 'link', 'nj:university', 'nj:language', 'nj:subjects', 'dc:creator', 'title', 'description', 'ignore', 'ignore', 'ignore');
$row = 1;
if (($handle = fopen("/home/tomcat/data/ocw/" . $provider . ".csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
        $num = count($data);
        $num = $num > 12 ? 12 : $num;
        if($row>1) {
			fwrite($fh, "<item>\n");
        	for ($c=0; $c < $num; $c++) {
				if( $tags[$c] != 'ignore' ) {
					if( $tags[$c] == 'nj:subjects' ) {
						$subjects = split(';', $data[$c]);
						foreach( $subjects as $subject ) {
							fwrite($fh, "<nj:subject>" . htmlspecialchars(xmlspecialchars(trim($subject)), ENT_QUOTES, "UTF-8") . "</nj:subject>\n");
						}
					} elseif( $tags[$c] == 'dc:creator' ) {
						$creators = split(';', $data[$c]);
						foreach( $creators as $creator ) {
							fwrite($fh, "<" . $tags[$c] . ">" . htmlspecialchars(xmlspecialchars(trim($creator)), ENT_QUOTES, "UTF-8") . "</" . $tags[$c] . ">\n");
						}
					} elseif($tags[$c] == 'description' ) {
						fwrite($fh, "<" . $tags[$c] . "><![CDATA[" . htmlspecialchars(xmlspecialchars($data[$c]), ENT_QUOTES, "UTF-8") . "]]></" . $tags[$c] . ">\n");
					} else {
	            		fwrite($fh, "<" . $tags[$c] . ">" . htmlspecialchars(xmlspecialchars($data[$c]), ENT_QUOTES, "UTF-8") . "</" . $tags[$c] . ">\n");
	            	}
	            }
    	    }
    	    echo "</item>\n";
    	}
        $row++;
    }
    fclose($handle);
}

function xmlspecialchars($unclean) {
	$pattern = '/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u';
	return preg_replace($pattern, '', $unclean);
}

fwrite($fh, '</rdf:RDF>');

fclose($fh);

exit;
?>