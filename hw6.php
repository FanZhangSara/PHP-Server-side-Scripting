<?php 
if(isset($_POST["keywordvalue"])){
	$keywordvalue = $_POST["keywordvalue"];
	$selectvalue = $_POST["selectvalue"];
    $distancevalue = $_POST["distancevalue"];
    $locvalue = $_POST["locvalue"];
    $lat ="";
    $lon ="";


   // $dataurl = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=34.0223 519,-118.285117&radius=10&type=cafe&keyword='.$keywordvalue.'&key=AIzaSyC3DRB2N8kSlNHowNfNCSPFNSMlEiTTp98';
	$dataurl = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=34.0266,-118.2831&radius=16093.44&type='.$selectvalue.'&keyword='.$keywordvalue.'&key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U';

	// $dataurl = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=34.0266,-118.2831&radius=16093.44&type=default&keyword=usc&key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U';

    $data = file_get_contents($dataurl);
   	$obj = json_decode($data, true);
   	$datares = $obj["results"];
   	$arr = array();
   	foreach ($datares as $infoone) {
   		$info = array('icon'=>$infoone["icon"],'name'=>$infoone["name"],'vicinity'=>$infoone["vicinity"],'id'=>$infoone["place_id"]);
   		array_push($arr,$info);
   	}
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
   	// class emp{
   	// 	public $photo="";
   	// 	public $reviews="";
   	// }
   	$arrtotal = array();
   	$arr = array();
   	$arr1 = array();
   	$photodetail = $datares['photos'];
   	$reviewsdetail = $datares['reviews'];
     $i = 0;
   	foreach ($photodetail as $infoone) {
      $i = $i+1;
      if($i > 5)
        break;
   		//$info = array('photo_reference'=>$infoone['photo_reference'],'width'=>$infoone['width']);
   		//array_push($arr, $info);
	    


      //$url = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth='.$infoone['width'].'&photoreference='.$infoone['photo_reference'].'&key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U';
       $url = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=750&photoreference=CnRtAAAATLZNl354RwP_9UKbQ_5Psy40texXePv4oAlgP4qNEkdIrkyse7rPXYGd9D_Uj1rVsQdWT4oRz4QrYAJNpFX7rzqqMlZw2h2E2y5IKMUZ7ouD_SlcHxYq1yL4KbKUv3qtWgTK0A6QbGh87GB3sscrHRIQiG2RrmU_jF4tENr9wGS_YxoUSSDrYjWmrNfeEHSGSc3FyhNLlBU&key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U';

      $urldata=file_get_contents($url);
      file_put_contents('picture'.$i.'.png',$urldata);
      array_push($arr,'picture'.$i.'.png');

   	}
     // if((count($photodetail)<=5)&&(count($photodetail)>=0)){
     // 	for($i=0;$i<count($photodetail);$i++){
     // 		$url = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=750&photoreference=CnRtAAAATLZNl354RwP_9UKbQ_5Psy40texXePv4oAlgP4qNEkdIrkyse7rPXYGd9D_Uj1rVsQdWT4oRz4QrYAJNpFX7rzqqMlZw2h2E2y5IKMUZ7ouD_SlcHxYq1yL4KbKUv3qtWgTK0A6QbGh87GB3sscrHRIQiG2RrmU_jF4tENr9wGS_YxoUSSDrYjWmrNfeEHSGSc3FyhNLlBU&key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U';
     // 		//$url = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth='.$photodetail[$i]['width'].'&photoreference='.$photodetail[$i]['photo_reference'].'&key=AIzaSyBix1e20sK7gC5h48EvDc7SbRhVdn5GH8U';
     // 		$dataa = file_get_contents($url);
     // 		file_put_contents('picture'.$i, $dataa);
     // 		array_push($arr,'picture'.$i);
     // 	}
     // }

    $i = 0;
   	foreach ($reviewsdetail as $infoone) {
      $i = $i+1;
      if($i > 5)
        break;
   		$info = array('author_name'=>$infoone['author_name'],'profile_photo_url'=>$infoone['profile_photo_url'],'text'=>$infoone['text']);
   		array_push($arr1, $info);
   	}
    $arrtotal['arr'] = $arr;
    $arrtotal['arr1'] = $arr1;
   	// array_push($arrtotal,$arr);
   	// array_push($arrtotal,$arr1);

   $temp = json_encode($arrtotal);
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
      display: block;
    }
    .reviewimg{
    	margin-left: auto;
      margin-right: auto;
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
        	// alert(data.lat);
        	// latdata = data.lat;
        	//londata = data.lon;
        	// document.innerHTML("<p>you are right</p>");
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
        }



         //show all tablelist
        function locfunc(){
    		var xmlhttp = new XMLHttpRequest();
    		xmlhttp.onreadystatechange=function() {
    			//alert("hello1");
    			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          		// if () {
          			//alert("hello1");
          			var myObj = JSON.parse(xmlhttp.responseText);
          			// alert("hello2");
          			//document.getElementById("tableid").innerHTML = myObj;
          			var html_text = "";
          			html_text += "<table class=\"tablestyle\">";
          			html_text += "<tr class=\"tabletr1\"><td>Category</td><td>Name</td><td>Address</td></tr>";
          			for(var i=0; i<myObj.length;i++){
          				// html_text += "<tr class=\"tabletr2\"><td><img src=\""+myObj[i].icon+"\"</td><td onclick=showdetail(\'" + myObj[i].id + "\',\'" +myObj[i].name+ "\')>"+myObj[i].name+"</td><td><a href=\"\">"+myObj[i].vicinity+"</a></td></tr>";
                  html_text += "<tr class=\"tabletr2\"><td><img src=\""+myObj[i].icon+"\"</td><td onclick=\"showdetail(\'" + myObj[i].id + "\',\'" + myObj[i].name + "\')\">"+myObj[i].name+"</td><td onclick=\"showmap()\">"+myObj[i].vicinity+"</td></tr>";
          			}
          			// html_text += "<tr><td>Category</td><td>Name</td><td>Address</td></tr>"; myObj[i].id
                //alert(myObj[0].id);
          			html_text += "</table>";
          			document.getElementById("tableid").innerHTML = html_text;
				} 
    		};
    		
          var keywordvalue = document.getElementById("Keywordinput").value;  
        	// alert("qqq");
            var selectvalue = document.getElementById("selectCate").value;  
            var distancevalue = document.getElementById("disind").value;
            var locvalue = document.getElementById("radioid").value;
            // if(locvalue == "default")
            // 	locvalue = document.getElementById("locationtext").value;

    		var formData = new FormData();
    		formData.append("keywordvalue",keywordvalue);
    		formData.append("selectvalue",selectvalue);
    		formData.append("distancevalue",distancevalue);
    		formData.append("locvalue",locvalue);

    		//var xmlhttp = new XMLHttpRequest();
    		xmlhttp.open("POST", "<?php echo $_SERVER['PHP_SELF'];?>", false);
    		xmlhttp.send(formData);
    		return false;
        }

