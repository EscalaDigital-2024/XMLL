<?
$conn = mysqli_connect("localhost", "root", "", "xmlx");

$affectedRow = 0;



$filex = $_FILES['myfile']['tmp_name'];

//$xml = simplexml_load_file($filex) or die("Error: Cannot create object");

$factura = simplexml_load_file($filex);
$namespaces = $factura -> getNamespaces(true);
$factura -> registerXPathNamespace('e', $namespaces['cfdi']);23

foreach ($factura -> xpath('//e:Concepto') as $m) {
    echo($m['Cantidad']." <br/>");
    echo($m['Unidad']." <br/>");
    echo($m['Descripcion']." <br/>");
    echo($m['ValorUnitario']." <br/>");
    echo($m['Importe']." <br/>"); 
}
/*
foreach ($xml->children() as $row) {
    $title = $row->title;
    $link = $row->link;
    $description = $row->description;
    $keywords = $row->keywords;
    
    $sql = "INSERT INTO tbl_tutorials(title,link,description,keywords) VALUES ('" . $title . "','" . $link . "','" . $description . "','" . $keywords . "')";
    
    $result = mysqli_query($conn, $sql);
    
    if (! empty($result)) {
        $affectedRow ++;
    } else {
        $error_message = mysqli_error($conn) . "n";
    }
}*/


?>
<h2>Insert XML Data to MySql Table Output</h2>
<?php
if ($affectedRow > 0) {
    $message = $affectedRow . " records inserted";
} else {
    $message = "No records inserted";
}

?>