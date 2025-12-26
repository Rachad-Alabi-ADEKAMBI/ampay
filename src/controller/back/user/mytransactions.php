<?php
require_once './src/model/back/user/myTransactions.php';


function myTransactionsPage()
{

    require './src/view/back/user/mytransactions.php';
}


function myTransactionsList()
{
    fetchMyTransactions();
}


function createTransaction()
{
    // Appelle la fonction du modèle et capture la sortie
    $result = newTransaction();

    // Forcer le JSON pur
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result);
    exit;
}

function deleteTransaction()
{
    // Appelle la fonction du modèle
    modelDeleteTransaction();
}

function updateTransaction()
{
    updateListing();
}

function getCommentedTransactions()
{
    fetchCommentedTransactions();
}
