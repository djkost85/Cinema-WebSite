{mask:main}
<!--<h1>Gestion des newsletters</h1>
 <ul>
	<li><a href="index.php?page=NewsLettersPage&action=edit">créer une nouvelle newsletters</a></li>
	<li><a href="index.php?page=NewsLettersPage&action=manage">gérer les newsletters programmées</a></li>
	<li><a href="index.php?page=NewsLettersPage&action=subscriber">gérer la liste des abonnés</a></li>
</ul>-->

<ul>
	{newsletters}
</ul>

{/mask}

{mask:newsletters}
<li><a href="index.php?page=NewsLettersPage&action=edit&id={id}">{object}</a></li>
{/mask}
