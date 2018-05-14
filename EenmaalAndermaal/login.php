<?php
//login pagina
include('scripts/header.php')


?>


    <div class="uk-card uk-card-default uk-card-body uk-width-1-4@m uk-margin-auto uk-margin-xlarge-top uk-margin-xlarge-bottom">
        <h3 class="uk-card-title uk-text-center uk-margin-bottom">Inloggen bij EenmaalAndermaal</h3>

        <form>

            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                    <input class="uk-input" type="text" placeholder="Gebruikersnaam">
                </div>
            </div>


            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon: lock"></span>
                    <input class="uk-input" type="text" placeholder="Wachtwoord">
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <input class="uk-input uk-button-primary" type="button" value="Inloggen">
                </div>
            </div>

            <!-- TODO: href veranderen naar wachtwoord vergeten pagina -->
            <p class="uk-text-center"><a href="#">Wachtwoord vergeten?</a></p>

            <hr class="uk-divider-icon">

            <!-- TODO: href veranderen naar registreer pagina -->
            <p class="uk-text-center">Heeft u nog geen account? <a href="#">Registreer</a> eenvoudig.</p>



        </form>

    </div>


<?php
include('scripts/footer.php')

?>