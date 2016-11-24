<?
$filename = $_REQUEST[filename];
$path = $_REQUEST[path];

$DownloadPath = "..".$path.$filename; // 파일 경로
$fileTmp = strstr($filename, '^'); // 파일명 임시저장(앞의 '^'를 제거
$DownFile = substr($fileTmp, 2); 

  Header("Content-Type: file/unknown");
  Header("Content-Disposition: attachment; filename=". $filename);
  Header("Content-Length: ".filesize("$DownloadPath"));
  header("Content-Transfer-Encoding: binary ");
  Header("Pragma: no-cache");
  Header("Expires: 0");
  flush();
if ($fp = fopen("$DownloadPath", "r")){ 
	print fread($fp, filesize("$DownloadPath"));
}
fclose($fp);
?>