<?php
/*
Plugin Name: Fındık TV
Plugin URI: http://www.kerimayhan.com.tr/
Description: Show hazelnut prices.
Version: 1.0
Date: 22 March 2017
Author: Kerim Ayhan <info@findiktv.com>
Author URI: http://www.kerimayhan.com.tr/contact.php
*/

if( ! function_exists('findiktvfindikdiyatlari') )
{?>
<?php
function pricedirection($citycode, $type){
	global $wpdb;
	if($type == "lowest"){
		$yesterday = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%FINDIK%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 1,1");
		$yesterday = $yesterday->lowest_price;
		$today = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%FINDIK%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 0,1");
		$today = $today->lowest_price;
	}else if($type == "highest"){
		$yesterday = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%FINDIK%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 1,1");
		$yesterday = $yesterday->highest_price;
		$today = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%FINDIK%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 0,1");
		$today = $today->highest_price;
	}
	$yesterday = number_format($yesterday, 2);
	$today = number_format($today, 2);
	if($yesterday < $today){
		$value= "arrow-up";
	}else if($yesterday > $today){
		$value= "arrow-down";
	}else{
	$value= "minus";
	}
	return $value;
}
function otherpricedirection($citycode, $product, $type){
	global $wpdb;
	if($type == "lowest"){
		$yesterday = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%". $product . "%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 1,1");
		$yesterday = $yesterday->lowest_price;
		$today = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%". $product . "%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 0,1");
		$today = $today->lowest_price;
	}else if($type == "highest"){
		$yesterday = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%". $product . "%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 1,1");
		$yesterday = $yesterday->highest_price;
		$today = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%". $product . "%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 0,1");
		$today = $today->highest_price;
	}
	$yesterday = number_format($yesterday, 2);
	$today = number_format($today, 2);
	if($yesterday < $today){
		$value= "arrow-up";
	}else if($yesterday > $today){
		$value= "arrow-down";
	}else{
	$value= "minus";
	}
	return $value;
}
function prices($citycode, $type){
	global $wpdb;
	if($type == "lowest"){
		$price = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%FINDIK%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 1");
		$price = $price->lowest_price;
	}else if($type == "highest"){
		$price = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%FINDIK%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 1");
		$price = $price->highest_price;
	}
	$price = number_format($price, 2, ',', '.');
	return $price;
}
function otherprices($citycode, $product, $type){
	global $wpdb;
	if($type == "lowest"){
		$price = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%". $product . "%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 1");
		$price = $price->lowest_price;
	}else if($type == "highest"){
		$price = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%". $product . "%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 1");
		$price = $price->highest_price;
	}
	$price = number_format($price, 2, ',', '.');
	return $price;
}
function pricechange($citycode, $type){
	global $wpdb;
	if($type == "lowest"){
		$price_yesterday = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%FINDIK%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 1,1");
		$price_yesterday = $price_yesterday->lowest_price;
		$price = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%FINDIK%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 1");
		$price = $price->lowest_price;
	}else if($type == "highest"){
		$price_yesterday = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%FINDIK%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 1,1");
		$price_yesterday = $price_yesterday->highest_price;
		$price = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%FINDIK%\" AND  city LIKE  '%".$citycode."%' GROUP BY(price_date) DESC LIMIT 1");
		$price = $price->highest_price;
	}
	if($price_yesterday < 0 || $price_yesterday == null){
		$price_yesterday = 1;
	}
	$pricechange = 100*($price - $price_yesterday) / $price_yesterday;
	$pricechange =  number_format($pricechange, 2);
	return $pricechange;
}
function FiyatlarList($atts, $content=null){
	global $wpdb;
	$price_date = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%FINDIK%\" ORDER BY price_date DESC LIMIT 1");
	$dateee = $price_date->price_date;
	$date=date_create($dateee);
	$fiyatcontent = '<table style="max-width: 500px" class="FiyatTable table table-striped table-responsive">'.
  '<thead style="background: #006838; color: #ffffff;">'.
   ' <tr>'.
      '<th colspan="2">' . date_format($date,"d-m-Y").' Fındık Fiyatları Listesi</th>'.
      '<th><a class="btn btn-link btn-xs" style="color: #efefef;" target="_blank" href="https://www.findiktv.com/sitene-ekle" title="Sitene Ekle">Sitene Ekle</a></th>'.
    '</tr>'.
    '<tr>'.
      '<th>Şehir</th>'.
      '<th>En Düşük</th>'.
      '<th>En Yüksek</th>'.
    '</tr>'.
  '</thead>'.
  '<tbody>'.
    '<tr>'.
      '<td><a href="https://www.findiktv.com/urunler/findik-fiyatlari/akcakoca-findik-fiyatlari" title="Akçakoca Detaylı Fındık Raporları">AKÇAKOCA<a</td>'.
      '<td>'. prices('AKOCA', 'lowest').' TL <i class="fa fa-'. pricedirection('AKOCA', 'lowest').'"></i></td>'.
      '<td>'. prices('AKOCA', 'highest').' TL <i class="fa fa-'. pricedirection('AKOCA', 'highest').'"></i></td>'.
    '</tr>'.
	'<tr>'.
      '<td><a href="https://www.findiktv.com/urunler/findik-fiyatlari/carsamba-findik-fiyatlari" title="Çarşambaa Detaylı Fındık Raporları">ÇARŞAMBA<a</td>'.
      '<td>'. prices('AMBA', 'lowest').' TL <i class="fa fa-'. pricedirection('AMBA', 'lowest').'"></i></td>'.
      '<td>'. prices('AMBA', 'highest').' TL <i class="fa fa-'. pricedirection('AMBA', 'highest').'"></i></td>'.
    '</tr>'.
    '<tr>'.
      '<td><a href="https://www.findiktv.com/urunler/findik-fiyatlari/duzce-findik-fiyatlari" title="Düzce Detaylı Fındık Raporları">DÜZCE</a></td>'.
      '<td>'. prices('ZCE', 'lowest').' TL <i class="fa fa-'. pricedirection('ZCE', 'lowest').'"></i></td>'.
      '<td>'. prices('ZCE', 'highest').' TL <i class="fa fa-'. pricedirection('ZCE', 'highest').'"></i></td>'.
    '</tr>'.
    '<tr>'.
      '<td><a href="https://www.findiktv.com/urunler/findik-fiyatlari/fatsa-findik-fiyatlari" title="Fatsa Detaylı Fındık Raporları">FATSA</a></td>'.
      '<td>'. prices('FATSA', 'lowest').' TL <i class="fa fa-'. pricedirection('FATSA', 'lowest').'"></i></td>'.
      '<td>'. prices('FATSA', 'highest').' TL <i class="fa fa-'. pricedirection('FATSA', 'highest').'"></i></td>'.
    '</tr>'.
    '<tr>'.
      '<td><a href="https://www.findiktv.com/urunler/findik-fiyatlari/giresun-findik-fiyatlari" title="Giresun Detaylı Fındık Raporları">GİRESUN</a></td>'.
      '<td>'. prices('RESUN', 'lowest').' TL <i class="fa fa-'. pricedirection('RESUN', 'lowest').'"></i></td>'.
      '<td>'. prices('RESUN', 'highest').' TL <i class="fa fa-'. pricedirection('RESUN', 'highest').'"></i></td>'.
    '</tr>'.
    '<tr>'.
      '<td><a href="https://www.findiktv.com/urunler/findik-fiyatlari/kocaeli-findik-fiyatlari" title="Kocaeli Detaylı Fındık Raporları">KOCAELİ</a></td>'.
      '<td>'. prices('KOCAEL', 'lowest').' TL <i class="fa fa-'. pricedirection('KOCAEL', 'lowest').'"></i></td>'.
      '<td>'. prices('KOCAEL', 'highest').' TL <i class="fa fa-'. pricedirection('KOCAEL', 'highest').'"></i></td>'.
    '</tr>'.
    '<tr>'.
      '<td><a href="https://www.findiktv.com/urunler/findik-fiyatlari/ordu-findik-fiyatlari" title="Ordu Detaylı Fındık Raporları">ORDU</a></td>'.
      '<td>'. prices('ORDU', 'lowest').' TL <i class="fa fa-'. pricedirection('ORDU', 'lowest').'"></i></td>'.
      '<td>'. prices('ORDU', 'highest').' TL <i class="fa fa-'. pricedirection('ORDU', 'highest').'"></i></td>'.
    '</tr>'.
    '<tr>'.
      '<td><a href="https://www.findiktv.com/urunler/findik-fiyatlari/sakarya-findik-fiyatlari" title="Sakarya Detaylı Fındık Raporları">SAKARYA</a></td>'.
      '<td>'. prices('SAKARYA', 'lowest').' TL <i class="fa fa-'. pricedirection('SAKARYA', 'lowest').'"></i></td>'.
      '<td>'. prices('SAKARYA', 'highest').' TL <i class="fa fa-'. pricedirection('SAKARYA', 'highest').'"></i></td>'.
    '</tr>'.
    '<tr>'.
      '<td><a href="https://www.findiktv.com/urunler/findik-fiyatlari/samsun-findik-fiyatlari" title="Samsun Detaylı Fındık Raporları">SAMSUN</a></td>'.
      '<td>'. prices('SAMSUN', 'lowest').' TL <i class="fa fa-'. pricedirection('SAMSUN', 'lowest').'"></i></td>'.
      '<td>'. prices('SAMSUN', 'highest').' TL <i class="fa fa-'. pricedirection('SAMSUN', 'highest').'"></i></td>'.
    '</tr>'.
    '<tr>'.
      '<td><a href="https://www.findiktv.com/urunler/findik-fiyatlari/trabzon-findik-fiyatlari" title="Trabzon Detaylı Fındık Raporları">TRABZON</a></td>'.
      '<td>'. prices('TRABZON', 'lowest').' TL <i class="fa fa-'. pricedirection('TRABZON', 'lowest').'"></i></td>'.
      '<td>'. prices('TRABZON', 'highest').' TL <i class="fa fa-'. pricedirection('TRABZON', 'highest').'"></i></td>'.
    '</tr>'.
    '<tr>'.
      '<td><a href="https://www.findiktv.com/urunler/findik-fiyatlari/terme-findik-fiyatlari" title="Terme Detaylı Fındık Raporları">TERME</a></td>'.
      '<td>'. prices('TERME', 'lowest').' TL <i class="fa fa-'. pricedirection('TERME', 'lowest').'"></i></td>'.
      '<td>'. prices('TERME', 'highest').' TL <i class="fa fa-'. pricedirection('TERME', 'highest').'"></i></td>'.
    '</tr>'.
    '<tr>'.
      '<td><a href="https://www.findiktv.com/urunler/findik-fiyatlari/unye-findik-fiyatlari" title="Ünye Detaylı Fındık Raporları">ÜNYE</a></td>'.
      '<td>'. prices('NYE', 'lowest').' TL <i class="fa fa-'. pricedirection('NYE', 'lowest').'"></i></td>'.
      '<td>'. prices('NYE', 'highest').' TL <i class="fa fa-'. pricedirection('NYE', 'highest').'"></i></td>'.
    '</tr>'.
    '<tr>'.
      '<td><a href="https://www.findiktv.com/urunler/findik-fiyatlari/zonguldak-findik-fiyatlari" title="Zonguldak Detaylı Fındık Raporları">ZONGULDAK</a></td>'.
      '<td>'. prices('ZONGULDAK', 'lowest').' TL <i class="fa fa-'. pricedirection('ZONGULDAK', 'lowest').'"></i></td>'.
      '<td>'. prices('ZONGULDAK', 'highest').' TL <i class="fa fa-'. pricedirection('ZONGULDAK', 'highest').'"></i></td>'.
    '</tr>'.
  '</tbody>'.