//review all the detail and photo details var1
        function showdetail(var1,var2){
        	//alert("helloooooo");
        var xmlhttp = new XMLHttpRequest();
    		xmlhttp.onreadystatechange=function() {
    			//alert("hello1qq");
    			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            alert(xmlhttp.responseText);

          			var myObj = JSON.parse(xmlhttp.responseText);          			
          			var html_text = "";
                html_text += "<div class=\"detail\">";
                html_text += "<p class=\"detail\">"+var2+"</p>";
                html_text += "<div><p>click to show reviews</p><div text-align=\"center\"><img id=\"img1\"src=\"http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png\" onclick=\"showreview()\"></div></div>";
                html_text += "<table id=\"tablestyle1\" style=\"display:none\">";
                for( var i = 0; i < myObj.arr1.length;i++){
                  //html_text +="<tr><td>"+myObj.arr1[i].profile_photo_url+myObj.arr1[i].author_name+"</td></tr>";
                  html_text +="<tr><td><img src=\""+myObj.arr1[i].profile_photo_url+"\">"+myObj.arr1[i].author_name+"</td></tr>";
                  html_text +="<tr><td>"+myObj.arr1[i].text+"</td></tr>";
                }
                html_text += "</table>";


                html_text += "<div><p>click to show photos</p><img id=\"img2\" onclick=\"showphoto()\" src=\"http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png\"></div>";
                html_text += "</div>";
                html_text += "<table id=\"tablestyle2\" style=\"display:none\">";
                for( var i = 0; i < myObj.arr.length;i++){
                  //html_text +="<tr><td>"+myObj.arr1[i].profile_photo_url+myObj.arr1[i].author_name+"</td></tr>";
                  html_text +="<tr><td><div><img class=\"reviewimg\" src=\""+myObj.arr[i]+"\"</div></td></tr>";
                }
                // for( var i = 0; i < myObj.arr.length;i++){
                //   //html_text +="<tr><td>"+myObj.arr1[i].profile_photo_url+myObj.arr1[i].author_name+"</td></tr>";
                //   html_text +="<tr><td><div><img src=\""+myObj.arr1[i].profile_photo_url+"\"</div></td></tr>";
                // }
                html_text += "</table>";
          			// html_text += "<tr class='tabletr1'><td>Category</td><td>Name</td><td>Address</td></tr>";
          			// for(var i=0; i<myObj.length;i++){
          			// 	html_text += '<tr class="tabletr2"><td><img src="'+myObj[i].icon+'"</td><td onclick="showdetail()">'+myObj[i].name+'</td><td><a href="">'+myObj[i].vicinity+'</a></td></tr>';
          			// }
          			// // html_text += "<tr><td>Category</td><td>Name</td><td>Address</td></tr>";

          			// html_text += "</table>";
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
          if(target.style.display=="none")
          	target.style.display="";
          else
          	target.style.display = "none";

        }
        function showphoto(){
        	if(document.getElementById("img2").src=="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png")
        		document.getElementById("img2").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png";
        	else
        		document.getElementById("img2").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png";
          var target = document.getElementById("tablestyle2");
          if(target.style.display=="none")
          	target.style.display="";
          else
          	target.style.display = "none";

        }
        function showmap(){
        	alert("hello");
        }


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
					<li><INPUT id="radioid" TYPE="radio" Name="location" VALUE="here" checked>Here</INPUT></li>
					<li><INPUT TYPE="radio" Name="location" VALUE="default" onclick = "locationdis()"><INPUT id="locationtext" NAME="in_name" TYPE="text" SIZE=20 placeholder="location" required disabled onclick = "locationdiss()"></INPUT></li>
				</ul>
			</div>
			
			
			<INPUT class="inputspace" name="searchsubmit" TYPE="submit" VALUE="Search" onclick = "clicksearch()"></INPUT> 
			<INPUT class="clearbutton" TYPE="button" VALUE="Clear" onclick = "clearform()"></INPUT>

		</form>
	</fieldset>

   
	<div id ="tableid">iiiiiiiii</div>
</body>
</html>