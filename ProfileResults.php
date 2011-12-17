<html>
<head>
<script type="text/javascript" src="http://platform.linkedin.com/in.js">
  api_key: 9dpl6wmrr57o 
  authorize: true
  onLoad : displayProfile
</script>

<script>
function displayProfile(){
 alert("hi");
 IN.API.Profile()
  .fields(["id", "firstName", "lastName", "pictureUrl","headline"])
  .params({"id":S5LaA6z1wD})
  .result(function(result) {
  	
    profile = result.values[0];
    alert("ab"+profile.firstName);
    var div = document.getElementById("profileDisplay");
    div.innerHTML +=  profile.firstName + 
         profile.lastName + profile.headline + "</li><br/>";
   });
}
</script>

</head>
<body>
<div id="profileDisplay"></div>
HI


</body>

</html>
