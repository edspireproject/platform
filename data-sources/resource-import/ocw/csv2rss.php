<?php 
if(!isset($_GET['provider']))
	die();
$provider = $_GET['provider'];
if(! preg_match("/^[a-zA-Z0-9]+$/", $provider) == 1)
	die();

echo ('<?xml version="1.0" encoding="utf-8" ' . '?' . '>'); echo "\n"; ?>
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
         xmlns="http://purl.org/rss/1.0/"
         xmlns:dc="http://purl.org/dc/elements/1.1/"
         xmlns:enc="http://purl.oclc.org/net/rss_2.0/enc#"
         xmlns:media="http://search.yahoo.com/mrss/"
         xmlns:nj="http://edspire.com/resources/1.0/">
	<channel rdf:about="http://edspire.com/resources/1.0/">
	   <link>http://impex/ocw/csv2rss.php?provider=<?php echo $provider; ?></link>
	</channel>
<?php
//NAME	PROVIDER	Link on provider site	TEACHER(S)	UNIVERSITY	INTRO VIDEO/PREVIEW	EXCERPT OF CONTENT	DATE/ALWAYS AVAILABLE – LENGTH	WORKLOAD	DIFFICULTY	Category	Cost
// "ID","ISBN","Title","Title-Level URL","Author(s)","Editor(s)","Publisher","Date Published","Edition","Subject Terms","Summary","Page Count","Language","Discipline"
$tags = array('ignore', 'ignore', 'title', 'link', 'dc:creator', 'ignore', 'ignore', 'nj:availability', 'ignore', 'nj:subjects', 'description', 'nj:pagecount', 'nj:language', 'nj:subject');
$row = 1;
if (($handle = fopen("/home/tomcat/data/ocw/" . $provider . ".csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $num = $num > 14 ? 14 : $num;
        if($row>1) {
			echo "<item>\n";
        	for ($c=0; $c < $num; $c++) {
				if( $tags[$c] != 'ignore' ) {
					if( $tags[$c] == 'nj:subjects' ) {
						$subjects = split(';', $data[$c]);
						foreach( $subjects as $subject ) {
							echo "<nj:subject>" . htmlspecialchars(trim($subject), ENT_QUOTES, "UTF-8") . "</nj:subject>\n";
						}
					} elseif( $tags[$c] == 'dc:creator' ) {
						$creators = split(';', $data[$c]);
						foreach( $creators as $creator ) {
							echo "<" . $tags[$c] . ">" . trim($creator) . "</" . $tags[$c] . ">\n";
						}
					} elseif($tags[$c] == 'description' ) {
						echo "<" . $tags[$c] . "><![CDATA[" . htmlspecialchars($data[$c], ENT_QUOTES, "UTF-8") . "]]></" . $tags[$c] . ">\n";
					} else {
	            		echo "<" . $tags[$c] . ">" . htmlspecialchars($data[$c], ENT_QUOTES, "UTF-8") . "</" . $tags[$c] . ">\n";
	            	}
	            }
    	    }
    	    echo "</item>\n";
    	}
        $row++;
    }
    fclose($handle);
}

?>
</rdf:RDF>