<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LinkedIn JavaScript API Sample Application</title>
<!-- Load in the JavaScript framework and register a callback function when it's loaded -->
<script type="text/javascript" src="http://platform.linkedin.com/in.js">
api_key: rbjecyqtr9pn
onLoad: onLinkedInLoad
authorize: true
</script>
 
<script type="text/javascript">
function onLinkedInLoad() {
     // Listen for an auth event to occur
     IN.Event.on(IN, "auth", onLinkedInAuth);
}
 
function onLinkedInAuth() {
     // After they've signed-in, print a form to enable keyword searching
     var div = document.getElementById("peopleSearchForm");
 
     div.innerHTML = '<h2>Find People on LinkedIn</h2>';
     div.innerHTML += '<form action="javascript:PeopleSearch();">' +
                      '<input id="keywords" size="30" value="Ashish Chhabria" type="text">' +
                      '<input type="submit" value="Search!" /></form>';
}
 
function PeopleSearch(keywords) {
     // Call the PeopleSearch API with the viewer's keywords
     // Ask for 4 fields to be returned: first name, last name, distance, and Profile URL
     // Limit results to 10 and sort by distance
     // On success, call displayPeopleSearch(); On failure, do nothing.
     var keywords = document.getElementById('keywords').value; 
     IN.API.PeopleSearch()
         .fields("firstName", "lastName", "distance", "siteStandardProfileRequest"
                 , "educations", "pictureUrl", "skills", "positions")
         .params({"keywords": keywords, "count": 3, "sort": "distance"})
         .result(displayPeopleSearch)
         .error(function error(e) { document.getElementById("errorField").innerHTML = "<p> Error::: "+ e.message +" </p>"; }
     );
}
 
function displayPeopleSearch(peopleSearch) {
     var div = document.getElementById("peopleSearchResults");
 
     div.innerHTML = "<ul>";
 
     // Loop through the people returned
     var members = peopleSearch.people.values;
     for (var member in members) {
 
         // Look through result to make name
         var nameText = members[member].firstName + " " + members[member].lastName;

         // Get the linkedIn Profile URL
         var url = members[member].siteStandardProfileRequest.url;
 
         // Get the degrees of connection
         var distance = members[member].distance;
         var distanceText = '';
         switch (distance) {
         case 0:  // The viewer
             distanceText = "you!"
             break;
         case 1: // Within three degrees
         case 2: // Falling through
         case 3: // Keep falling!
             distanceText = "a connection " + distance + " degrees away.";
             break;
         case 100: // Share a group, but nothing else
             distanceText = "a fellow group member.";
             break;
         case -1: // Out of netowrk
         default: // Hope we never get this!
             distanceText = "far, far, away.";
         }

         //Get Educations
         var educationText = "<br/> Education:: ";
         if(members[member].educations != null){
        	 var edus = members[member].educations.values;
             for(var edu in edus){
             	educationText += "<br/>- Degree: " + edus[edu].degree + " at <b>" 
             		+ edus[edu].schoolName + "</b> (" + edus[edu].endDate.year + ")";
             }
         } else {
        	 educationText += "N/A";
         }

         // Get the profile image
         var profileImageURL = members[member].pictureUrl;

         // Get the users skills
         var skillsText = "<br/> Skills:: ";
         if(members[member].skills != null){
         	var skills = members[member].skills.values;
         	for(var skill in skills){
             	skillsText += "<br/> - Skill: " + skills[skill].proficiency.name  + " at " 
             		+ skills[skill].skill.name + " with " + skills[skill].years.name + " years of expierence.";
         	}
         } else {
			skillsText += "N/A";	
         }

		 // Get the users positions
         var positionsText = "<br/> Positions:: ";
         if(members[member].positions != null){
         	var poss = members[member].positions.values;
         	for(var pos in poss){
             	positionsText += "<br/> - Worked as " + poss[pos].title + " at <b>"
             		+ poss[pos].company.name + "</b>";
             		if(poss[pos].startDate != null){
             			positionsText += " (" + poss[pos].startDate.month + "/" + poss[pos].startDate.year;
		             	if(poss[pos].endDate != null){
		             		positionsText += " till " + poss[pos].endDate.month + "/" + poss[pos].endDate.year + ")";
		             	} else {
		             		positionsText += " till now)";
		             	}
             		}
         	}
         } else {
			skillsText += "N/A";	
         }
     	
         div.innerHTML += "<li> <img src=\"" + profileImageURL + "\" /> <a href=\"" + url + "\">" + nameText + 
         "</a> is " + distanceText + educationText + positionsText + "</li><br/>";
     }
 
     div.innerHTML += "</ul>";
}
</script>
</head>
<body>
<script type="IN/Login"></script>
<div id="peopleSearchForm"></div>
<div id="peopleSearchResults"></div>
<div id="errorField"></div>
</body>
</html>