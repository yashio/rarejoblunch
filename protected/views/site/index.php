<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">google.load("jquery", "1.3.2");</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=ja" charset="UTF-8"></script>
<script type="text/javascript">
  /* クリック時の挙動を制御*/
  function attachMessage(marker,msg) {
    google.maps.event.addListener(marker, 'click', function() {
      new google.maps.Geocoder().geocode({
        latLng: marker.getPosition()
      }, function(result, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          new google.maps.InfoWindow({
		content: msg          
		}).open(marker.getMap(), marker);
        }
      });
    });
  }
	var map, marker, infowindow;
	/* ページ読み込み時に地図を初期化 */
	$(function(){
		initialize();
	});
	/* 地図の初期化 */
	function initialize() {
	var data = new Array();//マーカー位置の緯度経度
<?php
	foreach ($shops as $shop)
	{
		if($shop->kind == 1){
			$value = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=昼|FFA07A|000000';
		}else if($shop->kind == 2){
			$value = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=麦|FFA500|000000';
		}else if($shop->kind == 0){
			$value = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=麺|ffffff|000000';
		}else{
			$value = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=99|ffff00|000000';
		}
?>
	data.push({position: new google.maps.LatLng(<?php echo $shop->lat ?>,<?php echo $shop->lng ?>), content: '<?php echo $shop->name?>',detail:'<?php echo $shop->impression?>',kind:'<?php echo $value ?>'});
<?php
}
?>

	/* 地図のオプション設定 */
	var myOptions={
		/*初期のズーム レベル */
		zoom: 18,
		/* 地図の中心点 */
		center: new google.maps.LatLng(35.65441980000001,139.70141490000003),
		/* 地図タイプ */
    		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	/* 地図オブジェクト */
	map=new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	for (i = 0; i < data.length; i++) {
		var myMarker = new google.maps.Marker({
			position: data[i].position,
			map:map,
			title:data[i].content,
			icon:data[i].kind
		});
		attachMessage(myMarker,data[i].content);
	}	

	/* 情報ウィンドウ表示 */
	function showInfoWindow(obj){
		/* 既に開かれていたら閉じる */
		if(infowindow) infowindow.close();
			infowindow=new google.maps.InfoWindow({
			/* クリックしたマーカーのタイトルと緯度・経度を情報ウィンドウに表示 */
				content:obj.getTitle()
			});
			infowindow.open(map,obj);
		}
	}

$(document).ready(function() {
/*住所を貼り付けてもらう処理*/
$("#getad").click(function() {
    var sad = $("#address").val();
    var geocoder = new google.maps.Geocoder();
    point = new google.maps.LatLng(0, 0);
    var marker = new google.maps.Marker({
      position: point,
      map: map,
      draggable: true
    });
   geocoder.geocode({ 'address': sad}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var p = marker.position;
	$.post("/site/add", { 
		name: $("#name").val(),
		impression: $("#impression").val(),
		address: $("#address").val(),
		kind: $("#kind").val(),
		lat: results[ 0 ].geometry.location.lat(),
		lng: results[ 0 ].geometry.location.lng(),
 })
.done(function(data) {
});
      } else {
        alert("住所から場所を特定できませんでした。最初にビル名などを省略し、番地までの検索などでお試しください。");
      }
    });
    return false;
  });
});
</script>

<style type="text/css">
#map_canvas {
  width: 500px;
  height: 371px;
}
</style>
</head>

<!-- form -->
<div style="float:left; width:420px;">
<form>
<fieldset>
<i class ="icon-home"></i> <input type="text" name="name" id="name" class="input-large" placeholder="Shop Name" /><br>
<i class ="icon-map-marker"></i> <input type="text" name="address" id="address" Class="input-large" placeholder="Address"><br>
<i class="icon-tag" ></i> <?php echo CHtml::dropDownList('kind',0,array('ラーメン','ランチ','麦酒'),array("class"=>"span2"));?>
<br>
<i class="icon-comment"></i> <input type="text" name="impression" id="impression" placeholder="Comment" /><br>
<button id="getad">お店を登録</button>
</fieldset>
</form>
</div>

<div id="map_canvas" style="border-style: solid ; border-width: 1px; padding: 10px 5px 10px 20px; border-color: orange; color: green; background-color: lavender; width: 400px; border-radius: 10px; box-shadow: 5px 5px 5px #AAA; width:500px;">
</div>
<br>

<div style="">
<table class='table table-bordered'>
<thead>
<tr>
<th>Shop Name</th>
<th>Impress</th>
</tr>
</thead>
<tbody>
<?php
foreach($shops as $shop)
{
echo '<tr>';

$button ="btn btn-info";
if($shop->kind ==2){
$button ='btn btn-warning';
}	
echo '<td><button class="'.$button.'">'.$shop->name.'</button></td>';
	echo '<td>'.$shop->impression.'</td>';
echo '</tr>';	
}

?>
</tbody>
</table>
</div>





