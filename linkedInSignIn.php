<html>
<head>
<title>Profile App Example</title>

<script type="text/javascript" src="http://platform.linkedin.com/in.js">
  api_key: rbjecyqtr9pn
  authorize: true
</script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.5b1.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>  

<script type="text/javascript">

function loadData(){
	IN.API.MemberUpdates("url=http://www.linkedin.com/in/kanap008")
		.fields(["updateContent:(person:(headline,first-name,id))"])
	.result(function(result){
	   alert (JSON.stringify(result))
	})
}
//function loadData() {
//IN.API.Profile("me").fields(["firstName","headline","positions:(company)"])
//   .result(function(result) { 
//      $("#profile").html('<script type="IN/FullMemberProfile" data-id="' + result.values[0].id + '"><script>');
//      IN.parse(document.getElementById("profile"))
//   })
//}

function getMemberUpdates(){
	IN.API.MemberUpdates("me")
	.fields(["isLiked","updateContent:(person:(headline,first-name))"])
	.result(function(result){
		
	})
}


function displayNetworkUpdates(updates) {
	  var profileDiv = document.getElementById("profile");
	     
	  for (var i in updates.values) {
	    var key = updates.values[i].updateKey; // unique key used to reference <p> in Raw API call results
	    var share = updates.values[i].updateContent.person; // person making update
	    profileDiv.innerHTML += "<p id='" + key + "'>" + share.firstName + " " + share.lastName
	      + " shared " + share.currentShare.comment + ".</p>";

	    IN.API.Raw("/people/~/network/updates/key=" + key + "/likes") // construct REST URL
	      .result( function(value) { return function(likes) { // need to wrap inside function to get proper key
	        document.getElementById(value).innerHTML += " (Liked by " + likes._total + " people)";
	       } }(key))
	      .error( function(error) { /* do nothing */ } );
	  }
	}

//function getProfile(){
//	IN.API.Profile("me")
//	   .result(function(result) { 
//	      $("#profile").html('<script type="IN/FullMemberProfile" data-id="Hv3V1lv4SQ" data-firstName="Nikhil" data-lastName="Bhagwat"><script>');
//	      IN.parse(document.getElementById("name"))
//	   })
//}

</script>

</head>

<body class="yui3-skin-sam     yui-skin-sam">
<div id="profile"></div>

<script type="IN/Login" data-onAuth="loadData"></script>
</body>
</html>