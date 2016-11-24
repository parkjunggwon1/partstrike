

    <?php
    $file = 'http://pjg0319.cafe24.com/upload/file/20161121093712_.pdf';
    $filename = 'http://pjg0319.cafe24.com/upload/file/20161121093712_.pdf'; /* Note: Always use .pdf at the end. */

    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="'.$filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file));
    header('Accept-Ranges: bytes');

    @readfile($file);
    ?> 
 
<iframe src="test.php" style="width:718px; height:900px;" frameborder="0"></iframe>