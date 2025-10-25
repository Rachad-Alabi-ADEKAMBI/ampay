<?php
require_once './src/model/back/admin/transactions.php';


function transactionsPage()
{
    require './src/view/back/admin/transactions.php';
}

function getAllMessagesByListingId()
{
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'ID du listing manquant'
        ]);
        exit;
    }

    $listing_id = (int) $_GET['id'];
    fetchAllMessagesByListingId($listing_id);
}

function getAllListings()
{
    fetchAllListings();
}
