<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
  function searchPlace(placeName) {
	var latlng = new google.maps.LatLng(39.9627960, 116.3581030);
	var myOptions = {
      zoom: 14,
      center: latlng,
	  streetViewControl: false,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
	if(placeName == '')
	{
	  placeName = '北邮';
	}
	else {
	  //placeName = '中国北京市' + placeName;
	}
	var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode( { 'address': placeName, 'region': 'CN'}, function(results, status) {
	  if (status == google.maps.GeocoderStatus.OK) {
		console.log('Get address');
		map.setCenter(results[0].geometry.location);
		var marker = new google.maps.Marker({
		  map: map,
		  position: results[0].geometry.location
		  });
	  }
	  else if (status == 'ZERO_RESULTS'){
	  }
	});
  }
</script>


<script type="text/javascript">
	$(document).ready(function(){
	  searchPlace(document.getElementById("deal_addr").innerHTML);
	});
</script>

<script type="text/javascript" >
var jiathis_config={
	data_track_clickback:true,
	summary:"",
	hideMore:false
}
</script>
<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js?uid=1551643" charset="utf-8"></script>

