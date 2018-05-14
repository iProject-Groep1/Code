<?php
require_once('scripts/header.php');
include('scripts/homepage-functions.php');


echo '
  <div class="uk-card uk-card-default uk-card-body uk-width-1-4@m uk-margin-auto uk-margin-xlarge-top uk-margin-xlarge-bottom">
    <h3 class="uk-card-title uk-text-center uk-margin-bottom">Registreren bij EenmaalAndermaal</h3>

            <form action="scripts/registration-functions.php" method="post">


                      <input class="uk-input" type="text" placeholder="Email" name="email">

                <div class="uk-margin">
                    <div class="uk-inline uk-width-1-1">

                        <input  class="uk-input uk-button-primary" "id="loginSubmit"  type="submit" value="Submit" name="submit">

                    </div>
                </div>

            </form>
            </div>
            </div>
</div>

';
require_once('scripts/footer.php');

//<div class="uk-margin">
//                    <div class="uk-inline">
//                        <span class="uk-form-icon uk-form-icon-flip uk-icon" uk-icon="icon: lock"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" ratio="1"> <rect fill="none" stroke="#000" height="10" width="13" y="8.5" x="3.5"></rect> <path fill="none" stroke="#000" d="M6.5,8 L6.5,4.88 C6.5,3.01 8.07,1.5 10,1.5 C11.93,1.5 13.5,3.01 13.5,4.88 L13.5,8"></path></svg></span>
//                        <input class="uk-input" type="text" placeholder="Verification Code" name="hash">
//                    </div>
//                </div>


?>
