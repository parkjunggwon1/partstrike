<?
$str = "JP001&A 01";
$top_part_no = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "",$str);
echo $top_part_no;
?>