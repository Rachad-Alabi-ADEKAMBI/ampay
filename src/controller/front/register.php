<?php
require_once './src/model/front/register.php';


function registerPage()
{

    require './src/view/front/register.php';
}


function getSponsor()
{
    if (!isset($_GET['ref'])) {
        header('Content-Type: application/json', true, 400);
        echo json_encode(['error' => 'No referral ID provided.']);
        exit;
    }

    $ref = $_GET['ref'];

    // Appelle la fonction fetchSponsor en lui passant le paramètre
    fetchSponsor($ref);
}
