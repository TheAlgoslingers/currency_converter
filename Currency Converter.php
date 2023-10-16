<?php
/*
 -------------------------------
  Currency Converter Class
  
  Author: The Algoslingers
  
  Twitter/GitHub/YouTube: @TheAlgoslingers
  
  License: MIT
 -------------------------------
 
 @param $from is the currency being converted from
 @param $to is the currency to be converted to
 @param $amount is the amount to convert and is should be a numerical or float type
 @param #source is a url source for the currency conversion
*/
class Convertor
{
  public function convert($from,$to,$amount){
   
   $from = strtolower(isset($from)) ? $from : "usd";
   
   $to = strtolower(isset($to)) ? $to : "ghs";
   
   if(!is_infinite($amount) && !is_numeric($amount)){
    
    throw new Exception();
    
   }
    $dom = new DOMDocument();
    
    $source = file_get_contents("https://$from.mconvert.net/$to");
    
    if(!empty($source)){
      $dom->loadHTML($source);
      $xpath = new DOMXpath($dom);
      $nodes = $xpath->query('//div[@class="byrate"]');

      $tmp_dom = new DOMDocument();
      
      foreach ($nodes as $node) {
       
      $tmp_dom->appendChild($tmp_dom->importNode($node, true));
     }
     
      $rate = str_replace(
               '<div class="byrate">',
               "",
               str_replace(
                '</div>',
                "",
                 str_replace(
                   "By rate: ",
                   "",
                   $tmp_dom->saveHTML()
                   )
                )
             );
      $currency = $rate * $amount;
     }
     return $currency;
  }
}

/*
 Example 1: Convert a currency from usd(us dollar) to ghs(Ghanaian cedis)
*/
$c = new Convertor;
echo $c->convert("usd","ghs",3);
?>