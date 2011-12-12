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
function searchByNameLinkedIn(){
//	var searchName=form.searchFormName.value;
	var searchName=document.getElementById("searchTextBoxId").value;	
	alert("Search Name: "+searchName);
	var firstLastName=searchName.split(" ");
	alert("First Name: "+firstLastName[0]+" Last Name: "+firstLastName[1]);
	IN.API.PeopleSearch()
  	.fields("firstName", "lastName", "positions")
		.params({"first-name": firstLastName[0], "last-name": firstLastName[1]})
  	.result(displayPeopleSearch)
  	.error(displayPeopleSearchError);
}

function displayPeopleSearch(peopleSearch) {
  	var peopleSearchDiv = document.getElementById("peoplesearch");
	     
  	var members = peopleSearch.people.values; // people are stored in a different spot than earlier example
  	for (var member in members) {
	    // but inside the loop, everything is the same
	    // extract the title from the members first position
	    	peopleSearchDiv.innerHTML += "<p> <a href='' " + members[member].firstName + " " + members[member].lastName 
	      		+ " is a " + members[member].positions.values[0].title + ".</p>";
  	}
}

function displayPeopleSearchError(error) {
  	profilesDiv = document.getElementById("peoplesearch");
  	profilesDiv.innerHTML = "<p>Oops! </p> ERROR:" + error.message;
	console.log(error);
}



</script>
 
 </head>
 
<body>
<form id="searchFormId" name="searchFormName"  method="get">
Enter Name: <input id="searchTextBoxId" type="text"  name="Enter name" />
<input type="button" onClick="searchByNameLinkedIn()" value="Search" />
</form>
<br/>Result<br/>
<div id="peoplesearch"></div>

</body>

</html>