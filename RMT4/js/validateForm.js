//Script to validate building input form

var error="PLEASE ENTER:\n\n";    //construct error messsage

function validateform()
{
	if(document.form-A.eMail.value=="")
		{error += "Email\n";}
	if(document.form-A.buildingName.value=="")
		{error += "Building Name\n";}
	if(document.form-A.floors.value=="")
		{error += "Number of Floors\n";}
	if(document.form-A.floorArea.value=="")
		{error += "Total Floor Area\n";}
	if(document.form-A.windowPercent.value=="")
		{error += "Total Percentage of Windows\n";}
	
	if(error=="PLEASE ENTER:\n\n")
		{
			return true;
		}
	else
		{
			alert(error);
			error="PLEASE ENTER:\n\n";
			return false;
		}//end if error
}//end validateform
