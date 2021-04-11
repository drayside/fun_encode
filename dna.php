<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN"
 "http://www.w3.org/TR/REC-html40/strict.dtd">

<HTML>

<HEAD>
<TITLE>String to Line Encoder</TITLE>
<HEAD>
<BODY>
<h1>String to Line Encoder</h1>

<?php $msg = strip_tags($_POST['msg']); ?>

<form action="index.php" method="POST">
Message: <input type="text" name="msg" value="<?php $msg=strip_tags($msg); echo $msg;?>" />
<input type="submit" value="Encode" />
</form>

<p/>


<?php
$msg = strip_tags($msg);

# initialize encoding table
$letter2codons = array(); # string -> list<string>
$letters = range('A', 'Z');
foreach ($letters as $letter) {
    $letter2codons[$letter] = array();
}
$letter2codons["."] = array();

$myfile = fopen("codon.txt", "r") or die("Unable to open file!");
while(!feof($myfile)) {
    $line = fgets($myfile);
    # skip comment lines or empty lines
    if (strlen($line) == 0 or strncmp($line, "#", 1) == 0) {
        continue;
    } else {
        # we have data
        $a = explode("\t", $line);
        #var_dump($a);
        $letter = $a[2];
        $codon = $a[0];
        # append this codon to the list for this letter
        $letter2codons[$letter][] = $codon;
    }
}
fclose($myfile);

#var_dump($letter2codons);

echo $msg . "<br/>";
for ($i=0; $i<strlen($msg); $i++) {
    $letter = $msg[$i];
    $codons = $letter2codons[$letter];
    $count = count($codons);
    if ($count == 0) {
        # letter has no codons
        # use one of the STOP codons
        $codons = $letter2codons['.'];
        $count = count($codons);
    }
    $choice = rand(0, $count-1);
    echo $codons[$choice] . " ";
}
echo "<br/>";

?>

</BODY>
</HTML>
