function new_to_do()
{
	var what_to_do = prompt('Que souhaitez-vous ajouter ?');
	var list = document.getElementById('ft_list');
	console.log(list);
	var div = document.createElement('div');
	div.textContent = what_to_do;
	var onclick = document.createAttribute('onclick');
	onclick.value = 'delete_to_do(this)';
	div.setAttributeNode(onclick);
	list.insertBefore(div, list.firstChild);
}

function delete_to_do(element)
{
	if (confirm('Etes-vous sur de vouloir supprimer cet element ?'))
	{
		var list = document.getElementById('ft_list');
		list.removeChild(element);
	}
}
