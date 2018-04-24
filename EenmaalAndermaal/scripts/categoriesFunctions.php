<?php
//rubriekenboom
function getCategoryOverview($databasehandler)
{
    $alphabet = range('A', 'Z');
    $categoryOverview = "";
    $mainCategoriesData = $databasehandler->query("SELECT rubrieknummer, rubrieknaam  FROM Rubriek r WHERE Rubriek IS NULL");
    while ($mainCategoryRow = $mainCategoriesData->fetch()) {
        //TODO: UIkit element gebruiken ipv section met class
        $categoryOverview .= '<section class="mainCategorySection"><h2>' . $mainCategoryRow['rubrieknaam'] . '</h2>';
        $subCategoryData = $databasehandler->query("SELECT rubrieknaam FROM Rubriek r WHERE Rubriek = " . $mainCategoryRow['rubrieknummer']);
        while ($subCategoryRow = $subCategoryData->fetch()) {
            //TODO: iets.php veranderen naar werkelijke pagina.
            $categoryOverview .= '<a href="iets.php?categoryID=' . $subCategoryRow['rubrieknummer'] . '">' . $subCategoryRow['rubrieknaam'] . '</a>';
        }
        //TODO: UIkit element gebruiken ipv section met class
        $categoryOverview .= '</section>';
    }
    return $categoryOverview;
}

function getHomepageCategoryOverview($databasehandler, $overviewSize)
{
    $homepageCategoryOverview = "";
    //TODO: Voorwerp_in_Rubriek aanpassen?
    $mainCategoriesData = $databasehandler->query("SELECT TOP" . $overviewSize . " rubrieknummer, rubrieknaam  FROM Rubriek r WHERE rubrieknummer IN (SELECT count(*), rubrieknummer FROM Voorwerp_in_Rubriek GROUP BY rubrieknummers ORDER BY count(*)))");
    while ($mainCategoryRow = $mainCategoriesData->fetch()) {
        $homepageCategoryOverview .= '<a href="iets.php?categoryID=' . $mainCategoryRow['rubrieknummer'] . '">' . $mainCategoryRow['rubrieknaam'] . '</a>';
    }
    return $homepageCategoryOverview;
}

function getAlphabetList(){
    $alphabet = range('A', 'Z');
    $alphabetList = '<ul class="uk-pagination">';
    foreach($alphabet as $letter){
        $alphabetList .= '<li><a href="">'.$letter.'</a></li>';
    }
    $alphabetList .= '</ul>';
    return $alphabetList;
}
?>


