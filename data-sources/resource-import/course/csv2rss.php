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
	   <link>http://impex/course/csv2rss.php?provider=<?php echo $provider; ?></link>
	</channel>
<?php
//NAME	PROVIDER	Link on provider site	TEACHER(S)	UNIVERSITY	INTRO VIDEO/PREVIEW	EXCERPT OF CONTENT	DATE/ALWAYS AVAILABLE – LENGTH	WORKLOAD	DIFFICULTY	Category	Cost
$tags = array('title', 'nj:provider', 'link', 'dc:creator', 'nj:university', 'nj:intro', 'description', 'nj:availability', 'nj:workload', 'dc:audience', 'nj:subject', 'nj:cost');
$row = 1;
if (($handle = fopen("/home/tomcat/data/course/" . $provider . ".csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $num = $num > 12 ? 12 : $num;
        if($row>1) {
			echo "<item>\n";
        	for ($c=0; $c < $num; $c++) {
				if( $tags[$c] != 'ignore' ) {
					if( $tags[$c] == 'dc:creator' ) {
						$creators = split(',', $data[$c]);
						foreach( $creators as $creator ) {
							echo "<" . $tags[$c] . ">" . trim($creator) . "</" . $tags[$c] . ">\n";
						}
					} else {
	            		echo "<" . $tags[$c] . ">" . htmlspecialchars($data[$c]) . "</" . $tags[$c] . ">\n";
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