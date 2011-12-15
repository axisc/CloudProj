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

function loadData() {
	IN.API.Profile("url=http://www.linkedin.com/in/nitinnatarajan","http://www.linkedin.com/pub/sandeep-ranganathan/37/667/708")
		.fields("firstName", "lastName", "industry", "date-of-birth")
	   	.result(displayProfiles)
	   	.error(displayProfilesErrors);
	IN.API.Connections("me")
		.fields("id", "firstName", "lastName", "industry")
		.params({"start":0, "count":5})
		.result(displayConnections)
		.error(displayConnectionsErrors);
	IN.API.PeopleSearch()
	  	.fields("firstName", "lastName", "positions")
  		.params({"title": "Student", "current-title": true})
	  	.result(displayPeopleSearch)
	  	.error(displayPeopleSearchError);
	IN.API.NetworkUpdates()
	    .params({"type": "SHAR", "count": 5}) // get the five most-recent Shares
	    .result(displayNetworkUpdates)
	    .error(displayNetworkUpdatesError);
	IN.API.MemberUpdates("me")
	    .params({"type": ["SHAR", "APPS"], "count": 5}) // get the five most-recent Shares and Application Updates 
	                                                    // for the viewer and EjDUWNoC3C
	    .result(displayNetworkUpdates)
	    .error(displayNetworkUpdatesError);
}

function displayProfiles(profiles) {
	var profilesDiv = document.getElementById("profiles");
  	var members = profiles.values;
  	for (var member in members) {
    	profilesDiv.innerHTML += "<p>" + members[member].firstName + " " + members[member].lastName 
      		+ " works in the " + members[member].industry + " industry and born on " 
      		+ members[member].dateOfBirth.month + "/" + members[member].dateOfBirth.day 
      		+ "/" + members[member].dateOfBirth.year;
	}
}

function displayConnections(connections) {
  	var connectionsDiv = document.getElementById("connections");

  	connectionsDiv.innerHTML += "<p> Retrieved the first " + connections._count + " from a total of " 
	  		+ connections._total + " connections </p>";
  	var members = connections.values; // The list of members you are connected to
  	for (var member in members) {
    	connectionsDiv.innerHTML += "<p>" + members[member].firstName + " " + members[member].lastName
      		+ " works in the " + members[member].industry + " industry ... " + members[member].id + "</p>";
	}     
}

function displayPeopleSearch(peopleSearch) {
  	var peopleSearchDiv = document.getElementById("peoplesearch");
	     
  	var members = peopleSearch.people.values; // people are stored in a different spot than earlier example
  	for (var member in members) {
	    // but inside the loop, everything is the same
	    // extract the title from the members first position
	    	peopleSearchDiv.innerHTML += "<p>" + members[member].firstName + " " + members[member].lastName 
	      		+ " is a " + members[member].positions.values[0].title + ".</p>";
  	}
}

function displayNetworkUpdates(updates) {
  	var profileDiv = document.getElementById("networkupdates");
     
  	for (var i in updates.values) {
    	var key = updates.values[i].updateKey; // each update has a unique key
    	var share = updates.values[i].updateContent.person; // the person sharing content
    	profileDiv.innerHTML += "<p id='" + key + "'>" + share.firstName + " " + share.lastName 
    	  	+ " shared " + share.currentShare.comment + ".</p>";
   	}     
}

function displayProfilesErrors(error) {
  	profilesDiv = document.getElementById("profiles");
  	profilesDiv.innerHTML = "<p>Oops! </p> ERROR:" + error.message;
	console.log(error);
}

function displayConnectionsErrors(error) {
  	profilesDiv = document.getElementById("connections");
  	profilesDiv.innerHTML = "<p>Oops! </p> ERROR:" + error.message;
	console.log(error);
}

function displayPeopleSearchError(error) {
  	profilesDiv = document.getElementById("peoplesearch");
  	profilesDiv.innerHTML = "<p>Oops! </p> ERROR:" + error.message;
	console.log(error);
}

function displayNetworkUpdatesError(error) {
  	profilesDiv = document.getElementById("peoplesearch");
  	profilesDiv.innerHTML = "<p>Oops! </p> ERROR:" + error.message;
	console.log(error);
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

<br/>---------------------------profiles------------------------------<br/>
<div id="profiles"></div>
<br/>---------------------------connections------------------------------<br/>
<div id="connections"></div>
<br/>---------------------------peoplesearch------------------------------<br/>
<div id="peoplesearch"></div>
<br/>---------------------------networkupdates------------------------------<br/>
<div id="networkupdates"></div>

<script type="IN/Login" data-onAuth="loadData"></script>

<script type="IN/MemberData" 
	data-ids="me,Qu3JfGtTrW"
	data-fields="firstName,lastName,industry">

<ul>
<?js for (var member in $("*")) { ?>
    <li>
		<?js if ($(member).pictureUrl) { ?>
  			<img src="<?js= $("me").pictureUrl ?>"> </img>
		<?js } else { ?>
 			<p>Upload a photo, so we can see what you look like.</p>
		<?js } ?>
    	<?js= $(member).firstName ?> <?js= $(member).lastName ?> 
    	works in the <?js= $(member).industry ?> profession.
	</li>
<?js } ?>
</ul>

</script>



</body>
</html>