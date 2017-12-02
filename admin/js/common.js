arr = document.getElementsByName('arcID');
//arr = document.getElementsByTagName('input');
//arr = document.getElementsByClassName('first');
/*全选*/
function selAll()
{
	for(var i=0;i<arr.length;i++)
	{
		if(arr[i].type == 'checkbox')
		{
			arr[i].checked = true;
		}
	}
}
/*反选*/
function updateArc()
{
	for(var i=0;i<arr.length;i++)
	{
		if(arr[i].type == 'checkbox')
		{
			if(arr[i].checked == true)
			{
				arr[i].checked = false;
			}
			else
			{
				arr[i].checked = true;
			}
		}
	}
}
/*取消*/
function noSelAll()
{
	for(var i=0;i<arr.length;i++)
	{
		if(arr[i].type == 'checkbox')
		{
			arr[i].checked = false;
		}
	}
}
