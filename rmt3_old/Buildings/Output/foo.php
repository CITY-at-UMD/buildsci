<?php

	/*if($db= new SQLiteDatabase("mohamamd157.sql")) {
		$q = $db->query('select * from Zones');
		if($q === false) {
			echo 'Could not do this query.';
		} else {
			$result = $q->fetchSingle();
		}
	}
	else { die($err); }*/


/*	$dbhandle = sqlite_open('mohamamd157.sql');
	$result = $dbhandle->arrayQuery('select * from Zones', SQLITE_ASSOC);

	foreach ($result as $entry)
	{
		echo "ZoneName".$entry['ZoneName'];
	}*/
	
	class Foo {
		private function retrieveData() {
			$db = new SQLite3('mohamamd157.sql');

			$result = $db->query('select * from Zones');
			var_dump($result->fetchArray());
		}
	}
	/*while($res = $result->fetchArray(QLITE3)) {
		if(!isset($res['
	}*/

	Foo::retrieveData();
?>
