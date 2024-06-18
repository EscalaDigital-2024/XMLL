<?php

$filex = $_FILES['myfile']['tmp_name'];
$xml = simplexml_load_file($filex); 
$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('cfdi', $ns['cfdi']);
$xml->registerXPathNamespace('t', $ns['tfd']);
 
 
//EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA 
foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
      echo "Fecha: " . $cfdiComprobante['Fecha']; 
      echo "<br />"; 
      echo "Importe Factura: " . $cfdiComprobante['Total']; 
      echo "<br />"; 
} 
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
   echo "RFC: " . $Emisor['Rfc']; 
   echo "<br />"; 
   echo "Proveedor: " . $Emisor['Nombre']; 
   echo "<br />"; 
} 
/*
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
   echo $Receptor['Rfc']; 
   echo "<br />"; 
   echo $Receptor['Nombre']; 
   echo "<br />"; 
} 

foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){ 
   echo "<br />"; 
   echo $Concepto['Unidad']; 
   echo "<br />"; 
   echo $Concepto['Importe']; 
   echo "<br />"; 
   echo $Concepto['Cantidad']; 
   echo "<br />"; 
   echo $Concepto['Descripcion']; 
   echo "<br />"; 
   echo $Concepto['ValorUnitario']; 
   echo "<br />";   
   echo "<br />"; 
} 

foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){ 
   echo "Tasa Impuesto: " . $Traslado['Tasa']; 
   echo "<br />"; 
   echo "Total Impuesto: " . $Traslado['Importe']; 
   echo "<br />"; 
   echo "Trasladado: " . $Traslado['Impuesto']; 
   echo "<br />";   
   echo "<br />"; 
} 
*/
foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
   echo "UUID: " . $tfd['UUID']; 
   echo "<br />"; 

}
   $emisor=$Emisor['Rfc'];


   $receptor="GST181129R85";


   $total=$cfdiComprobante['Total'];


   $uuid=$tfd['UUID'];


   $soap = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/"><soapenv:Header/><soapenv:Body><tem:Consulta><tem:expresionImpresa>?re='.$emisor.'&amp;rr='.$receptor.'&amp;tt='.$total.'&amp;id='.$uuid.'</tem:expresionImpresa></tem:Consulta></soapenv:Body></soapenv:Envelope>';


   //encabezados


   $headers = [


   'Content-Type: text/xml;charset=utf-8',


   'SOAPAction: http://tempuri.org/IConsultaCFDIService/Consulta',


   'Content-length: '.strlen($soap)


   ];


   $url = 'https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc';


   $ch = curl_init();


   curl_setopt($ch, CURLOPT_URL, $url);


   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


   curl_setopt($ch, CURLOPT_POST, true);


   curl_setopt($ch, CURLOPT_POSTFIELDS, $soap);


   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


   $res = curl_exec($ch);


   curl_close($ch);


   $xml = simplexml_load_string($res);


   $data = $xml->children('s', true)->children('', true)->children('', true);


   $data = json_encode($data->children('a', true), JSON_UNESCAPED_UNICODE);


   print_r(json_decode($data)); 
?>