function new_to_do()
{
	var what_to_do = prompt('Que souhaitez-vous ajouter ?');
	if (what_to_do == '')
		return;
	var list = document.getElementById('ft_list');
	var div = document.createElement('div');
	div.textContent = what_to_do;
	div.setAttribute('onclick', 'delete_to_do(this)');
	list.insertBefore(div, list.firstChild);
	setCookie('todo', encodeURIComponent(list.innerHTML), 1);
}

function delete_to_do(element)
{
	if (confirm('Etes-vous sur de vouloir supprimer cet element ?'))
	{
		var list = document.getElementById('ft_list');
		list.removeChild(element);
		setCookie('todo', encodeURIComponent(list.innerHTML), 1);
	}
}

function setCookie(cname, cvalue, exdays)
{
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires="+d.toUTCString();
	document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname)
{
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++)
	{
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1);
		if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
	}
	return "";
}

function restore_to_do()
{
	var list = document.getElementById('ft_list');
	list.innerHTML = decodeURIComponent(getCookie('todo'));
}
