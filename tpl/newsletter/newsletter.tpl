{mask:main}
<h1>Programmation du {dateBegin} au {dateEnd}</h1>
{film}
{/mask}

{mask:film}
<p><img src="{posterSrc}" heigh="200" width="100" /> {title}<br/>{resume}<br />{avertissement}<ul>{prog}</ul>
</p>
{/mask}

{mask:prog}
<li>{day}<ul>{time}</ul></li>
{/mask}

{*{mask:time}
<li>{hour}</li>
{/mask}*}
