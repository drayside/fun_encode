<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN"
 "http://www.w3.org/TR/REC-html40/strict.dtd">

<HTML>

<HEAD>
<TITLE>String to DNA Encoder</TITLE>
<HEAD>
<BODY>
<h1>String to DNA Encoder</h1>

<?php $msg = strip_tags($_POST['msg']); ?>

<form action="dna-web.php" method="POST">
Message: <input type="text" name="msg" value="<?php $msg=strip_tags($msg); echo $msg;?>" />
<input type="submit" value="Encode" />
</form>

<p/>


<?php
    $msg = strip_tags($msg);
    include 'dna.php';
?>

</BODY>
</HTML>
