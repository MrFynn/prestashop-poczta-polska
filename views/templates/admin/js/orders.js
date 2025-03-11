function sendBulkAction(form, action)
{
	String.prototype.splice = function(index, remove, string) {
		return (this.slice(0, index) + string + this.slice(index + Math.abs(remove)));
	};
        
	var form_action = $(form).attr('action');

	if (form_action.replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g,'').replace(/\s+/g,' ') == '')
		return false;

        if(action === 'submitBulkprintLabelsorders'){
          $(form).attr('target', '_blank');
        }
	if (form_action.indexOf('#') == -1)
		$(form).attr('action', form_action + '&' + action);
	else
		$(form).attr('action', form_action.splice(form_action.lastIndexOf('&'), 0, '&' + action));

	$(form).submit();
        $(form).removeAttr('target');
}

function checkDelBoxes(pForm, boxName, parent)
{
  for (i = 0; i < pForm.elements.length; i++){
    if (pForm.elements[i].name == boxName){
      if(!pForm.elements[i].disabled){
        pForm.elements[i].checked = parent;
      }
    }
  }
}