'</table>';
return $fiyatcontent;
}
add_shortcode('FiyatlarList', 'FiyatlarList');

function PriceReklam(){
	$reklam = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>'.
				'<ins class="adsbygoogle"'.
					 'style="display:block; text-align:center;"'.
					 'data-ad-format="fluid"'.
					 'data-ad-layout="in-article"'.
					 'data-ad-client="ca-pub-8250381408951199"'.
					 'data-ad-slot="7542244268"></ins>'.
				'<script>'.
					 '(adsbygoogle = window.adsbygoogle || []).push({});'.
				'</script>';
	return $reklam;
}
function SehirFiyatSiteneEkle($atts, $content=null){
	$city = $atts['city'];
	if($city == "AKÇAKOCA"){ $city = "AKOCA";}
	else if($city == "ÇARŞAMBA"){ $city = "AMBA";}
	else if($city == "DÜZCE"){ $city = "ZCE";}
	else if($city == "GİRESUN"){ $city = "RESUN";}
	else if($city == "KOCAELİ"){ $city = "KOCAEL";}
	else if($city == "ÜNYE"){ $city = "NYE";}
	else if($city == "İSTANBUL"){ $city = "STANBUL"; }
	else{ $city = $city;}
	$fiyatcontent = '<div class="SinglePriceData"><div class="PriceDataCont"><i class="fa fa-line-chart" aria-hidden="true"></i>'.
  '<h2>FINDIK FİYATI</h2>'.
  '<p><span class="SinglePrice">'. prices($city, 'lowest').'</span> TL</p>'.
  '<p><span class="PriceChangeRate">'. pricechange($city, 'lowest') .'% </span><i class="fa fa-'. pricedirection($city, 'lowest').'"></i><a href="https://www.findiktv.com/" target="_blank" style="display:inline-block; float:right; color:#333; font:bold 11px Arial; padding:10px 5px 0 0; text-decoration:underline;">Fındık TV</a></p>'.
  '</div>'.
'</div>';
return $fiyatcontent;
}
add_shortcode('SehirFiyatSiteneEkle', 'SehirFiyatSiteneEkle');
function FiyatlarListSiteneEkle($atts, $content=null){
	global $wpdb;
	$price_date = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%FINDIK%\" ORDER BY price_date DESC LIMIT 1");
	$dateee = $price_date->price_date;
	$date=date_create($dateee);
	$fiyatcontent = '<div class="tableCnt"><div class="table wide pgAltin">'.
  '<h2 class="caption">' . date_format($date,"d-m-Y").' FINDIK FİYATLARI</h2>'.
  '<a href="https://www.findiktv.com/sitene-ekle" target="_blank" style="display:inline-block; float:right; color:#333; font:bold 11px Arial; padding:12px 10px 0 0; text-decoration:underline;">Fındık TV</a>'.
  '<div class="tableBox">'.
	'<div class="tHead">'.
		'<ul>'.
		  '<li class="cell3 tal">Şehir</li>'.
		  '<li class="cell2">En Düşük</li>'.
		  '<li class="cell2"><span class="PriceChangeRate">Değişim</span></li>'.
		  '<li class="cell2">En Yüksek</li>'.
		  '<li class="cell2"><span class="PriceChangeRate">Değişim</span></li>'.
		  '<li class="cell1"></li>'.
		'</ul>'.
    '</div>'.
  '<div class="tBody">'.
    '<ul>'.
      '<li class="cell3 tal"><strong>TMO Fiyatı</strong></li>'.
      '<li class="cell2">10,00 TL</li>'.
	  '<li class="cell2"><i class="fa fa-minus"></i></li>'.
      '<li class="cell2">10,50 TL</li>'.
      '<li class="cell2"><i class="fa fa-minus"></i></li>'.
	  '<li class="cell1"></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/akcakoca-findik-fiyatlari" title="Akçakoca Detaylı Fındık Raporları">AKÇAKOCA</a></li>'.
      '<li class="cell2">'. prices('AKOCA', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('AKOCA', 'lowest') .'% </span><i class="fa fa-'. pricedirection('AKOCA', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('AKOCA', 'highest').' TL</li>'.
      '<li class="cell2"><span class="PriceChangeRate">'. pricechange('AKOCA', 'highest') .'% </span><i class="fa fa-'. pricedirection('AKOCA', 'highest').'"></i></li>'.
	  '<li class="cell1"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/akcakoca-findik-fiyatlari" title="Akçakoca Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
	'<ul>'.
      '<li class="cell3 tal"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/carsamba-findik-fiyatlari" title="Çarşamba Detaylı Fındık Raporları">ÇARŞAMBA</a></li>'.
      '<li class="cell2">'. prices('AMBA', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('AMBA', 'lowest') .'% </span><i class="fa fa-'. pricedirection('AMBA', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('AMBA', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('AMBA', 'highest') .'% </span><i class="fa fa-'. pricedirection('AMBA', 'highest').'"></i></li>'.
	  '<li class="cell1"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/carsamba-findik-fiyatlari" title="Çarşamba Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/duzce-findik-fiyatlari" title="Düzce Detaylı Fındık Raporları">DÜZCE</a></li>'.
      '<li class="cell2">'. prices('ZCE', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('ZCE', 'lowest') .'% </span><i class="fa fa-'. pricedirection('ZCE', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('ZCE', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('ZCE', 'lowest') .'% </span><i class="fa fa-'. pricedirection('ZCE', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/duzce-findik-fiyatlari" title="Düzce Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/fatsa-findik-fiyatlari" title="Fatsa Detaylı Fındık Raporları">FATSA</a></li>'.
      '<li class="cell2">'. prices('FATSA', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('FATSA', 'lowest') .'% </span><i class="fa fa-'. pricedirection('FATSA', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('FATSA', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('FATSA', 'lowest') .'% </span><i class="fa fa-'. pricedirection('FATSA', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/fatsa-findik-fiyatlari" title="Fatsa Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/giresun-findik-fiyatlari" title="Giresun Detaylı Fındık Raporları">GİRESUN</a></li>'.
      '<li class="cell2">'. prices('RESUN', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('RESUN', 'lowest') .'% </span><i class="fa fa-'. pricedirection('RESUN', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('RESUN', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('RESUN', 'lowest') .'% </span><i class="fa fa-'. pricedirection('RESUN', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/giresun-findik-fiyatlari" title="Giresun Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/kocaeli-findik-fiyatlari" title="Kocaeli Detaylı Fındık Raporları">KOCAELİ</a></li>'.
      '<li class="cell2">'. prices('KOCAEL', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('KOCAEL', 'lowest') .'% </span><i class="fa fa-'. pricedirection('KOCAEL', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('KOCAEL', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('KOCAEL', 'lowest') .'% </span><i class="fa fa-'. pricedirection('KOCAEL', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/kocaeli-findik-fiyatlari" title="Kocaeli Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/ordu-findik-fiyatlari" title="Ordu Detaylı Fındık Raporları">ORDU</a></li>'.
      '<li class="cell2">'. prices('ORDU', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('ORDU', 'lowest') .'% </span><i class="fa fa-'. pricedirection('ORDU', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('ORDU', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('ORDU', 'lowest') .'% </span><i class="fa fa-'. pricedirection('ORDU', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/ordu-findik-fiyatlari" title="Ordu Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/sakarya-findik-fiyatlari" title="Sakarya Detaylı Fındık Raporları">SAKARYA</a></li>'.
      '<li class="cell2">'. prices('SAKARYA', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('SAKARYA', 'lowest') .'% </span><i class="fa fa-'. pricedirection('SAKARYA', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('SAKARYA', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('SAKARYA', 'lowest') .'% </span><i class="fa fa-'. pricedirection('SAKARYA', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/sakarya-findik-fiyatlari" title="Sakarya Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/samsun-findik-fiyatlari" title="Samsun Detaylı Fındık Raporları">SAMSUN</a></li>'.
      '<li class="cell2">'. prices('SAMSUN', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('SAMSUN', 'lowest') .'% </span><i class="fa fa-'. pricedirection('SAMSUN', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('SAMSUN', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('SAMSUN', 'lowest') .'% </span><i class="fa fa-'. pricedirection('SAMSUN', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/samsun-findik-fiyatlari" title="Samsun Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/trabzon-findik-fiyatlari" title="Trabzon Detaylı Fındık Raporları">TRABZON</a></li>'.
      '<li class="cell2">'. prices('TRABZON', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('TRABZON', 'lowest') .'% </span><i class="fa fa-'. pricedirection('TRABZON', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('TRABZON', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('TRABZON', 'lowest') .'% </span><i class="fa fa-'. pricedirection('TRABZON', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/trabzon-findik-fiyatlari" title="Trabzon Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/terme-findik-fiyatlari" title="Terme Detaylı Fındık Raporları">TERME</a></li>'.
      '<li class="cell2">'. prices('TERME', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('TERME', 'lowest') .'% </span><i class="fa fa-'. pricedirection('TERME', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('TERME', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('TERME', 'lowest') .'% </span><i class="fa fa-'. pricedirection('TERME', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/terme-findik-fiyatlari" title="Terme Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/unye-findik-fiyatlari" title="Ünye Detaylı Fındık Raporları">ÜNYE</a></li>'.
      '<li class="cell2">'. prices('NYE', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('NYE', 'lowest') .'% </span><i class="fa fa-'. pricedirection('NYE', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('NYE', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('NYE', 'lowest') .'% </span><i class="fa fa-'. pricedirection('NYE', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/unye-findik-fiyatlari" title="Ünye Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/zonguldak-findik-fiyatlari" title="Zonguldak Detaylı Fındık Raporları">ZONGULDAK</a></li>'.
      '<li class="cell2">'. prices('ZONGULDAK', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('ZONGULDAK', 'lowest') .'% </span><i class="fa fa-'. pricedirection('ZONGULDAK', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('ZONGULDAK', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('ZONGULDAK', 'lowest') .'% </span><i class="fa fa-'. pricedirection('ZONGULDAK', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a target="_blank" href="https://www.findiktv.com/urunler/findik-fiyatlari/zonguldak-findik-fiyatlari" title="Zonguldak Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
  '</div>'.
  '</div>'.
  '</div>'.
'</div>';
return $fiyatcontent;
}
add_shortcode('FiyatlarListSiteneEkle', 'FiyatlarListSiteneEkle');

function FiyatlarListNew($atts, $content=null){
	global $wpdb;
	$price_date = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."_fiyatlar WHERE product LIKE  \"%FINDIK%\" ORDER BY price_date DESC LIMIT 1");
	$dateee = $price_date->price_date;
	$date=date_create($dateee);
	$fiyatcontent = '<div class="tableCnt"><div class="table wide pgAltin">'.
  '<h2 class="caption">' . date_format($date,"d-m-Y").' FINDIK FİYATLARI</h2>'.
  '<a href="https://www.findiktv.com/sitene-ekle" target="_blank" style="display:inline-block; float:right; color:#333; font:bold 11px Arial; padding:12px 0 0 0; text-decoration:underline;">Sitene Ekle</a>'.
  '<div class="tableBox">'.
	'<div class="tHead">'.
		'<ul>'.
		  '<li class="cell3 tal">Şehir</li>'.
		  '<li class="cell2">En Düşük</li>'.
		  '<li class="cell2"><span class="PriceChangeRate">Değişim</span></li>'.
		  '<li class="cell2">En Yüksek</li>'.
		  '<li class="cell2"><span class="PriceChangeRate">Değişim</span></li>'.
		  '<li class="cell1"></li>'.
		'</ul>'.
    '</div>'.
  '<div class="tBody">'.
    '<ul>'.
      '<li class="cell3 tal"><strong>TMO Fiyatı</strong></li>'.
      '<li class="cell2">10,00 TL</li>'.
	  '<li class="cell2"><i class="fa fa-minus"></i></li>'.
      '<li class="cell2">10,50 TL</li>'.
      '<li class="cell2"><i class="fa fa-minus"></i></li>'.
	  '<li class="cell1"></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/akcakoca-findik-fiyatlari" title="Akçakoca Detaylı Fındık Raporları">AKÇAKOCA</a></li>'.
      '<li class="cell2">'. prices('AKOCA', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('AKOCA', 'lowest') .'% </span><i class="fa fa-'. pricedirection('AKOCA', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('AKOCA', 'highest').' TL</li>'.
      '<li class="cell2"><span class="PriceChangeRate">'. pricechange('AKOCA', 'highest') .'% </span><i class="fa fa-'. pricedirection('AKOCA', 'highest').'"></i></li>'.
	  '<li class="cell1"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/akcakoca-findik-fiyatlari" title="Akçakoca Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
	'<ul>'.
      '<li class="cell3 tal"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/carsamba-findik-fiyatlari" title="Çarşamba Detaylı Fındık Raporları">ÇARŞAMBA</a></li>'.
      '<li class="cell2">'. prices('AMBA', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('AMBA', 'lowest') .'% </span><i class="fa fa-'. pricedirection('AMBA', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('AMBA', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('AMBA', 'highest') .'% </span><i class="fa fa-'. pricedirection('AMBA', 'highest').'"></i></li>'.
	  '<li class="cell1"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/carsamba-findik-fiyatlari" title="Çarşamba Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/duzce-findik-fiyatlari" title="Düzce Detaylı Fındık Raporları">DÜZCE</a></li>'.
      '<li class="cell2">'. prices('ZCE', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('ZCE', 'lowest') .'% </span><i class="fa fa-'. pricedirection('ZCE', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('ZCE', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('ZCE', 'lowest') .'% </span><i class="fa fa-'. pricedirection('ZCE', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/duzce-findik-fiyatlari" title="Düzce Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/fatsa-findik-fiyatlari" title="Fatsa Detaylı Fındık Raporları">FATSA</a></li>'.
      '<li class="cell2">'. prices('FATSA', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('FATSA', 'lowest') .'% </span><i class="fa fa-'. pricedirection('FATSA', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('FATSA', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('FATSA', 'lowest') .'% </span><i class="fa fa-'. pricedirection('FATSA', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/fatsa-findik-fiyatlari" title="Fatsa Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/giresun-findik-fiyatlari" title="Giresun Detaylı Fındık Raporları">GİRESUN</a></li>'.
      '<li class="cell2">'. prices('RESUN', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('RESUN', 'lowest') .'% </span><i class="fa fa-'. pricedirection('RESUN', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('RESUN', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('RESUN', 'lowest') .'% </span><i class="fa fa-'. pricedirection('RESUN', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/giresun-findik-fiyatlari" title="Giresun Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/kocaeli-findik-fiyatlari" title="Kocaeli Detaylı Fındık Raporları">KOCAELİ</a></li>'.
      '<li class="cell2">'. prices('KOCAEL', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('KOCAEL', 'lowest') .'% </span><i class="fa fa-'. pricedirection('KOCAEL', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('KOCAEL', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('KOCAEL', 'lowest') .'% </span><i class="fa fa-'. pricedirection('KOCAEL', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/kocaeli-findik-fiyatlari" title="Kocaeli Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell12">' . PriceReklam() . '</li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/ordu-findik-fiyatlari" title="Ordu Detaylı Fındık Raporları">ORDU</a></li>'.
      '<li class="cell2">'. prices('ORDU', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('ORDU', 'lowest') .'% </span><i class="fa fa-'. pricedirection('ORDU', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('ORDU', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('ORDU', 'lowest') .'% </span><i class="fa fa-'. pricedirection('ORDU', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/ordu-findik-fiyatlari" title="Ordu Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/sakarya-findik-fiyatlari" title="Sakarya Detaylı Fındık Raporları">SAKARYA</a></li>'.
      '<li class="cell2">'. prices('SAKARYA', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('SAKARYA', 'lowest') .'% </span><i class="fa fa-'. pricedirection('SAKARYA', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('SAKARYA', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('SAKARYA', 'lowest') .'% </span><i class="fa fa-'. pricedirection('SAKARYA', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/sakarya-findik-fiyatlari" title="Sakarya Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/samsun-findik-fiyatlari" title="Samsun Detaylı Fındık Raporları">SAMSUN</a></li>'.
      '<li class="cell2">'. prices('SAMSUN', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('SAMSUN', 'lowest') .'% </span><i class="fa fa-'. pricedirection('SAMSUN', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('SAMSUN', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('SAMSUN', 'lowest') .'% </span><i class="fa fa-'. pricedirection('SAMSUN', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/samsun-findik-fiyatlari" title="Samsun Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/trabzon-findik-fiyatlari" title="Trabzon Detaylı Fındık Raporları">TRABZON</a></li>'.
      '<li class="cell2">'. prices('TRABZON', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('TRABZON', 'lowest') .'% </span><i class="fa fa-'. pricedirection('TRABZON', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('TRABZON', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('TRABZON', 'lowest') .'% </span><i class="fa fa-'. pricedirection('TRABZON', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/trabzon-findik-fiyatlari" title="Trabzon Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/terme-findik-fiyatlari" title="Terme Detaylı Fındık Raporları">TERME</a></li>'.
      '<li class="cell2">'. prices('TERME', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('TERME', 'lowest') .'% </span><i class="fa fa-'. pricedirection('TERME', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('TERME', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('TERME', 'lowest') .'% </span><i class="fa fa-'. pricedirection('TERME', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/terme-findik-fiyatlari" title="Terme Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/unye-findik-fiyatlari" title="Ünye Detaylı Fındık Raporları">ÜNYE</a></li>'.
      '<li class="cell2">'. prices('NYE', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('NYE', 'lowest') .'% </span><i class="fa fa-'. pricedirection('NYE', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('NYE', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('NYE', 'lowest') .'% </span><i class="fa fa-'. pricedirection('NYE', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/unye-findik-fiyatlari" title="Ünye Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
    '<ul>'.
      '<li class="cell3 tal"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/zonguldak-findik-fiyatlari" title="Zonguldak Detaylı Fındık Raporları">ZONGULDAK</a></li>'.
      '<li class="cell2">'. prices('ZONGULDAK', 'lowest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('ZONGULDAK', 'lowest') .'% </span><i class="fa fa-'. pricedirection('ZONGULDAK', 'lowest').'"></i></li>'.
      '<li class="cell2">'. prices('ZONGULDAK', 'highest').' TL</li>'.
	  '<li class="cell2"><span class="PriceChangeRate">'. pricechange('ZONGULDAK', 'lowest') .'% </span><i class="fa fa-'. pricedirection('ZONGULDAK', 'lowest').'"></i></li>'.
	  '<li class="cell1"><a href="https://www.findiktv.com/urunler/findik-fiyatlari/zonguldak-findik-fiyatlari" title="Zonguldak Detaylı Fındık Raporları"><i class="fa fa-lg fa-info-circle" aria-hidden="true"></i></a></li>'.
    '</ul>'.
  '</div>'.
  '</div>'.
  '</div>'.
'</div>';
return $fiyatcontent;
}
add_shortcode('FiyatlarListNew', 'FiyatlarListNew');

function FiyatlarListDate($atts, $content=null){
	global $wpdb;
	$city = $atts['city'];
	$line = $atts['line'];
	$product = $atts['product'];
	$results = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar WHERE product LIKE  '%".$product."%' AND  city LIKE  '%".$city."%' GROUP BY(price_date) DESC LIMIT ".$line.",1");
	$originalDate = $results->price_date;
	$newDate = date("d-m-Y", strtotime($originalDate));
	return $newDate;
}
add_shortcode('FiyatlarListDate', 'FiyatlarListDate');

function FiyatlarAim($atts, $content=null){
	global $wpdb;
	$city = $atts['city'];
	$type = $atts['type'];
	$product = $atts['product'];
	$today = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar  WHERE  product LIKE  '%".$product."%' AND  city LIKE  '%".$city."%' GROUP BY(price_date) DESC LIMIT 0,1");
	$yesterday = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar  WHERE  product LIKE  '%".$product."%' AND  city LIKE  '%".$city."%' GROUP BY(price_date) DESC LIMIT 1,1");
	if($type == "lowest_price"){
		$todayprice = $today->lowest_price;
		$yesterdayprice = $yesterday->lowest_price;
	}else if($type == "highest_price"){
		$todayprice = $today->highest_price;
		$yesterdayprice = $yesterday->highest_price;
	}
	if($todayprice > $yesterdayprice){
		$FiyatlarAim = "arrow-up";
	}else if($todayprice < $yesterdayprice){
		$FiyatlarAim = "arrow-down";
	}else if($todayprice == $yesterdayprice){
		$FiyatlarAim = "minus";
	}
	return $FiyatlarAim;
}
add_shortcode('FiyatlarAim', 'FiyatlarAim');

function ChangeRate($atts, $content=null){
	global $wpdb;
	$city = $atts['city'];
	$type = $atts['type'];
	$product = $atts['product'];
	$today = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar  WHERE  product LIKE  '%".$product."%' AND  city LIKE  '%".$city."%' GROUP BY(price_date) DESC LIMIT 0,1");
	$yesterday = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar  WHERE  product LIKE  '%".$product."%' AND  city LIKE  '%".$city."%' GROUP BY(price_date) DESC LIMIT 1,1");
	if($type == "lowest_price"){
		$todayprice = $today->lowest_price;
		$yesterdayprice = $yesterday->lowest_price;
		$ChangeRate = round(100*($todayprice - $yesterdayprice) / $yesterdayprice,2);
	}else if($type == "highest_price"){
		$todayprice = $today->highest_price;
		$yesterdayprice = $yesterday->highest_price;
		$ChangeRate = round(100*($todayprice - $yesterdayprice) / $yesterdayprice,2);
	}
	return $ChangeRate;
}
add_shortcode('ChangeRate', 'ChangeRate');

function ChangeAmount($atts, $content=null){
	global $wpdb;
	$city = $atts['city'];
	$type = $atts['type'];
	$product = $atts['product'];
	$today = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar  WHERE  product LIKE  '%".$product."%' AND  city LIKE  '%".$city."%' GROUP BY(price_date) DESC LIMIT 0,1");
	$yesterday = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar  WHERE  product LIKE  '%".$product."%' AND  city LIKE  '%".$city."%' GROUP BY(price_date) DESC LIMIT 1,1");
	if($type == "lowest_price"){
		$todayprice = $today->lowest_price;
		$yesterdayprice = $yesterday->lowest_price;
		$ChangeAmount = ($todayprice - $yesterdayprice);
	}else if($type == "highest_price"){
		$todayprice = $today->highest_price;
		$yesterdayprice = $yesterday->highest_price;
		$ChangeAmount = ($todayprice - $yesterdayprice);
	}
	return $ChangeAmount;
}
add_shortcode('ChangeAmount', 'ChangeAmount');

function HesaplamaAraci($atts, $content=null){
	wp_enqueue_style( 'price-page', get_template_directory_uri() . '/cssjs/price-page.css',array(),'1.05','all' );
	global $wpdb;
	$city = $atts['city'];
	$product = $atts['product'];
	if($product == "FINDIK"){
		$randiman = '<div class="KiloFiyat">'.
				'<label for="randiman">Randıman</label><input type="number" step="0.1" placeholder="Randıman" min="0" max="100" value="50" class="randiman field" name="randiman" />'.
				'</div>';
	}else{
		$randiman = '<input type="hidden" value="50" class="randiman" name="randiman" />';
	}
	$price = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar  WHERE  product LIKE  '%".$product."%' AND  city LIKE  '%".$city."%' GROUP BY(price_date) DESC LIMIT 0,1");
	$todayprice = $price->highest_price;
	$script = '<script type="text/javascript">function fiyathesapla(){ var Kilogram = jQuery(\'.Kilogram\').val(); var BirimFiyat = jQuery(\'.BirimFiyat\').val(); var randiman = jQuery(\'.randiman\').val(); if(Kilogram <= 0 || Kilogram == "" || Kilogram == null){ alert("Lütfen kilogram giriniz!"); }else if(BirimFiyat <= 0 ){ alert("Lütfen Birim Fiyatı kontrol ediniz!"); }else if(randiman <= 0 || randiman >= 100 ){ alert("Lütfen randımanı kontrol ediniz!"); }else{ var PriceSonuc = parseFloat(Math.round((Kilogram * randiman * 2 / 100 ) * BirimFiyat * 100) / 100); var PriceSonuc = PriceSonuc.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + " TL"; jQuery(\'#PriceSonuc\').val(PriceSonuc); } }</script>';
	$HesaplamaAraci = '<div id="HesaplamaAraci">'.
				'<div class="HesaplamaHeader">Hesaplama Aracı</div>'.
				'<div class="HesaplamaAraci">'.
				'<div class="KacKilo">'.
				'<label for="Kilogram">Kaç kilo ürün satacaksınız?</label><input type="number" placeholder="KG" min="0" class="Kilogram field" value="" name="Kilogram" />'.
				'</div>'.
				'<div class="KiloFiyat">'.
				'<label for="BirimFiyat">Satış fiyatı(TL)</label><input type="number" step="0.01" placeholder="Fiyat" min="0" value="'.$todayprice.'" class="BirimFiyat field" name="BirimFiyat" />'.
				'</div>'.
				$randiman.
				'<div class="HesaplamaButonArea">'.
				'<a href="javascript:void(0);" class="HesaplaButon" onclick="fiyathesapla();">Hesapla</a>'.
				'</div>'.
				'<div class="FiyatSonuc">'.
				'<label for="sonuc">Sonuç</label><input id="PriceSonuc" type="text" value="..." class="PriceSonuc field" name="sonuc" disabled />'.
				'</div>'.
				'</div>'.
				'</div>'.
				$script;
	return $HesaplamaAraci;
}
add_shortcode('HesaplamaAraci', 'HesaplamaAraci');

function AMPFiyatSayfalari($atts, $content=null){
	global $wpdb;
	$product = $atts['product'];
	$page_title = $atts['page_title'];
	$price = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."_fiyatlar  WHERE  product LIKE  '%".$product."%' GROUP BY(price_date) DESC LIMIT 0,1");
	$todayprice = $price->highest_price;
	$price_date = $wpdb->get_row("SELECT price_date FROM  ".$wpdb->prefix."_fiyatlar WHERE product LIKE  '%".$product."%' GROUP BY(price_date) DESC LIMIT 0,1");
	$lastprice_date = $price_date->price_date;
	$pricelist_content = "";
	$pricelist_top = '<div class="OtherProductsPriceList"><table class="table table-striped table-hover"><tbody><tr><th>Ürün</th><th>Şehir</th><th>En Düşük</th><th>En Yüksek</th><th>Birim</th></tr>';
	foreach( $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."_fiyatlar WHERE product LIKE \"%".$product."%\" AND price_date LIKE \"%".$lastprice_date."%\" ORDER BY product ASC;") as $key => $row) {
		$pricelist_content .= "<tr><td>".$row->product."</td><td>".$row->city."</td><td>".$row->lowest_price." TL</td><td>".$row->highest_price." TL</td><td>".$row->unit."</td></tr>";
	}
	$pricelist_bottom= '</tbody></table></div>';
	
	$amp_page_text = '<h2>' .$page_title.' Hakkında</h2>'.
		'<p>Yukarıdaki raporlarda listelenen <strong>'.$page_title.'</strong> ilgili borsalarda yapılan işlemler sonucunda oluşan en yüksek ve en düşük fiyatları gösterir. Bu fiyatlar '.$lastprice_date_show.' tarihli fiyatlardır ve hafta içi her iş günü güncellenir.</p>'.
		'<p><i>'.$page_title.'</i> serbest piyasa koşullarında oluşmaktadır. Arz-talep dengesi neticesinde oluşan fiyatlar gün gün değişir. İthalat-ihracat, dolar kuru ve diğer değişkenler <u>'.$page_title.'</u>nda dalgalanmaya sebebiyet verir.</p>'.
		'<p>Hesaplama aracını kullanarak ürünün Türk Lirası karşılığını görebilirsiniz. Ayrıca grafikler aracılığıyla fiyat değişimini takip edebilirsiniz. Son olarak, tarihsel dolar fiyat değişim grafiği ise '.$page_title.' dolar endeksli eğilimini de size gösterecektir.</p>';
	$AMPFiyatSayfalari = $pricelist_top .$pricelist_content . $pricelist_bottom . $amp_page_text;
	return $AMPFiyatSayfalari;
}

add_shortcode('AMPFiyatSayfalari', 'AMPFiyatSayfalari');

function wpb_list_child_pages() {
	global $post;
	if ( is_page() && $post->post_parent )
		$childpages = wp_list_pages( 'sort_column=post_name&title_li=&child_of=' . $post->post_parent . '&echo=0&depth=1&exclude='. $post->ID );
	else
		$childpages = wp_list_pages( 'sort_column=post_name&title_li=&child_of=' . $post->ID . '&echo=0&depth=1&exclude='. $post->ID );
	if ( $childpages ) {
		$string = '<ul>' . $childpages . '</ul>';
	}
	return $string;
}
add_shortcode('wpb_childpages', 'wpb_list_child_pages');


function kategorihaberleri($atts, $content=null) {
	$the_query = new WP_Query(
		array(
			'posts_per_page' => 6,
			'numberposts'	=> 6,
			'offset'		=> 0,
			'orderby'		=> "ASC",
			'category__in'         => '100'/*,
			'tag__in' => '8'*/
			)
		);
		if ( $the_query->have_posts() ) {
			$string .= '<div class="sol_sidebar"><div class="sidebar_arka"><h2>İlgili Haberler</h2></div>';
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				if ( has_post_thumbnail() ) {
					$thumb = get_post_thumbnail_id();
					$img_url = wp_get_attachment_url($thumb,'full' ); 
					$image = aq_resize( $img_url, 300, 150, true,true,true ); 
					$string .= '<div class="hoveryenibilesen">';
					$string .= '<a target="_blank" href="' . get_the_permalink() .'" rel="bookmark"><img src="'. $image .'" alt="'. get_the_title(). '" title="'. get_the_title(). '" style="display: inline;" width="300" height="150" /><h3>' . get_the_title() .'</h3></a></div>';
					} else { 
					// if no featured image is found
					$string .= '<li><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() .'</a></li>';
					}
				}
			} else {
	// no posts found
	}
	$string .= '</div>';
	return $string;
	/* Restore original Post Data */
	wp_reset_postdata();
}
add_shortcode('kategorihaberleri', 'kategorihaberleri');

}
?>
