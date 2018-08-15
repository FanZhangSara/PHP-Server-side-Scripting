<?php 
if(isset($_POST["keywordvalue"])){
	$keywordvalue = $_POST["keywordvalue"];
	$selectvalue = $_POST["selectvalue"];
    $distancevalue = $_POST["distancevalue"];
    $locvalue = $_POST["locvalue"];
    $lat =$_POST["lat"];
    $lon =$_POST["lon"];
    $choose =$_POST["choose"];
    // if($_POST["choose"]=="here")
    //   $distancevalue=16093;
    if($_POST["choose"]!="here"){
      $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($_POST["locvalue"]).'&key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U';
      $data = file_get_contents($url);
      $obj = json_decode($data, true);
      $lat = $obj['results'][0]['geometry']['location']['lat'];
      $lon = $obj['results'][0]['geometry']['location']['lng'];

    }
    $dis = $distancevalue*1609.344;

   // $dataurl = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=34.0223 519,-118.285117&radius=16093&type=cafe&keyword=usc&key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U';
	$dataurl = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$lat.','.$lon.'&radius='.$dis.'&type='.$selectvalue.'&keyword='.$keywordvalue.'&key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U';

	// $dataurl = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=34.0266,-118.2831&radius=16093.44&type=default&keyword=usc&key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U'; &radius=16093.44&

    $data = file_get_contents($dataurl);
   	$obj = json_decode($data, true);
   	$datares = $obj["results"];
   	$arr = array();
   	$arr1 = array();
   	$arr2 = array();
   	foreach ($datares as $infoone) {
   		$info = array('icon'=>$infoone["icon"],'name'=>$infoone["name"],'vicinity'=>$infoone["vicinity"],'id'=>$infoone["place_id"]);
   		array_push($arr1,$info);
   	}
   	$arr2['lat'] = $lat;
   	$arr2['lon'] = $lon;
   	$arr['arr1'] = $arr1;
    $arr['arr2'] = $arr2;
   $temp = json_encode($arr);
   	echo $temp;
   	return;
}

?>

<?php
if(isset($_POST["varplace"])){
	$varplace = $_POST["varplace"];
	$dataurl ='https://maps.googleapis.com/maps/api/place/details/json?placeid='.$varplace.'&key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U';
  //$dataurl ='https://maps.googleapis.com/maps/api/place/details/json?placeid=b85217d74722f6fec94a4135f209e13092d81a5e&key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U';

	$data = file_get_contents($dataurl);
   	$obj = json_decode($data, true);
   	$datares = $obj['result'];
   	$formattedadd = $datares["name"];
   	// class emp{
   	// 	public $photo="";
   	// 	public $reviews="";
   	// }
   	$arrtotal = array();
   	$arr = array();
   	$arr1 = array();
   	$arr2 = array();
   	array_push($arr2, $formattedadd);

   	if(array_key_exists("reviews", $datares)){
   		$reviewsdetail = $datares['reviews'];
   		$i = 0;
   		foreach ($reviewsdetail as $infoone) {
      		$i = $i+1;
      		if($i > 5)
        		break;
   			$info = array('author_name'=>$infoone['author_name'],'profile_photo_url'=>$infoone['profile_photo_url'],'text'=>$infoone['text']);
   			array_push($arr1, $info);
   	}
   	}

   	if(array_key_exists("photos", $datares)){
   		$photodetail = $datares['photos'];
   		$i = 0;
   		foreach ($photodetail as $infoone) {
      		$i = $i+1;
      		if($i > 5)
        		break;

   			// $info = array('photo_reference'=>$infoone['photo_reference'],'width'=>$infoone['width']);
   			// array_push($arr, $info);

   			$url = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth='.$infoone['width'].'&photoreference='.$infoone['photo_reference'].'&key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U';
   			$urldata=file_get_contents($url);
     		file_put_contents('picture'.$i.'.png',$urldata);
      		array_push($arr,'picture'.$i.'.png');

   	}
   	}




   	// $photodetail = $datares['photos'];
   	// $reviewsdetail = $datares['reviews'];
    //  $i = 0;
   	// foreach ($photodetail as $infoone) {
    //   $i = $i+1;
    //   if($i > 5)
    //     break;
   	// 	$info = array('photo_reference'=>$infoone['photo_reference'],'width'=>$infoone['width']);
   	// 	array_push($arr, $info);

   	// }
     

    // $i = 0;
   	// foreach ($reviewsdetail as $infoone) {
    //   $i = $i+1;
    //   if($i > 5)
    //     break;
   	// 	$info = array('author_name'=>$infoone['author_name'],'profile_photo_url'=>$infoone['profile_photo_url'],'text'=>$infoone['text']);
   	// 	array_push($arr1, $info);
   	// }
    $arrtotal['arr'] = $arr;
    $arrtotal['arr1'] = $arr1;
    $arrtotal['arr2'] = $arr2;
   	

   $temp = json_encode($arrtotal);
   	echo $temp;
   	return;
}
?>


 <?php 
