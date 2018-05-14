<?php
//login pagina
include('scripts/header.php');

session_start();
if(isset($_SERVER['HTTP_REFERER'])) {
    $_SESSION['lastVisited'] = $_SERVER['HTTP_REFERER'];
}
/** notify
 * 0 = geen gebruikersnaam maar wel een wachtwoord
 * 1 = geen wachtwoord maar wel gebruikersnaam
 * 2 = allebei niet.
 * 3 = combinatie gebruikersnaam/wachtwoord bestaat niet
 */




?>


    <div class="uk-card uk-card-default uk-card-body uk-width-1-4@m uk-margin-auto uk-margin-xlarge-top uk-margin-xlarge-bottom">
        <h3 class="uk-card-title uk-text-center uk-margin-bottom">Inloggen bij EenmaalAndermaal</h3>
        <?php
        if(isset($_GET['notify'])){
            switch($_GET['notify']){
                case 0:
                    echo '<p class="uk-text-danger">Vul een gebruikersnaam in.</p>';
                    break;
                case 1:
                    echo '<p class="uk-text-danger">Vul een wachtwoord in.</p>';
                    break;
                case 2:
                    echo '<p class="uk-text-danger">Vul een gebruikersnaam en wachtwoord in.</p>';
                    break;
                case 3:
                    echo '<p class="uk-text-danger">Deze combinatie gebruikersnaam en wachtwoord bestaat niet.</p>';
                    break;
            }
        }
        ?>

        <form method="POST" action="scripts/login-check.php">

            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                    <input class="uk-input <?php if(isset($_GET['notify'])){if($_GET['notify'] == 0 || $_GET['notify'] ==2){echo "uk-form-danger";}}?>" type="text" name="username" id="usernameField" placeholder="Gebruikersnaam" value="<?php if(isset($_POST['username'])){echo $_GET['username'];} ?>" required>


                </div>
            </div>


            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon: lock"></span>
                    <input class="uk-input <?php if(isset($_GET['notify'])){if($_GET['notify'] == 1 || $_GET['notify'] ==2){echo "uk-form-danger";}}?>" type="text" name="password" id="passwordField" placeholder="Wachtwoord" required>

                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <input class="uk-input uk-button-primary" type="submit" name = "submit "id="loginSubmit" value="Inloggen">
                </div>
            </div>

            <!-- TODO: href veranderen naar wachtwoord vergeten pagina -->
            <p class="uk-text-center"><a href="#">Wachtwoord vergeten?</a></p>

            <hr class="uk-divider-icon">


            <!-- TODO: href veranderen naar registreer pagina -->
            <p class="uk-text-center">Heeft u nog geen account? <a href="registration.php">Registreer</a> eenvoudig.</p>



        </form>

    </div>


<?php
include('scripts/footer.php')

?>