<html>

<head>

<script type="text/javascript">
	function goToNextPage(){
		location.href = "linkedInPeopleSearch2.php";
	}

	
//	LinkedIn
//	api key: rbjecyqtr9pn
//	secret key: c3Z22HhLxFY6FUIB
</script>

<script type="text/javascript" src="http://platform.linkedin.com/in.js">
  api_key: rbjecyqtr9pn
  authorize: true
</script>

</head>
<body>

<?php
echo "<h1>Welcome to RECRU SOCIAL</h1>";
 $test ="http://www.gmail.com";
?>


<form>
	
	
	<p>Full Member Profile</p>
	
	<script type="IN/FullMemberProfile" data-id="S5LaA6z1wD"></script>
	
	<script type="IN/MemberData" data-ids="S5LaA6z1wD">
<ul>
  <?js for (var key in $("*")) { ?>
  <li>
    <a href="<?js= $(key).publicProfileUrl ?>">
      <?js if ($(key).pictureUrl) { ?>
        <img src="<?js= $(key).pictureUrl ?>"></img>
      <?js } ?>
      <?js= $(key).firstName ?>
      <?js= $(key).lastName ?>
      <?js= $(key).lastName ?>
      <?js= $(key).lastName ?>
      <?js= $(key).lastName ?>
      <?js= $(key).lastName ?>
      <?js= $(key).lastName ?>
    </a>
  </li>
  <?js } ?>
</ul>
</script>
</form>