if(isset($_POST["varmap3"])){
  $varmap3 = $_POST["varmap3"];

  $dataurl ='https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($_POST["varmap3"]).'&key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U';
  $data = file_get_contents($dataurl);
  $obj = json_decode($data, true);
  $datares = $obj["results"][0]["geometry"]["location"];
  $lat = $datares["lat"];
  $lon = $datares["lng"];
  $arr = array();
  array_push($arr,$lat);
  array_push($arr,$lon);

  $temp = json_encode($arr);
  echo $temp;
  return;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>travel and entertainment search</title>
	<style type="text/css">
		body{
			margin-top: 80px;
		}
		fieldset{
			margin: 0 auto;
			width: 800px;
			height: 260px;
			background-color: rgb(242, 245, 247);
		}
		div{
			display: inline;
		}
		ul{
			/*width: 200px;*/
			overflow: hidden;
			white-space: nowrap;
			margin: 0px;
			padding: 0px;
			/*float: left;*/
		}
		li{
			list-style: none;
			/*float: left;*/
		}
		
		.distanceleft{
			overflow: hidden;
			float: left;
		}
		.header{
			font-size: 36px;
			padding:0px;
			margin: 0px;
			text-align: center;
			font-style: oblique;
		}
		.inputspace{
			margin-left:  30px;
			margin-top: 20px;
		}
		.tablestyle, .tablestyle tr, .tablestyle tr td{
			border: 1px solid #999;
			border-collapse: collapse;
		}
		.tablestyle tr td{
			padding-left: 5px;
		}
		.tablestyle{
			margin: 0 auto;
			margin-top: 30px;
			width: 1200px;
			border-collapse: collapse;
			border: 1px solid #999;
		}
		#tablestyle1, #tablestyle1 tr, #tablestyle1 tr td,#tablestyle2, #tablestyle2 tr, #tablestyle2 tr td{
			border: 1px solid #999;
			border-collapse: collapse;
		}
		#tablestyle1, #tablestyle2{
			margin: 0 auto;
			margin-top: 30px;
			width: 900px;
			border-collapse: collapse;
			border: 1px solid #999;
			text-align: center;
		}

		.tablestr1{
			height: 60px;
		}
		.tablestr2{
			height: 30px;
		}
    .detail{
      text-align: center;
      margin: 0 auto;
      margin-top: 30px;
      
    }
    .detail img{
      width: 30px;
      height: 18px;
      margin: 0 auto;
    }
    .detail img{
      margin-left: auto;
      margin-right: auto;
      /*display: block;*/
    }
    .reviewimg{
    	margin-left: auto;
      margin-right: auto;
      display: block;
    }
    #map{
    	height: 40px;
    	width: 40px;
      position: absolute;
      z-index: 999;

    }
    .wayclass{
      display: block;
      height: 30px;
     /* background-color: rgb(195, 193, 192);*/
      background-color: rgb(212, 214, 216);
      padding-top: 10px;
      width: 90px;
      padding-left: 10px;
    }

     .wayclass:hover {
     
      background-color: rgb(189, 190, 191);
    
    }


    #img1,#img2{
    	display: block;
    }
    
	</style>
