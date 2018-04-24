<?php
//rubriekenboom
function getCategoryOverview($databasehandler)
{
    $previousCategoryNumber = 0;
    $alphabet = range('A', 'Z');
    $categoryOverview = "";
    foreach ($alphabet as $letter) {
        $categoryOverview .= '<section class="mainCategorySection"><h1>' . $letter . '</h1>';
        $mainCategoriesData = $databasehandler->query("SELECT rubrieknummer, rubrieknaam  FROM Rubriek r WHERE volgnummer = rubrieknummer");
        while ($mainCategoryRow = $mainCategoriesData->fetch()) {
            //TODO: UIkit element gebruiken ipv section met class
            $categoryOverview .= '<h2>' . $mainCategoryRow['rubrieknaam'] . '</h2>';
            $previousCategoryNumber = $mainCategoryRow['rubrieknummer'];

            if ($count = $databasehandler->query("SELECT COUNT(*) FROM Rubriek r WHERE Rubriek = " . $previousCategoryNumber)) {
                if ($count->fetchColumn() > 0) {
                    $subCategoryData = $databasehandler->query("SELECT rubrieknummer, rubrieknaam FROM Rubriek r WHERE Rubriek = " . $previousCategoryNumber);
                    while ($subCategoryRow = $subCategoryData->fetch()) {
                        //TODO: iets.php veranderen naar werkelijke pagina.
                        $categoryOverview .= '<a href="iets.php?categoryID=' . $subCategoryRow['rubrieknummer'] . '">' . $subCategoryRow['rubrieknaam'] . '</a>';
                        $previousCategoryNumber = $subCategoryRow['rubrieknummer'];
                        if ($count2 = $databasehandler->query("SELECT COUNTR(*) FROM Rubriek r WHERE Rubriek =" . $previousCategoryNumber)) {
                            if ($count2->fetchColumn() > 0) {
                                $subCategoryData2 = $databasehandler->query("SELECT rubrieknummer, rubrieknaam FROM Rubriek r WHERE Rubriek = " . $previousCategoryNumber);
                                while ($subCategoryRow2 = $subCategoryData2->fetch()) {
                                    $categoryOverview .= '<a href="iets.php?categoryID=' . $subCategoryRow2['rubrieknummer'] . '">' . $subCategoryRow2['rubrieknaam'] . '</a>';
                                }
                            }
                        }
                    }
                }
            }
            //TODO: UIkit element gebruiken ipv section met class
            $categoryOverview .= '</section>';
        }
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

function getAlphabetList()
{
    $alphabet = range('A', 'Z');
    $alphabetList = '<ul class="uk-pagination">';
    foreach ($alphabet as $letter) {
        $alphabetList .= '<li><a href="">' . $letter . '</a></li>';
    }
    $alphabetList .= '</ul>';
    return $alphabetList;
}

?>


