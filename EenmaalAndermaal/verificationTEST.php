<?php
$pageTitle = 'Verificatie';
require_once('scripts/header.php');
include('scripts/database-connect.php');
include('scripts/country.php');
include('scripts/database-connect.php');
include('scripts/question.php');

echo '
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
';

$match = 0;
/*
if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    // Verify data
    $email = $_GET['email']; // Set email variable
    $hash = $_GET['hash']; // Set hash variable
*/
$form = '

<body>

<form action="scripts/newUser.php?email=' . $email . '" method="post" >
        
    <div class="uk-card uk-card-default uk-card-body uk-width-1-2@m uk-margin-auto uk-margin-top uk-margin-bottom">
      <h3 class="uk-card-title uk-text-center uk-margin-bottom">Registreren bij EenmaalAndermaal</h3>

    <input type="text" name="email" value="' . $_GET['email'] . '" hidden>
    <input type="text" name="hash" value="' . $_GET['hash'] . '" hidden>

<div class="uk-margin uk-form-horizontal">
    <label class="uk-form-label" for="Voornaam">Voornaam *:</label>
    <input class="uk-input" type="text" placeholder="Voornaam" name="Voornaam"';
if (isset($_GET['firstname'])) {
    $form .= 'value="' . $_GET['firstname'] . '"';
}
$form .= 'required>
</div>

<div class="uk-margin uk-form-horizontal">
    <input class="uk-input" type="text" placeholder="Achternaam" name="Achternaam"';
if (isset($_GET['lastname'])) {
    $form .= 'value="' . $_GET['lastname'] . '"';
}
$form .= 'required>
</div>

<div id="locationField uk-margin uk-form-horizontal">
                        <input id="autocomplete" class="form-control uk-input" placeholder="Eerste adres"
                               onFocus="geolocate()" type="text"'; if(isset($_GET['firstAddress'])){$form .='value="'.$_GET['firstAddress'].'"';}
$form.='required>
                    </div>


<div class="uk-margin uk-form-horizontal">
    <input class="uk-input" type="text" placeholder="Tweede adres (optioneel)" name="TweedeAdres"';
if (isset($_GET['secondAddress'])) {
    $form .= 'value="' . $_GET['secondAddress'] . '"';
}
$form .= '>
</div>

<div class="col-md-12">
                        <tr>
                            <td class="label">City</td>
                            <!-- Note: Selection of address components in this example is typical.
                            You may need to adjust it for the locations relevant to your app. See
                            https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform
                            -->
                            <td class="wideField" colspan="3">
                            <input class="field" id="locality" disabled="true"></input></td>
                        </tr>
                        <tr>
                            <td class="label">State</td>
                            <td class="slimField">
                            <input class="field uk-margin uk-form-horizontal" id="administrative_area_level_1" disabled="true"></input></td>
                            <td class="label">Zip code</td>
                            <td class="wideField">
                            <input class="field uk-margin uk-form-horizontal" id="postal_code" disabled="true"></input></td>
                        </tr>
                        <tr>
                            <td class="label">Country</td>
                            <td class="wideField" colspan="3">
                            <input class="field uk-margin uk-form-horizontal"
                                                                     id="country" disabled="true"></input></td>
                        </tr>
                </div>
            </div>

<div class="uk-margin uk-form-horizontal">
    <input class="uk-input" type="date" name="Datum"';
if (isset($_GET['birthDate'])) {
    $form .= 'value="' . $_GET['birthDate'] . '"';
}
$form .= 'required>
</div>';
if (isset($_GET['usernameError']) && $_GET['usernameError'] == 1) {
    $form .= '<p class="uk-text-danger">Deze gebruikersnaam is al in gebruik.</p>';
}

$form .= '
<div class="uk-margin uk-form-horizontal">
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon" uk-icon="icon: user"></span>
        <input class="uk-input';
if (isset($_GET['usernameError']) && $_GET['usernameError'] == 1) {
    $form .= ' uk-form-danger';
}
$form .= '" type="text" placeholder="Gebruikersnaam" name="Gebruikersnaam" ';
if (isset($_GET['username'])) {
    $form .= 'value="' . $_GET['username'] . '"';
}
$form .= 'required>

    </div>
</div>

';
if (isset($_GET['passwordError']) && $_GET['passwordError'] == 1) {
    $form .= '<p class="uk-text-danger">De opgegeven wachtwoorden komen niet overeen.</p>';
}
$form .= '
<div class="uk-margin uk-form-horizontal">
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
        <input class="uk-input';
if (isset($_GET['passwordError']) && $_GET['passwordError'] == 1) {
    $form .= ' uk-form-danger';
}
$form .= '" type="password" placeholder="Wachtwoord" name="Wachtwoord"required>
    </div>
</div>

<div class="uk-margin uk-form-horizontal">
    <div class="uk-inline uk-width-1-1">
        <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
        <input class="uk-input';
if (isset($_GET['passwordError']) && $_GET['passwordError'] == 1) {
    $form .= ' uk-form-danger';
}
$form .= '" type="password" placeholder="Wachtwoord bevestigen" name="Wachtwoord_bevestigen" required>

    </div>
</div>


<div class="uk-margin uk-form-horizontal">
    <select class="uk-select" name="vraag"required>' .
    Get_question($dbh) . '
    </select>
    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Antwoord" name="Antwoord"';
if (isset($_GET['securityQuestionAnswer'])) {
    $form .= 'value="' . $_GET['securityQuestionAnswer'] . '"';
}
$form .= 'required>
    </div>
</div>


<div class="uk-margin">
    <div class="uk-inline uk-width-1-1">
        <input class="uk-input uk-button-primary" type="submit" name = "submit"  value="versturen">
    </div>
</div>


</div>
</form>
</body>';

echo $form;

echo "
<script>

    var placeSearch, autocomplete;
    var componentForm = {
    street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
// Create the autocomplete object, restricting the search to geographical
// location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

// When the user selects an address from the dropdown, populate the address
// fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
// Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

// Get each component of the address from the place details
// and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
</script>
";

echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8SOSgqOY5QRgFiZx0ZrAqzjuvnOOK86o&libraries=places&callback=initAutocomplete"
        async defer></script>';


//}
//else {
//TODO: uikit script melding: je kan alleen op deze pagina komen via de registratie-email
//header('Location: registration.php');
//}


//        <div class="uk-inline uk-width-1-1">
//            <input class="uk-input uk-button-primary" type="submit" name = "submit"  value="versturen">
//        </div>
//   </div>

//$search = $dbh->query("SELECT email, hash FROM Verificatie WHERE email='" . $email . "' AND hash='" . $hash . "'");
//while ($row = $search->fetch()) {
//    $match ++;
//}
//
//if ($match > 0){
//
//    $dbh->query("UPDATE Verificatie SET isGeactiveerd='1' WHERE email='" . $email . "' AND hash='" . $hash . "'");
//}


require_once('scripts/footer.php');