</head>
<body onload="loc()">

	<script>
		function loadJSON(url) {
            try{
                var xmlhttp=new XMLHttpRequest();
    	        xmlhttp.open("GET",url,false); //open, send, responseText are
    	        xmlhttp.send(); //properties of XMLHTTPRequest
            if (xmlhttp.status!=200){
                alert("no file");
                return;
            }
    	return xmlhttp.responseText;
    }
	catch(err){
    	alert("no file");
        return;
	}
}
				// $.getJSON( '//freegeoip.net/json/?callback=?', function( data ) {
				// 	console.log( JSON.stringify( data, null, 2 ) );
    //         });
        function loc(){
        	// document.getElementById('inputspace').disabled = false;
        	var data = JSON.parse(loadJSON("http://ip-api.com/json"));
        	// latdata = data.lat;
        	//londata = data.lon;
        	// document.innerHTML("<p>you are right</p>");
        	document.getElementById("buttonid").removeAttribute("disabled");
        }
        function clicksearch(){
            var str = document.getElementById("Keywordinput").value;
            if(str.length == 0){
            	document.getElementById("Keywordinput").focus();
        	    // alert("Keyword");
            }
        }
        function locationdis(){
        	//alert("hr");
        	document.getElementById('locationtext').disabled = false;
        }
        function locationdiss(){
        	document.getElementById('locationtext').disabled = true;
        }
        function clearform(){
        	document.getElementById('formname').reset();
        	document.getElementById("tableid").innerHTML = "";
        }



         //show all tablelist
        function locfunc(){
    		var xmlhttp = new XMLHttpRequest();
    		xmlhttp.onreadystatechange=function() {
    			//alert("hello1");
    			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          		// if () {
          			//alert("hello1");
          			var myObj0 = JSON.parse(xmlhttp.responseText);
          			var myObj = myObj0.arr1;
          			var latupper = myObj0.arr2.lat;
          			//alert(latupper);
          			var lonupper = myObj0.arr2.lon;
          			// alert("hello2");
          			//document.getElementById("tableid").innerHTML = myObj;
          			var html_text = "";
          			html_text += "<table class=\"tablestyle\" style='z-index:1'>";
          			if(myObj.length==0){
          				html_text += "<tr><td style='text-align:center'>No Records has been Found</td></tr>";
          			}else{
	          			html_text += "<tr class=\"tabletr1\"><td style='width:100px;text-align:center'>Category</td><td style='width:520px;text-align:center'>Name</td><td style='text-align:center'>Address</td></tr>";
	          			for(var i=0; i<myObj.length;i++){
	          				// html_text += "<tr class=\"tabletr2\"><td><img src=\""+myObj[i].icon+"\"</td><td onclick=showdetail(\'" + myObj[i].id + "\',\'" +myObj[i].name+ "\')>"+myObj[i].name+"</td><td><a href=\"\">"+myObj[i].vicinity+"</a></td></tr>";
	                  html_text += "<tr class=\"tabletr2\"><td><img  src=\""+myObj[i].icon+"\" width=30px, height=25px></td><td onclick=\"showdetail(\'" + myObj[i].id + "\')\">"+myObj[i].name+"</td><td><div class=\"uppermap\" style='display:block' onclick=\"initMap(\'" + myObj[i].vicinity +  "\',\'" + i +"\',\'"+latupper+"\',\'"+lonupper+"\')\">"+myObj[i].vicinity+"</div><div id=\"waydiff"+i+"\"  style='z-index:5;position:absolute'></div><div id=\"map"+i+"\" style='display:none;margin-top:0px;z-index:4;width:400px;height:300px;position:absolute'></div></td></tr>";
	                  //alert(myObj[i].id);
	          			}
          		}
          			/// html_text += "<tr><td>Category</td><td>Name</td><td>Address</td></tr>"; myObj[i].id <div id=\"map\"></div></td></tr>";
                //alert(myObj[0].id);
          			html_text += "</table>";
                //11html_text += "<div id=\"map\"></div>";
          			document.getElementById("tableid").innerHTML = html_text;
			}
    		};
    		
          var keywordvalue = document.getElementById("Keywordinput").value;  
        	// alert("qqq");
            var selectvalue = document.getElementById("selectCate").value;  
            var locvalue = document.getElementsByName("location"); //getElementById("radioid").value; getElementsByName("location").value; 
            var lat;
            var lon;
            var distancevalue;
            distancevalue = document.getElementById("disind").value;
            if(distancevalue==''){
              distancevalue = 10;
            }
           

              var data = JSON.parse(loadJSON("http://ip-api.com/json"));
              lat = data.lat;
              lon = data.lon;
              //distancevalue = 10;
          //   }else{

          //     var xmlhttp1 = new XMLHttpRequest();
          //   xmlhttp1.onreadystatechange=function() {
          // alert("hello1");
          // if (xmlhttp1.readyState == 4 && xmlhttp1.status == 200) {
          //     // if () {
          //       //alert("hello1");
          //       var myObj = JSON.parse(xmlhttp1.responseText);
          //       lat = myObj[0];
          //       lon = myObj[1];
          //     }
          //   };
              

          //     var address = document.getElementById("locationtext").value;  
          //     //alert(address);
          //     var formData = new FormData();
          //     formData.append("address",address);
          //     xmlhttp.open("POST", "<?php echo $_SERVER['PHP_SELF'];?>", false);
          //     xmlhttp.send(formData);
          //     return false;




          //   }
           
       // var choose = document.getElementById(locationtext).value;
       
    		var formData = new FormData();
    		formData.append("keywordvalue",keywordvalue);
    		formData.append("selectvalue",selectvalue);
    		formData.append("locvalue",document.getElementById("locationtext").value);
        formData.append("distancevalue",distancevalue);
    		formData.append("lat",lat);
        formData.append("lon",lon);
        if(document.getElementById("locationtext").disabled==true)
            formData.append("choose","here");
          else
            formData.append("choose","input");
        

    		//var xmlhttp = new XMLHttpRequest();
    		xmlhttp.open("POST", "<?php echo $_SERVER['PHP_SELF'];?>", false);
    		xmlhttp.send(formData);
    		return false;
        }



