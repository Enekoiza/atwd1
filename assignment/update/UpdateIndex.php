<?php

//!-------------------EXAMPLE--------------------------
//?http://localhost:8080/atwd1/assignment/update/?cur=EUR&action=PUT
//!-----------------------------------------------------

require_once("Update_Error_Handling.php");

extract($_GET);

if((isSet($action)) and (isSet($cur)))
{
    Update_Check_Errors($action, $cur);
}
elseif((isSet($action)) and (!isSet($cur)))
{
    Update_Check_Errors($action, NULL);
}
elseif((!isSet($action)) and (isSet($cur)))
{
    Update_Check_Errors(NULL, $cur);
}
else
{
    Update_Check_Errors(NULL, NULL);
}

echo "DONE";

?>