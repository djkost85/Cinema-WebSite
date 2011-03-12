{mask:main}
	<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
	<!-- <form>
		<input type="hidden" id="orig_content" value="{contents}" />
	</form> -->
	<form method="post" action="index.php?page=NewsLettersPage&action=edit">
		Si vous désirez importer la programmation saissez les dates incluses<br />  		
		Du <input type="text" name="startDate" size="10" /> au <input type="submit" name="button" size="10" value="calend"/><input type="text" name="endDate" /><input type="button" name="import" value="calend"/><br />
		<input type="submit" name="import" value="importer" /><br /><br />
		<label for="object">Objet :</label><input id="object" name="object" type="text" value="{object}" size="80" /><br /><br />
		
		<label for="contents">Contenu :</label><br /><textarea class="ckeditor" id="contents" name="contents" rows="30" cols="50">{contents}</textarea><br />
		<label for="testMailAddress">Tester la newsletter, email :</label><input type="text" name="testMailAddress" value="{currentEmail}" ><input type="submit" name="testMail" value="tester" /><br />
		<input type="submit" name="save" value="save" /> <input type="submit" name="back" value="back" />
	</form>
{/mask}