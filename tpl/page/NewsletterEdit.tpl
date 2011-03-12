{mask:main}
	<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
	<!-- <form>
		<input type="hidden" id="orig_content" value="{contents}" />
	</form> -->
	<form method="post" action="index.php?page=NewsLettersPage&action=edit">
		Si vous désirez importer la programmation saissez les dates incluses<br />  		
		<input type="text" name="startDate" size="10" /><input type="button" name="import" value="calend"/><input type="text" name="endDate" /><input type="button" name="import" value="calend"/><br />
		<input type="button" name="import" value="importer" /><br /><br />
		<label for="object">Objet :</label><input id="object" name="object" type="text" value="{object}" size="80" /><br /><br />
		
		<label for="contents">Contenu :</label><br /><textarea class="ckeditor" id="contents" name="contents" rows="30" cols="50">{contents}</textarea><br />
		<label for="testMailAddress">Tester la newsletter, email :</label><input type="text" name="testMailAddress" ><input type="submit" name="testMail" value="tester" /><br />
		<input type="submit" name="save" value="save" /> <input type="submit" name="back" value="back" />
	</form>
{/mask}