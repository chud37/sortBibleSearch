<?

function varType($str) {
	if(is_numeric($str)) {return false;}	
	if(is_string($str)) {return true;}	
}
function sortBibleSearch($search) {
	$bible = array("BookNumber" => false, "Book" => false, "Chapter" => false, "StartVerse" => false, "EndVerse" => false, "QueryType" => false);
	$books = array(	"Genesis" 		=> array("Gen", "Ge", "Gn"),
			"Exodus"		=> array("Exod", "Ex"),
			"Leviticus"		=> array("Lev", "Lv", "Le"),
			"Numbers"		=> array("Num", "Nm", "Nu"),
			"Deuteronomy"		=> array("Deut", "Dt", "De", "Du"),
			"Joshua"		=> array("Josh", "Jos"),
			"Judges"		=> array("Judg", "Jdg", "Jgs","Jg"),
			"Ruth"			=> array("Ruth", "Ru"),
			"1 Samuel"		=> array("1 Sam", "1Sm", "1Sa"),
			"2 Samuel"		=> array("2 Sam", "2Sm", "2Sa"),
			"1 Kings"		=> array("1 Kgs", "1Kg", "1Ki"),
			"2 Kings"		=> array("2 Kgs", "2Kg", "2Ki"),
			"1 Chronicles"		=> array("1 Chr", "1 Chron", "1Ch"),
			"2 Chronicles"		=> array("2 Chr", "2 Chron", "2Ch"),
			"Ezra"			=> array("Ezra", "Ezr"),
			"Nehemiah"		=> array("Neh", "Ne"),
			"Esther"		=> array("Esth", "Est", "Es"),
			"Job"			=> array("Jb"),
			"Psalms"		=> array("Ps", "Psalm"),
			"Proverbs"		=> array("Prov", "Prv", "Pr"),
			"Ecclesiastes"		=> array("Eccl", "Eccles","Ec"),
			"Song Of Songs"		=> array("Song of Solomon", "Song Of Song", "Song", "SS", "Sg", "So"),
			"Isaiah"		=> array("Isa", "Is"),
			"Jeremiah"		=> array("Jer", "Je"),
			"Lamentations"		=> array("Lam", "La"),
			"Ezekiel"		=> array("Ezek", "Ezk", "Ez", "Eze"),
			"Daniel"		=> array("Dan", "Dn", "Da"),
			"Hosea"			=> array("Hos", "Ho"),
			"Joel"			=> array("Joe", "Jl"),
			"Amos"			=> array("Am"),
			"Obadiah"		=> array("Obad", "Ob"),
			"Jonah"			=> array("Jon"),
			"Micah"			=> array("Mic", "Mi"),
			"Nahum"			=> array("Nah", "Na"),
			"Habakkuk"		=> array("Hab", "Hb"),
			"Zephaniah"		=> array("Zeph", "Zep"),
			"Haggai"		=> array("Hag", "Hg"),
			"Zechariah"		=> array("Zech", "Zec"),
			"Malachi"		=> array("Mal", "Mi"),
			"Matthew"		=> array("Matt", "Mat", "Mt"),
			"Mark"			=> array("Mar", "Mk", "Mr"),
			"Luke"			=> array("Lk", "Lu"),
			"John"			=> array("Jn", "Jo", "Joh"),
			"Acts"			=> array("Acts of the Apostles", "Ac", "Act"),
			"Romans"		=> array("Rom", "Rm", "Ro"),
			"1 Corinthians"		=> array("1 Cor", "1 Co", "1C", "1co"),
			"2 Corinthians"		=> array("2 Cor", "2 Co", "2C", "2co"),
			"Galatians"		=> array("Gal", "Ga"),
			"Ephesians"		=> array("Eph", "Ep"),
			"Philippians"		=> array("Phil", "Php"),
			"Colossians"		=> array("Col", "Co"),
			"1 Thessalonians"	=> array("1 Thess", "1 Thes", "1Th"),
			"2 Thessalonians"	=> array("2 Thess", "2 Thes", "2Th"),
			"1 Timothy"		=> array("1 Tim", "1 Tm", "1 Ti", "1T", "1ti"),
			"2 Timothy"		=> array("2 Tim", "2 Tm", "2 Ti", "2T", "2ti"),
			"Titus"			=> array("Tit", "Ti"),
			"Philemon"		=> array("Phlm", "Philem", "Phm"),
			"Hebrews"		=> array("Heb", "He"),
			"James"			=> array("Jas", "Ja"),
			"1 Peter"		=> array("1 Pet", "1 Pt", "1P", "1pe"),
			"2 Peter"		=> array("2 Pet", "2 Pt", "2P", "2pe"),
			"1 John"		=> array("1 John",  "1 Jn", "1 Jo", "1J", "1jo"),
			"2 John"		=> array("2 John",  "2 Jn", "2 Jo", "2J", "2jo"),
			"3 John"		=> array("3 John",  "3 Jn", "3 Jo", "3J", "3jo"),
			"Jude"			=> array("Ju"),
			"Revelation"		=> array("Rev", "Re", "Rv", "Apoc", "Ap"));
	
	$pos = 1; $scan = ""; $compile = array();
	//Divide into character type groups.	
	$collapse = str_replace(" ","",$search);
	for($x=0;$x<=(strlen($collapse)-1);$x++)
	{	if($x>=1) {if(varType($collapse[$x]) != varType($collapse[$x-1])) {array_push($compile,$scan);$scan = "";}}
		$scan .= $collapse[$x];
		if($x==strlen($collapse)-1) {array_push($compile,$scan);}
	}
	//If the first element is not a number, then it is not a numbered book (AKA 1 John, 2 Kings), So move the position forward.
	if(varType($compile[0])) {$pos=2;}
	foreach($compile as $val)
	{	if(!varType($val)) 
		{	switch($pos) 
			{	case 1: $bible['BookNumber'] = $val; 	break; 		
				case 3: $bible['Chapter'] = $val;		break; 
				case 5: $bible['StartVerse'] = $val; 	break; 
				case 7: $bible['EndVerse'] = $val; 		break; 
			}
		} else {switch($pos) 
			{	case 2: 
					if($bible['BookNumber']) 
						{	$bible['Book'] = $bible['BookNumber']." ".ucwords($val);
						} else {$bible['Book'] = ucwords($val);}
					break; 		
				case 4:		//Colon or 'v'
				case 6: break;	//Dash for verse spanning. 
			}}
		$pos++;
	}
	
	//Double Check Book Name
	$book_verified = false;
	foreach($books as $book => $alternative) {
		if(strtolower(str_replace(" ", "", $bible['Book'])) == (strtolower(str_replace(" ", "", $book)))) {
			$bible['Book'] = $book;
			$book_verified = true;
			break;
		}
		foreach($alternative as $alt) { 
			if(strtolower(str_replace(" ", "", $bible['Book'])) == (strtolower(str_replace(" ", "", $alt)))) {
				$bible['Book'] = $book;
				$book_verified = true;
				break;
			}
		}
	}
	
	if(!$book_verified) $bible['Book'] = false;
	
	
	//Set Query Type for Query Building
	if($bible['StartVerse']=="") 
		{	$bible['QueryType'] = 0; 				//Just the Chapter e.g. John 5
		} else {$bible['QueryType'] = 1;				//Just the one verse e.g. John 5:1 (or)
			if($bible['EndVerse']!="") {$bible['QueryType'] = 2;}	//..Multiple Verses e.g. John 5:1-5
		}
		
	// predump($bible);
	
	// We need at least Book and Chapter to return.
	if((!$bible['Book']) || (!$bible['Chapter'])) {return false;} else {return $bible;}	
}
?>