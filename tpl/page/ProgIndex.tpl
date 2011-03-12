{*Page d'index de la page prog*}
{mask:main}
<h1>Programmation</h1>
<h2>Saisie</h2>
<h3>Import à partir d'un fichier texte</h3>
A venir prochainement ...
{* <form method="post" action="index.php?page=ProgPage&action=Import">
	<imput type="hidden" name="type" value="file" />
	<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
	Fichier : <input type="file" name="progFile" /> <input type="submit" />
</form> *}
<h3>A partir d'allociné</h3>
<a href="index.php?page=ProgPage&action=Import">Go</a>
<h3>Manuellement</h3>
A venir prochainement ...

<h2>Consultation</h2>
<ul>
{programmation}
</ul>
<a href="index.php?page=ProgPage&display=Consult">Consulter</a>

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
