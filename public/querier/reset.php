<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

    require_once("include.php");
    protect();

    $projectReset = 0;
    $defaultReset = 0;

    if($_POST['default'] == 1) {
        runScript("recreate_default.sh");
        $defaultReset = 1;
    }

    if($_POST['project'] == 1) {
        runScript("recreate_project.sh");
        $projectReset = 1;
    }
    
    if($_POST['all'] == 1) {
        runScript("recreate_default.sh");
        runScript("recreate_project.sh");
        $defaultReset = 1;
        $projectReset = 1;
    }
    
?>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">        
    </head>
    <body>
        <br />
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <a href="/index.html" class="btn btn-primary">Terug naar voorpagina</a>
                </div>
            </div>
            <br />
            <?php if($projectReset or $defaultReset) { ?>
            <div class="alert alert-warning">
                <?php if($projectReset) { ?>
                    <strong>Project database</strong> is opnieuw aangemaakt.<br />
                <?php } ?>
                <?php if($defaultReset) { ?>
                    <strong>Aangeleverde databases</strong> zijn opnieuw aangemaakt.<br />
                <?php } ?>
            </div>
            <?php } ?>
            
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Acties
                        </div>
                        <div class="panel-body">
                            <form action="reset.php" method="post">
                                <button class="btn btn-warning" name="project" value="1" onclick="return confirm('Weet je zeker dat je je eigen PROJECT DATABASE wilt aanmaken? Dit kan NIET ongedaan gemaakt worden!');">Opnieuw aanmaken van je eigen <strong>project-database</strong></button>
                                <button class="btn btn-warning" name="default" value="1">Opnieuw aanmaken van de door de docent  <strong>aangeleverde databases</strong></button>
                                <button class="btn btn-danger" name="all" value="1" onclick="return confirm('Weet je zeker dat je je eigen PROJECT DATABASE en de aangeleverde databases opnieuw wilt aanmaken? Dit kan NIET ongedaan gemaakt worden!');">Opnieuw aanmaken <strong>alle databases</strong></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
