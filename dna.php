<?php
if (isset($msg)) {
    # msg was set by including script
    $msg = strtoupper(strip_tags($msg));
    $BR = "<BR/>";
} else {
    # read msg from command line
    $msg = strtoupper(strip_tags($argv[1]));
    $BR = "\n";
}

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
        if (strlen($letter) > 1) {
            # stop codon that encodes more than one letter
            $subletters = str_split($letter);
            foreach ($subletters as $sublet) {
                $sublet = strtoupper($sublet);
                $letter2codons[$sublet][] = $codon;
            }
        } else {
            # regular case: just one letter
            $letter2codons[$letter][] = $codon;
        }
    }
}
fclose($myfile);

#var_dump($letter2codons);

echo $msg . $BR;
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
echo $BR;

?>
