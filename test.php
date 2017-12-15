<?php
// สร้าง object 
$client = new SoapClient("http://www.pttplc.com/webservice/pttinfo.asmx?WSDL", // URL ของ webservice
		    	array(
			           "trace"      => 1,		// enable trace to view what is happening
			           "exceptions" => 0,		// disable exceptions
			          "cache_wsdl" => 0) 		// disable any caching on the wsdl, encase you alter the wsdl server
		           );
               


         // ตัวแปลที่ webservice ต้องการสำหรับ GetOilPriceResult เป็นวันเดือนปีและ ภาษา  
               $params = array(
                   'Language' => "en",
                   'DD' => date('d'),
                   'MM' => date('m'),
                   'YYYY' => date('Y')
               );

              // เรียกใช้ method GetOilPrice และ ใส่ตัวแปลเข้าไป 
              $data = $client->GetOilPrice($params);
              
              //เก็บตัวแปลผลลัพธ์ที่ได้
              $ob = $data->GetOilPriceResult;
              
             // เนื่องจากข้อมูลที่ได้เป็น string(ในรูปแบบ xml) จึงต้องแปลงเป็น object ให้ง่ายต่อการเข้าถึง
              $xml = new SimpleXMLElement($ob);
           
             // attr  PRICE_DATE , PRODUCT ,PRICE
            //loop เพื่อแสดงผล  
            foreach ($xml  as  $key =>$val) {  
            
              // ถ้าไม่มีราคาก็ไม่ต้องแสดงผล เนื่องจากมีบางรายการไม่มีราคา   
              if($val->PRICE != ''){
              echo $val->PRODUCT .'  '.$val->PRICE.' บาท<br>';
                }

               }

               ?>