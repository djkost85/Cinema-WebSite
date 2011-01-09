{mask:main}
<h1>Programmation</h1>
<h2>Saisie</h2>
<h3>Import à partir d'un fichier texte</h3>
<form method="post" action="index.php?page=Prog&display=Import">
	<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
	Fichier : <input type="file" name="progFile" /> <input type="submit" />
</form>
<h3>A partir d'allociné</h3>
A venir prochainement ...
<h3>Manuellement</h3>
A venir prochainement ...

<h2>Consultation</h2>
<ul>
{programmation}
</ul>
<a href="index.php?page=Prog&display=Archive">Consulter archive</a>

{/mask}

{mask:programmation}
<li>{week}
	<ul>
		{films}
	</ul>
</li>
{/mask}

{mask:films}
<li>{titre}-{dates}</li>
{/mask}