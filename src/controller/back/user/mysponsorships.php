<?php
require_once './src/model/back/user/mySponsorships.php';

function mySponsorshipsPage()
{

    require './src/view/back/user/mysponsorships.php';
}

function mySponsorshipsList()
{
    fetchMySponsorships();
}
