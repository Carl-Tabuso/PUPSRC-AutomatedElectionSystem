<?php
include_once str_replace('/', DIRECTORY_SEPARATOR, 'includes/classes/file-utils.php');
require_once FileUtils::normalizeFilePath('includes/classes/db-connector.php');
require_once FileUtils::normalizeFilePath('includes/session-handler.php');
include_once FileUtils::normalizeFilePath('includes/error-reporting.php');

if(isset($_SESSION['voter_id']) && (isset($_SESSION['role'])) && ($_SESSION['role'] == 'Student Voter') && ($_SESSION['status'] == 'Active')) {

  // if((isset($_SESSION['vote_status'])) && ($_SESSION['vote_status'] == 'Voted')){

     // ------ SESSION EXCHANGE
     include FileUtils::normalizeFilePath('includes/session-exchange.php');
     // ------ END OF SESSION EXCHANGE

  $connection = DatabaseConnection::connect();
  // Assume $connection is your database connection
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Feedback and Suggestions</title>
  <link rel="icon" type="image/x-icon" href="images/resc/ivote-favicon.png">
  
  <!-- Montserrat Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <!-- Fontawesome CDN Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
  <!-- Bootstrap 5 code -->
  <link type="text/css" href="../vendor/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../src/styles/feedback-suggestions.css">
  <link rel="stylesheet" href="<?php echo '../src/styles/orgs/' . $org_acronym . '.css'; ?>">

</head>

<body>
  
<nav class="navbar navbar-expand-lg navbar-light bg-white">
  <div class="container">
    <div class="navbar-brand spacing">
      <img src="../src/images/resc/ivote-logo.png" alt="Logo" width="50px">
   </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item dropdown d-none d-lg-block">
          <a class="nav-link main-color" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <b>Hello, Iskolar</b><i class="fas fa-user-circle main-color ps-3" style="font-size: 23px;"></i> <i class="fas fa-chevron-down text-muted ps-2"></i>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="includes/voter-logout.php">Logout</a>
          </div>
        </li>
        <li class="nav-item d-lg-none">
          <a class="nav-link" href="includes/voter-logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <div class="row">
    <div class="col">
      <div class="p-4 title main-color text-center spacing">
        <h3><b>FEEDBACK & SUGGESTIONS</b></h3>
      </div>
    </div>
  </div>
</div>

<form method="post" action="../src/includes/insert-feedback.php" id="feedbackForm">

  <div class="container mt-4">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="reminder">
          <div class="text-position main-color text-center">
            <b>How was your experience?</b>
          </div>
          <div class="subtitle text-center pt-2">We would like your feedback to improve our website!</div> 
            <div class="row">
              <div class="emoji">
               <ul class="feedback pb-4">
                <li class="angry" data-value="Very Unsatisfied" title="Very Unsatisfied">
                    <div>
                        <svg class="eye left">
                            <use xlink:href="#eye">
                        </svg>
                        <svg class="eye right">
                            <use xlink:href="#eye">
                        </svg>
                        <svg class="mouth">
                            <use xlink:href="#mouth">
                        </svg>
                    </div>
                </li>
                <li class="sad" data-value="Unsatisfied" title="Unsatisfied">
                    <div>
                        <svg class="eye left">
                            <use xlink:href="#eye">
                        </svg>
                        <svg class="eye right">
                            <use xlink:href="#eye">
                        </svg>
                        <svg class="mouth">
                            <use xlink:href="#mouth">
                        </svg>
                    </div>
                </li>
                <li class="ok" data-value="Neutral" title="Neutral">
                    <div></div>
                </li>
                <li class="good" data-value="Satisfied" title="Satisfied">
                    <div>
                        <svg class="eye left">
                            <use xlink:href="#eye">
                        </svg>
                        <svg class="eye right">
                            <use xlink:href="#eye">
                        </svg>
                        <svg class="mouth">
                            <use xlink:href="#mouth">
                        </svg>
                    </div>
                </li>
                <li class="happy" data-value="Very Satisfied" title="Very Satisfied">
                    <div>
                        <svg class="eye left">
                            <use xlink:href="#eye">
                        </svg>
                        <svg class="eye right">
                            <use xlink:href="#eye">
                        </svg>
                    </div>
                </li>
            </ul>
            <div class="pb-2"></div>

            <input type="hidden" id="rating" name="rating" value="">
        
                  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                      <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 4" id="eye">
                          <path d="M1,1 C1.83333333,2.16666667 2.66666667,2.75 3.5,2.75 C4.33333333,2.75 5.16666667,2.16666667 6,1"></path>
                      </symbol>
                      <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 7" id="mouth">
                          <path d="M1,5.5 C3.66666667,2.5 6.33333333,1 9,1 C11.6666667,1 14.3333333,2.5 17,5.5"></path>
                      </symbol>
                  </svg>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container mt-4 mb-4">
    <div class="border-frame">
      <div class="row container-spacing pb-4">
        <div class="col">
          <div class="pt-lg-5 pt-3 main-color">
            <b>Please leave more of your feedback below:</b>
          </div>
        </div>
      </div>
      <div class="row container-spacing pb-2">
        <div class="col">
          <textarea name="feedback" id="feedback" class="form-control " rows="10" placeholder="Type your feedback here..."></textarea>
        </div>
      </div>
      
      <div class="row pe-4 pb-4">
        <div class="col">
          <div class="text-center mt-3 text-lg-end">
            <button type="submit" id="submitFeedbackBtn" class="button-submit main-bg-color">Skip Feedback</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
</body>


<?php include_once __DIR__ . '/includes/components/footer.php'; ?>

  
<script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../src/scripts/feedback-suggestions.js"></script>


</html>
<?php
  //} else{
   // header("Location: ballot-forms.php");
 // }
} else {
  header("Location: landing-page.php");
}
?>