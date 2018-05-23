<?php
include('database-connect.php');


/*  Deze functie checkt of je nog in de session bent.
   Dit gebeurd op iedere pagina opnieuw zodat hij weet ofdat de user nog in de session zit.*/
function CheckLogin ()
{
    if (isset($_SESSION['username'])) {
        return true;
    } else {
        return false;
    }
}

?>