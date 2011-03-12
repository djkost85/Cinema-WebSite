{mask:main}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta content="text/html; Charset=UTF-8" http-equiv="Content-Type" />
		<title>{title}</title>
		<style type="text/css">
			@import "css/index.css";
		</style>
	</head>
	<body>
	<div id="head">
		<div id="header">
		<h1>{title}</h1>
		</div>
		<div id="menu">			
			<ul>
				{menu}				
				</li>
			</ul>
		</div>
	</div>
	<div id="content">
{/mask}

{mask:menu}
	<li><a href="{url}" {selected} >{name}</a></li>
	{choose}
		{when: {hasSubMenu} == true }
			<ul>
			{submenu}
			</ul>
		{/when}
	{/choose}
{/mask}
{mask:submenu}
<li><a href="{url}" {selected}>{name}</a></li>
{/mask}