//review all the detail and photo details var1
        function showdetail(var1){
        	//alert("helloooooo");
        var xmlhttp = new XMLHttpRequest();
    		xmlhttp.onreadystatechange=function() {
    			//alert("hello1qq");
    			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            

          			var myObj = JSON.parse(xmlhttp.responseText);          			
          			var html_text = "";
                html_text += "<div class=\"detail\">";
                html_text += "<p class=\"detail\"><b>"+myObj.arr2[0]+"</b></p>";
                html_text += "<div><p>click to show reviews</p><div text-align=\"center\"><img id=\"img1\"src=\"http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png\" onclick=\"showreview()\"></div></div>";
                html_text += "<table id=\"tablestyle1\" style=\"display:none\">";
                if(myObj.arr1.length==0){
                	html_text += "<tr><td>No Reviews Found</td></tr>";
                }else{
	                // html_text += "<table id=\"tablestyle1\" style=\"display:none\">";
	                for( var i = 0; i < myObj.arr1.length;i++){
	                  //html_text +="<tr><td>"+myObj.arr1[i].profile_photo_url+myObj.arr1[i].author_name+"</td></tr>";
	                  html_text +="<tr style=\"height:30px\"><td style=\"height:30px\"><div><img src=\""+myObj.arr1[i].profile_photo_url+"?time="+Math.floor(Math.random()*1000)+"\"><b>"+myObj.arr1[i].author_name+"</b></div></td></tr>";
	                  html_text +="<tr style=\"height:20px\"><td style=\"height:20px\">"+myObj.arr1[i].text+"</td></tr>";
	                }
	                // html_text += "</table>"; img src=\""+myObj.arr1[i].profile_photo_url+"\">
                }
                html_text += "</table>";


                html_text += "<div><p>click to show photos</p><img id=\"img2\" onclick=\"showphoto()\" src=\"http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png\"></div>";
                html_text += "</div>";
                html_text += "<table id=\"tablestyle2\" style=\"display:none;width:750px;\">";
                if(myObj.arr.length==0){
                	html_text += "<tr><td>No Photos Found</td></tr>";
                }else{
	                for( var i = 0; i < myObj.arr.length;i++){
	                  //html_text +="<tr><td>"+myObj.arr1[i].profile_photo_url+myObj.arr1[i].author_name+"</td></tr>";
	                  html_text +="<tr><td style=\"padding-top:20px;padding-bottom:20px\"><div><a href=\""+myObj.arr[i]+"\" target=\"blank\"><img class=\"reviewimg\" src=\""+myObj.arr[i]+"\" width=700px, height=500px></a></div></td></tr>";
	                }
                // for( var i = 0; i < myObj.arr.length;i++){
                //   //html_text +="<tr><td>"+myObj.arr1[i].profile_photo_url+myObj.arr1[i].author_name+"</td></tr>";
                //   html_text +="<tr><td><div><img src=\""+myObj.arr1[i].profile_photo_url+"\"</div></td></tr>";
                // }
            }
                html_text += "</table>";
          			document.getElementById("tableid").innerHTML = html_text;
				} 
    		};
    		
        var varplace = var1;  
        //alert(varplace);
    		var formData = new FormData();
    		formData.append("varplace",varplace);
 

    		//var xmlhttp = new XMLHttpRequest();
    		xmlhttp.open("POST", "<?php echo $_SERVER['PHP_SELF'];?>", false);
    		xmlhttp.send(formData);
        //alert(varplace);
    		return false;
        }



        function showreview(){
        	if(document.getElementById("img1").src=="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png")
        		document.getElementById("img1").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png";
        	else
        		document.getElementById("img1").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png";
          //document.getElementById("img1").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png";
          var target = document.getElementById("tablestyle1");
          if(target.style.display=="none"){
          	target.style.display="";
          	if(document.getElementById("tablestyle2").style.display!="none"){
          		document.getElementById("tablestyle2").style.display="none";
          		document.getElementById("img2").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png";
          	}
          }
          	
          else
          	target.style.display = "none";

        }
        function showphoto(){
        	if(document.getElementById("img2").src=="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png")
        		document.getElementById("img2").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png";
        	else
        		document.getElementById("img2").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png";
          var target = document.getElementById("tablestyle2");
          if(target.style.display=="none"){
          	target.style.display="";
          	if(document.getElementById("tablestyle1").style.display!="none"){
          		document.getElementById("tablestyle1").style.display="none";
          		document.getElementById("img1").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png";
          	}
          }
          else
          	target.style.display = "none";

        }

        function initMap(var3,i,latupper,lonupper) {
          var lat;
          var lon;
          directionsService = new google.maps.DirectionsService();
  		  directionsDisplay = new google.maps.DirectionsRenderer();


          if(document.getElementById('map'+i).style.display=="none"){
            document.getElementById('map'+i).style.display="block";
            document.getElementById('waydiff'+i).style.display="block";
          }else{
            document.getElementById('map'+i).style.display="none";
            document.getElementById('waydiff'+i).style.display="none";
          }

          //alert(var3);
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange=function() {
          //alert("hello1qq");
	          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	            //alert(xmlhttp.responseText);

	                var myObj = JSON.parse(xmlhttp.responseText); 
	                
	                var varf = var3;
	                
	                lat = myObj[0];
	                lon = myObj[1]; 
	                var html_text = "";
	                html_text += "<div class=\'wayclass\' onclick=\"calcRouteW(\'"+lat+ "\',\'"+lon+ "\',\'"+latupper+"\',\'"+lonupper+"\')\">Walk there</div>";
	                html_text += "<div class=\'wayclass\' onclick=\"calcRouteB(\'"+var3+ "\',\'"+latupper+"\',\'"+lonupper+"\')\">Bike there</div>";
	                html_text += "<div class=\'wayclass\' onclick=\"calcRouteD(\'"+var3+ "\',\'"+latupper+"\',\'"+lonupper+"\')\">Drive there</div>";
	                
	                document.getElementById('waydiff'+i).innerHTML = html_text;

	                
	                

	                var uluru = {lat: lat, lng: lon};
	                map = new google.maps.Map(document.getElementById('map'+i), {
	                  zoom: 14,
	                  center: uluru
	                });
	                directionsDisplay.setMap(map);

	                marker = new google.maps.Marker({
	                position: uluru,
	                map: map
	        		});

            	}
        	};
            var varmap3 = var3;
            var formData = new FormData();
            formData.append("varmap3",varmap3);

        //var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", "<?php echo $_SERVER['PHP_SELF'];?>", false);
        xmlhttp.send(formData);
        //alert(varplace);
        return false;
      }


      function calcRouteW(lat,lon,latupper,lonupper){

	      	var start = latupper + "," + lonupper;
	  		var end = lat + "," + lon;
	  		var request = {
	    		origin: start,
	    		destination: end,
	    		travelMode: 'WALKING'
	  		};
	  		directionsService.route(request, function(result, status) {
		    		if (status == 'OK') {
		      	directionsDisplay.setDirections(result);
		    	}
	  		});
	  		marker.setMap(null);

      }


      function calcRouteB(var3,latupper,lonupper){
      	
      	var start = latupper + "," + lonupper;
  		var end = var3;
  		var request = {
    		origin: start,
    		destination: end,
    		travelMode: 'BICYCLING'
  		};
  		directionsService.route(request, function(result, status) {
    		if (status == 'OK') {
      	directionsDisplay.setDirections(result);
    }
  });
  		marker.setMap(null);

      }

      function calcRouteD(var3,latupper,lonupper){
      
      	var start = latupper + "," + lonupper;
  		var end = var3;
  		var request = {
    		origin: start,
    		destination: end,
    		travelMode: 'DRIVING'
  		};
  		directionsService.route(request, function(result, status) {
    		if (status == 'OK') {
      	directionsDisplay.setDirections(result);
    }
  });
  		marker.setMap(null);

      }



	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U&callback=initMap">
    </script>


	<fieldset> 
		<legend accesskey="I"> </legend>
		<form id = "formname" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return locfunc()">
			<p  class="header">travel and entertainment search</p>
			<hr>
			<p><strong>Keyword:</strong><INPUT id="Keywordinput" NAME="keyword" TYPE="text" SIZE=20 required></P>
			<P><strong>Category: </strong><select name="selectCat" id="selectCate">
				<option value="default">default</option>
				<option value="cafe">cafe</option>
				<option value="bakery">bakery</option>
				<option value="restaurant">restaurant</option>
				<option value="beauty salon">beauty salon</option>
				<option value="casino">casino</option>
				<option value="movie theater">movie theater</option>
				<option value="lodging">lodging</option>
				<option value="airport">airport</option>
				<option value="train station">train station</option>
				<option value="subway station">subway station</option>
				<option value="bus station">bus station</option>
			</select></P>
			<div class="distanceleft"><strong>Distance(miles):</strong> <INPUT id ="disind" TYPE="text" NAME="in_ssn" placeholder="10"> <strong>from</strong></div>
			<div>
				<ul>
					<li><INPUT id="radioid" TYPE="radio" Name="location" VALUE="here" checked="checked" onclick = "locationdiss()" >Here</INPUT></li>
					<li><INPUT TYPE="radio" Name="location" VALUE="defaulttt" onclick = "locationdis()"><INPUT id="locationtext" NAME="in_name" TYPE="text" SIZE=20 placeholder="location" required disabled></INPUT></li>
				</ul>
        <input id = "latid" type="text" name="latname" hidden></INPUT>
        <input id="lonid" type="text" name="lonname" hidden></input>
			</div>
			
			
			<INPUT class="inputspace" id="buttonid" name="searchsubmit" TYPE="submit" VALUE="Search" onclick = "clicksearch()" disabled></INPUT> 
			<INPUT class="clearbutton" TYPE="reset" VALUE="Clear" onclick = "clearform()"></INPUT>

		</form>
	</fieldset>

   
	<div id ="tableid" hidden></div>
  <!-- <div id ="tableid1" hidden>jjjjjj<div id="map"></div></div> -->
</body>
</html>