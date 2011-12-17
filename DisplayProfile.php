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
     url = window.location.href;
	id= url.substring( url.indexOf("=")+1);
	alert(id);
	}
 
</script>
</head>
<body>
<script type="IN/Login"></script>
<div id="peopleSearchResults"></div>
<script type="IN/MemberData" data-ids="S5LaA6z1wD";>
<ul>
  <?js for (var key in $("*")) { ?>
  <li>
    <a href="<?js= $(key).publicProfileUrl ?>">
      <?js if ($(key).pictureUrl) { ?>
        <img src="<?js= $(key).pictureUrl ?>"></img>
      <?js } ?>
      <?js= $(key).firstName ?>
      <?js= $(key).lastName ?>
      
    </a>
  </li>
  <?js } ?>
</ul>
</script>

</body>
</html>