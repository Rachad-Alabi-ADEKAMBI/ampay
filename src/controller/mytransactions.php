<?php
require_once './src/model/myTransactions.php';


function myTransactionsPage()
{

    require './src/view/back/user/mytransactions.php';
}


function myTransactionsList()
{
    fetchMyTransactions();
}
