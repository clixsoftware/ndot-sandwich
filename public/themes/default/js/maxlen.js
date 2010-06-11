/*
 * 
*/
        function Count_MaxLength(Object,event,id)
        { 


                var val=event.which;
                if(Object.value.length<140)
                {
                        document.getElementById(id).innerHTML = 139-Object.value.length + " Characters left";
                        return true;
                }
                else
                {
                        if(val<30)
                        {
                        return true;
                        }
                        else
                        {
                        //alert("max 140 char");
                        return false;
                        }
                }


        }

