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
?>
	data.push({position: new google.maps.LatLng(<?php echo $shop->lat ?>,<?php echo $shop->lng ?>), content: '<?php echo $shop->name?>'});
<?php
}
?>

	/* 地図のオプション設定 */
	var myOptions={
		/*初期のズーム レベル */
		zoom: 17,
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
			title:"hogehoge",
			icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=麺|7FFF00|000000'
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
alert(sad);
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
	$.post("index.php?r=site/add", { 
		name: $("#address").val(),
		lat: results[ 0 ].geometry.location.lat(),
		lng: results[ 0 ].geometry.location.lng(),
		
 })
.done(function(data) {
alert("Data Loaded: " + data);
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
  width: 600px;
  height: 371px;
}
</style>

</head>

<body>
<form>
<label class="label">地図表示位置</label>
緯度: <input type="text" name="lat" id="lat" />
経度: <input type="text" name="lng" id="lng" />
店名: <input type="text" name="name" id="name" />
住所: <input type="text" name="address" id="address" />

<button id="getad">お店を登録</button>
</form>

<div id="map_canvas"></div>

</body>
</html>

