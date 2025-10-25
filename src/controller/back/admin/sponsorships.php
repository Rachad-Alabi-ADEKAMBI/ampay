<?php
require_once './src/model/back/admin/sponsorships.php';


function sponsorshipsPage()
{
    require './src/view/back/admin/sponsorships.php';
}


function getAllsponsorships()
{
    fetchAllSponsorships();
}
