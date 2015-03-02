<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<html>
<head>
	<title>Αυτόματος Υπολογισμός Βαθμού Πτυχίου</title>
	<link rel="stylesheet" type="text/css" href="index.css">

<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//tsaklidis.gr/piwik/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 3]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//tsaklidis.gr/piwik/piwik.php?idsite=3" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->

</head>
<body>
<p class="msg0">Αυτόματος υπολογισμός βαθμού πτυχίου</p><br>

<p class="msg">Ο υπολογισμός δεν έχει <span style="font-weight:bold;">ΚΑΜΙΑ</span>
	σχέση με το ΤΕΙ ΑΜΘ ή την γραμματεία <br><br>
	Οι κωδικοί δεν αποθηκεύονται <span style="font-weight:bold;">ΠΟΥΘΕΝΑ</span>,
	απλα προωθούνται στην γραμματεία και στην συνέχεια γίνονται υπολογισμοί<br>
	Αν κάποιος αμφιβάλει ας μη κάνει χρήση της σελίδας.<br><br>
	Η σελίδα κάνει χρήση <span style="font-weight:bold;">https</span> σε αντίθεση με την γραμματεία μας.
<br><span style="font-size:10px; color:green;">Μη λέτε κακίες για τα γραφιστικά</span>
</p>
<br>
<div class="wraper">
	<form action="<?php echo htmlspecialchars('check.php'); ?>" id="login" method="post" class="form">
		<table >
			<th id="th">Είσοδος Φοιτητή</th>
			<tr>
				<td>
					Όνομα Χρήστη: <input type="text" name="username" value="" class="input" id="username" ><br>
					Κωδικός πρόσβασης: <input type="password" name="password" value=""  class="input" id="password" ><br>
				</td>	
			</tr>		
			<tr>
				<td >
					<input type="submit" value="Log in" name="login" class="button" id="login"><br>
					<?php if (isset($_GET['msg']) ) {
						if ($_GET['msg']=="empty") {
							echo '<span style="color:red">Βάλε όνομα και κωδικό</span>';
						}
						elseif ($_GET['msg']=="pass") {
							echo '<span style="color:red">Λάθος στοιχεία</span>';
						}
						else{
							echo '<span style="color:red; font-size:23;">ΓΙΑΤΙ ΜΕ ΕΝΟΧΛΕΙΣ ??</span>';
						}
						
					}?>
				</td>
			</tr>
		</table>	
	</form>

</div>


</body>
</html>